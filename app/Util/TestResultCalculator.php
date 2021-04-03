<?php


namespace App\Util;


use App\Group;
use App\Questionnaire;
use App\QuestionnaireWeightPoint;
use App\Section;
use App\TestRecord;
use App\TestResult;

class TestResultCalculator
{
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

    private function convertToPercentage($numerator, $denominator){
        if ($numerator == 0)
            return 0;
        $percent = ($numerator/$denominator) * 100;
        return round($percent);
    }


}
