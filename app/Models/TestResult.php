<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class TestResult extends Model
{
    protected $guarded = [];
    public $incrementing = false;
    protected $casts = [
        'id' => 'string',
        'section_score_detail'=>'json',
        'group_score_detail'=>'json'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model){
            $model->id = (string) Uuid::generate(4);
        });
    }
    public function session(){
        return $this->belongsTo(Session::class, 'session_id');
    }
    public static function updateOrCreateModel($session_id, $avgScore, $totalScore, $obtainableScore, $sectionScoreDetail, $groupScoreDetail){
        $testResult = new TestResult();
        $new = self::updateOrCreate(
            [
                'session_id'=>$session_id,
            ],
            [
                'avg_score'=>$avgScore,
                'total_score'=>$totalScore,
                'obtainable_score'=>$obtainableScore,
                'section_score_detail'=>$sectionScoreDetail,
                'group_score_detail'=>$groupScoreDetail,
                'payment_status'=> $testResult->checkIfStudent($session_id)

            ]);
        return $new;
    }
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function checkIfStudent($sessionId){
        $session = Session::find($sessionId);
        if ($session->user->role->role =="STUDENT")
            return true;
        return false;
    }

    public function getResult($sessionId, $finalResult = false){
        //get all sections answered
        $testResult = $this;
        $sectionsAnswered = collect($testResult->section_score_detail)->map(function ($section){
            return $section['section_id'];
        });
        $data = [];
        foreach ($testResult->group_score_detail as $result){

            $groupId = $result['group_id'];
            $group = Group::where('id', $groupId)->first();
            $groupSections = [];
            if ($group)
            //get only sections answered that belongs to this group
            $groupSections = $group->sections->filter(function ($section) use ($sectionsAnswered){
                if (in_array($section->id, $sectionsAnswered->toArray()))
                    return true;
            });

            $data[]=[
                'group_name'=>$group->name ?? '',
                'icon'=>$group->icon ?? '',
                'color'=>$group->color ?? '',
                'description'=>$group->description ?? '',
                "sections"=> (count($groupSections) == 0) ? [] : $groupSections->map(function ($section) use ($sessionId, $finalResult){
                    return $section->schemaWithResultRecommendation($sessionId, $finalResult);
                }),
                "percentage" => $result['group_percentage']
            ];
        }
        return $data;
    }
}
