<?php


namespace App\Repository;


use App\Models\GraphOverview;
use App\Models\Group;
use App\Models\Questionnaire;
use App\Models\QuestionnaireWeightPoint;
use App\Models\TestRecord;
use App\Models\TestResult;
use Illuminate\Support\Facades\DB;

class TestResultV2Repository
{
    public function detailResult($sessionId){
        $testResult = TestResult::where('session_id', $sessionId)->first();

        if ($testResult == null )
            return [];
        $role = $testResult->session->user->role->role;

        $groupAnswered = collect($testResult->group_score_detail);
        $graphOverview = GraphOverview::latest()->first()->description ?? '';
        //get all aswered sections
        $sectionAnswered = collect($testResult->section_score_detail)->map(function ($testResult){
            return $testResult['section_id'];
        });

        $summaryResultData = $groupAnswered->map(function ($item) use ($sectionAnswered, $sessionId){
            $item = (object)$item;
            $group = Group::find($item->group_id);
            //get all section
            $sections =  $group->sections->map(function($section) use ($sectionAnswered, $sessionId){
                //from answered sections
                if (in_array($section->id, $sectionAnswered->toArray())){
                    $recommendation = collect($this->getQuestionRecommendation($sessionId, $section->id))->map(function ($recommendation){
                        return $recommendation['recommendation'];
                    });
                    $gradePoint = collect($this->getQuestionRecommendation($sessionId, $section->id))->map(function ($recommendation){
                        return $recommendation['grade_point'];
                    });
                    return[
                        'icon'=>$section->icon,
                        'title'=>$section->name,
                        'short_name'=>$section->short_name,
                        'description'=>$section->description,
                        'recommendations'=> $recommendation->filter()->values(),
                        'score'=>round($gradePoint->sum(), 2)
                    ];
                }
            });

            //get section recommendations

            $numSection = count($sections);
            return[
                'title'=>$group->name,
                'color'=>$group->result_color,
                'description'=>$group->description,
                'reports'=>$sections,
                'resources'=>$group->resource,
                'chart'=>[
                    "labels"=>collect($sections)->map(function ($section){
                        return $section['short_name'];
                    }),

                    "data"=>[[
                        'label'=> $group->name.' Parameters',
                        'data'=> collect($sections)->map(function ($section){
                            return $section['score'];
                        }),
                    ]],
                ],
                'group_score'=> collect($sections)->sum(function ($section) use($numSection){
                    if ($section['score'] == 0 || $numSection ==0)
                        return 0;
                    //find the average
                    return round($section['score']/$numSection, 2);

            })
            ];
        });

        $graphLabel = collect($summaryResultData)->map(function ($data){
            return $data['title'];
        });

        $graphData = collect($summaryResultData)->map(function ($data){
            return $data['group_score'];
        });
        $groupData= array();
        $a=0;
        //form an array
        foreach ($graphLabel as $label){
            $groupData[] = array('group_name'=>$label,'value'=>$graphData[$a++]);
        }

        $collection = collect($summaryResultData)->sortByDesc('group_score');
        $dominantGroups = $collection->values()->take(2)->map(function ($group){
            //echo $group['group_score'];
            return[
                "title"=>$group['title'],
                'color'=>$group['color'],
                'score'=> round($group['group_score'], 2)
            ];
        });

        return[
            'user'=> $this->getUserDetail($role, $testResult),
            'dominant_group'=>$dominantGroups,
            'overview'=>[
                'label'=>$graphLabel,
                'data'=>$graphData,
                'graph_overview'=>$graphOverview
            ],
            'report'=>$summaryResultData,
            'session_id'=>$sessionId,
        ];
    }

    private function getSectionName($array){

    }

    /*New update*/
    public function summaryResult($sessionId){
        $testResult = TestResult::where('session_id', $sessionId)->first();
        if ($testResult == null )
            return [];
        $role = $testResult->session->user->role->role;
        $graphOverview = GraphOverview::latest()->first()->description ?? '';
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
                $result = $this->getSectionRecommendation($sessionId, $section->recommendationMessage->id ?? null);
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
            'graph_overview'=>$graphOverview

        ];
    }
    /*New*/
    private function getSectionRecommendation($sessionId, $recommendationId){
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

    private function getQuestionRecommendation($sessionId, $sectionId){
        //get all questions in this section
        $questionnaireIds = Questionnaire::where('section_id', $sectionId)->pluck('id');
        if ($questionnaireIds == null)
            return null;
        //

        $recommendations = [];
        foreach ($questionnaireIds as $questionnaireId){
            $testRecord = DB::table('test_records')->where([
                ['session_id', $sessionId],
                ['test_records.questionnaire_id', $questionnaireId]])
                ->join("questionnaires",
                    "questionnaires.id",'=','test_records.questionnaire_id')
                ->join('questionnaire_weight_points',
                    'questionnaire_weight_points.id','=',
                    'test_records.answer')
                ->select('questionnaire_weight_points.remark AS remark','questionnaires.grade_point as grade_point')
                ->get();
            if (!empty($testRecord)){
                //if solution is triggered (remark) therefore grade_point is 0
                if (!empty($testRecord[0]->remark))
                    $recommendations[] = [
                        'recommendation'=>$testRecord[0]->remark ?? '',
                        'grade_point'=>0
                    ];
                else
                    $recommendations[] = [
                        'recommendation'=> '',
                        'grade_point'=>$testRecord[0]->grade_point ?? 0
                    ];
            }

        }
        return $recommendations;
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
