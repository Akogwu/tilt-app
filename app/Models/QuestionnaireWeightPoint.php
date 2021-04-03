<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireWeightPoint extends Model
{
    use SoftDeletes;

    protected $guarded= [];
    protected $table = "questionnaire_weight_points";
    public static function createNew($questionnaireId, $weight_point, $remark){
        $new = self::firstOrCreate(
            [
                'questionnaire_id' => $questionnaireId,
                'weight_point' => $weight_point,
            ],
            [
                'remark' => $remark,
            ]
        );
        return $new;
    }
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
