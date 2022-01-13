<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questionnaire extends Model
{
    use SoftDeletes;
    protected $guarded= [];

    public static function createNew($request){
        $new = self::create(
            [
                'section_id' => $request->section_id,
                'question' => $request->question,
                'grade_point' => $request->grade_point,
                'colour_code' => $request->colour_code,
                'resource' => $request->resource,
            ]
        );
        return $new;
    }

    public function section(){
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function weightPoints(){
        return $this->hasMany(QuestionnaireWeightPoint::class);
    }

    public function schema(){
        return[
            'section'=>$this->section,
            'question'=>$this->question,
            'weight_point'=>$this->weightPoints,
            'grade_point'=>$this->grade_point,
            'colour_code'=>$this->colour_code,
            'resource' => $this->resource,

        ];
    }

    public function allWeightPoints(){
        $data = [];
        $weightPoints = QuestionnaireWeightPoint::where('questionnaire_id', $this->id)
            ->orderBy('weight_point', 'asc')->get();
        foreach ($weightPoints as $weightPoint){
            $data[] = [
                'weight_point_id'=> $weightPoint->id,
                'questionnaire_id'=> $weightPoint->questionnaire_id,
                'weight_point'=> $weightPoint->weight_point,
            ];
        }
        return $data;
    }

    protected $hidden = ['deleted_at','created_at','updated_at'];
}
