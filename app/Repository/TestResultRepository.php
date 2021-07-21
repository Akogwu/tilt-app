<?php


namespace App\Repository;


use App\Models\Group;
use App\Models\Questionnaire;
use App\Models\QuestionnaireWeightPoint;
use App\Models\Section;
use App\Models\Session;
use App\Models\TestRecord;
use App\Models\TestResult;

class TestResultRepository
{
    public function getMyTestResults($userId){

        $sessionWithResult = Session::where([['user_id', $userId],['completed', true]])->orderBy('created_at', 'desc')
            ->with('testResult');
        //TestResult::where('session_id')
        return $sessionWithResult->get();
    }

    public function getCompleteResult($sessionId){
        $testResult = TestResult::where('session_id', $sessionId)->first();
        if ($testResult == null )
            return [];
        $role = $testResult->session->user->role->role;
        $userData = [];
        if ($role =="STUDENT"){
            $user = $testResult->session->user;
            $student = $testResult->session->user->student;
            $userData = [
                'name'=>$user->name,
                'sex'=>$student->gender,
                'age'=>$student->age,
                'school'=>$student->school->name,
                'class'=>$student->class,
                'state'=>$student->state->name ?? '',
                'country'=>$student->country->name ?? '',
                'image_url'=> (is_null($user->image_url)) ? null : url($user->image_url)
            ];
        }elseif ($role =="PRIVATE_LEARNER"){
            $user = $testResult->session->user;
            $privaterLearner = $testResult->session->user->privateLearner;
            $userData = [
                'name'=>$user->name,
                'sex'=>$privaterLearner->gender,
                'age'=>$privaterLearner->age,
                'school'=>$privaterLearner->school,
                'class'=>$privaterLearner->class,
                'state'=>$privaterLearner->state->name ?? '',
                'country'=>$privaterLearner->country->name ?? '',
                'image_url'=> (is_null($user->image_url)) ? null : url($user->image_url)
            ];
        }else{//anonymous user viewing status
            $user = $testResult->session->user;
            $userData = [
                'name'=>$user->name,
                'sex'=>'Nil',
                'age'=>'Nil',
                'school'=>'Nil',
                'class'=>'Nil',
                'state'=>'Nil',
                'country'=>'Nil',
                'image_url'=> null
            ];
        }
        $groupScores = collect($testResult->group_score_detail);
        //return
        $summaryResultData = $groupScores->map(function ($item){
            $item = (object)$item;
            return[
                'group_name'=>Group::find($item->group_id)->name ?? '',
                'score'=>$item->group_percentage
            ];
        });


        return [
            'user'=> $userData,
            'summary_result' => $summaryResultData,
            'recommendations' => $this->getRecommendations($sessionId)
        ];
    }

    private function getRecommendations($sessionId){
        $testResult = TestResult::where('session_id', $sessionId)->first();
        $groups = Group::orderBy('name', 'asc')->get();

        //get only groupids
        $groupAnsweredIds = collect($testResult->group_score_detail)->map(function ($item){
            $item = (object)$item;
            return $item->group_id;
        });
        $sectionAnsweredIds = collect($testResult->section_score_detail)->map(function ($item){
            $item = (object)$item;
            return $item->section_id;
        });

        $data = array();
        //loop groups
        foreach ($groups as $group){
            //get only the group ids available in the group-score-detail
            if (in_array($group->id, $groupAnsweredIds->toArray())){

                //sections
                $groupSections = $group->sections;
                $sectionData = array();
                //get group sections
                foreach ($groupSections as $groupSection){
                    //get section details
                    if (in_array($groupSection->id, $sectionAnsweredIds->toArray())){
                        $labelData = $groupSection->questionnaires;//array();
                        foreach ($groupSection->questionnaires as $question){
                            //get test record for this question
                            $testRecord = TestRecord::where([
                                ['session_id',$sessionId],
                                ['questionnaire_id', $question->id]
                            ])->first();

                            if ($testRecord){
                                $labelData[]=[
                                    'score'=>$testRecord->weightPoint->grade_point,
                                    'color'=>$testRecord->weightPoint->colour_code ?? 0
                                ];
                            }
                        }
                        //get label data from the answers
                        $sectionData[] = [
                            'section_name'=>$groupSection->name,
                            'labels'=>$labelData,
                            'recommendation'=>$groupSection->recommendationMessage->question
                        ];
                    }
                }
            }
            $data[] = [
                'group_name'=>$group->name,
                'goroup_icon'=>$group->icon,
                'group_color'=>$group->color,
                'description'=> $group->description,
                'sections'=>$sectionData
            ];
        }

        return $data;
    }

    public function getTestResultSummary($sessionId){
        $testResult = TestResult::where('session_id', $sessionId)->first();
        if ($testResult == null )
            return [];
        $user = $testResult->session->user->fullname() ?? '';
        return [
             'data'=>$testResult->getResult($sessionId),
            'payment_status'=> $testResult->payment_status,
            'user_name'=>$user
        ];
    }

    public function getTestDetails($userId){
        $session = Session::where('user_id', $userId);
        $attempts = $session->count();
        $total_results = TestResult::whereIn('session_id', $session->pluck('id'))->count();
        return[
            'attempts'=>$attempts,
            'total_tests'=> $total_results
        ];
    }

    public function calculate($sessionId){
        $data =[];
        $groupData = [];
        $sectionData = [];
        $groups = Group::orderBy('name','asc')->get();
        $totalMaxWeightPoint = $totalAnswerWeightPoint = 0;

        foreach ($groups as $group){

            $sections = Section::where('group_id', $group->id)->orderBy('name', 'asc')->get();
            //travers all sections
            $sumMaxWp = $answerWp = $percentage = $groupScore = 0;
            foreach ($sections as $section){
                $questionnaires = Questionnaire::where('section_id', $section->id)->get();
                $testRecords = TestRecord::where('session_id', $sessionId)
                    ->whereIn('questionnaire_id', $questionnaires->pluck('id'))->get();
                //get sum of all max weightpoint
                foreach ($questionnaires as $questionnaire){
                    $sumMaxWp += $questionnaire->weightPoints->max('weight_point');
                }
                //get answers weight point
                foreach ($testRecords as $answer){
                    $wp = QuestionnaireWeightPoint::where('id', $answer->answer)->first();
                    //sum all answers weightpoint
                    if ($wp){
                        $answerWp += $wp->weight_point;
                    }
                }
                //section score
                $sectionData[]=[
                    'section_id'=>$section->id,
                    'section_score'=>$answerWp
                ];
                //sum group scores
                $groupScore += $answerWp;
            }
            $totalMaxWeightPoint += $sumMaxWp;
            $totalAnswerWeightPoint += $answerWp;
            $percentage = $this->convertToPercentage($answerWp, $sumMaxWp);
            $groupData[] = [
                'group_id'=>$group->id,
                'group_score'=>$groupScore,
                'group_percentage'=>$percentage
            ];

        }
        $totalAverageScore = $this->convertToPercentage($totalAnswerWeightPoint, $totalMaxWeightPoint);
        //update to test result table
        $newTestResult = TestResult::updateOrCreateModel(
            $sessionId,
            $totalAverageScore,
            $totalAnswerWeightPoint,
            $totalMaxWeightPoint,
            $sectionData,
            $groupData
        );

    }

    public static function getCountCompletedTest(){
        return Session::where('completed', true)->count();
    }

    public static function getCountUniqueLearnerCompletedTest(){

        return Session::where('completed', true)->distinct('user_id')->count();
    }


    private function convertToPercentage($numerator, $denominator){
        if ($numerator == 0)
            return 0;
        $percent = ($numerator/$denominator) * 100;
        return round($percent);
    }
}
