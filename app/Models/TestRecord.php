<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class TestRecord extends Model
{
    protected $guarded = [];

    public function sessions(){
        return $this->belongsTo(Session::class, 'session_id');
    }
    public function questionnaire(){
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id');
    }
    public function answer(){
        return $this->belongsTo(QuestionnaireWeightPoint::class, 'answer','id');
    }
    public function weightPoint(){
        return $this->belongsTo(QuestionnaireWeightPoint::class, 'answer','id');
    }
    public static function createNew($session_id, $questionnaire_id, $answer){
        $new = self::firstOrCreate(
            [
                'session_id'=>$session_id,
                'questionnaire_id'=>$questionnaire_id,
            ],
            ['answer'=>$answer]);
        return $new;
    }

    protected $hidden = ['deleted_at','created_at','updated_at'];
}
