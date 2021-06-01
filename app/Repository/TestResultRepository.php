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

    public function getTestResult($sessionId){
        $testResult = TestResult::where('session_id', $sessionId)->first();
        if ($testResult == null )
            return [];

        //check for payment
        if (!$testResult->payment_status)
            return [
                'data'=>[],
                'payment_status'=> $testResult->payment_status,
            ];


        return [
            'data'=>$testResult->getResult($sessionId, true),
            'payment_status'=> $testResult->payment_status,
        ];
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
