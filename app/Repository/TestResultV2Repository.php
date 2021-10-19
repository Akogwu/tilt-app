<?php


namespace App\Repository;


use App\Models\Group;
use App\Models\QuestionnaireWeightPoint;
use App\Models\TestRecord;
use App\Models\TestResult;

class TestResultV2Repository
{
    public function detailResult($sessionId){
        $testResult = TestResult::where('session_id', $sessionId)->first();
        if ($testResult == null )
            return [];
        $role = $testResult->session->user->role->role;
        $userData = $this->getUserDetail($role, $testResult);
        return[
            'user'=> $this,
            'report'=>[
                ''
            ],
            'session_id'=>$sessionId,
            'resources'=>[],
            'chart'=>[]

        ];
    }

    /*New update*/
    public function summaryResult($sessionId){
        $testResult = TestResult::where('session_id', $sessionId)->first();
        if ($testResult == null )
            return [];
        $role = $testResult->session->user->role->role;

        $userData = $this->getUserDetail($role, $testResult);

        $groupAnswered = collect($testResult->group_score_detail);
        //get all aswered sections
        $sectionAnswered = collect($testResult->section_score_detail)->map(function ($testResult){
            return $testResult['section_id'];
        });

        $summaryResultData = $groupAnswered->map(function ($item) use ($sectionAnswered, $sessionId){
            $item = (object)$item;
            $group = Group::find($item->group_id);
            //get all section
            $sections =  $group->sections->map(function($section) use ($sectionAnswered){
                //from answered sections
                if (in_array($section->id, $sectionAnswered->toArray())){
                    return[
                        'title'=>$section->name,
                        'icon'=>$section->icon,
                        'description'=>$section->description
                    ];
                }
            });
            //get section recommendations

            $recommendations = array();
            foreach ($group->sections as $section){
                $result = $this->getRecommendation($sessionId, $section->recommendationMessage->id ?? null);
                //take only those with value
                if ($result)
                    $recommendations[]=$result;
            }

            return[
                'title'=>$group->name,
                'color'=>$group->result_color,
                'description'=>$group->description,
                'reports'=>$sections,
                'recommendations'=>$recommendations
            ];
        });

        return[
            "user"=>$userData,
            'session_id'=>$sessionId,
            'report'=>$summaryResultData,
        ];
    }
    /*New*/
    private function getRecommendation($sessionId, $recommendationId){
        //no recommendation question
        if ($recommendationId == null)
            return;

        $testRecord = TestRecord::where([
            ['session_id', $sessionId],
            ['questionnaire_id', $recommendationId]
        ])->first();

        if ($testRecord == null)
            return ;
        $weightPoint = QuestionnaireWeightPoint::find($testRecord->answer);
        return ($weightPoint == null) ? null : $weightPoint->remark;
    }

    private function getUserDetail($role, $testResult){

        if ($role =="STUDENT"){
            $user = $testResult->session->user;
            $student = $testResult->session->user->student;
            return[
                'name'=>$user->name,
                'sex'=>$student->gender,
                'age'=>$student->age,
                'school'=>$student->school->name,
                'class'=>$student->class,
                'state'=>$student->state->name ?? '',
                'country'=>$student->country->name ?? '',
                'image_url'=> (is_null($user->image_url)) ? null : url($user->image_url),
                'payment_status'=> 1,
            ];
        }elseif ($role =="PRIVATE_LEARNER"){
            $user = $testResult->session->user;
            $privaterLearner = $testResult->session->user->privateLearner;
            return[
                'name'=>$user->name,
                'sex'=>$privaterLearner->gender,
                'age'=>$privaterLearner->age,
                'school'=>$privaterLearner->school,
                'class'=>$privaterLearner->class,
                'state'=>$privaterLearner->state->name ?? '',
                'country'=>$privaterLearner->country->name ?? '',
                'image_url'=> (is_null($user->image_url)) ? null : url($user->image_url),
                'payment_status'=> $testResult->payment_status,

            ];
        }else{//anonymous user viewing status
            $user = $testResult->session->user;
            return[
                'name'=>$user->name,
                'sex'=>'Nil',
                'age'=>'Nil',
                'school'=>'Nil',
                'class'=>'Nil',
                'state'=>'Nil',
                'country'=>'Nil',
                'image_url'=> null,
                'payment_status'=> 0,
            ];
        }
    }


}
