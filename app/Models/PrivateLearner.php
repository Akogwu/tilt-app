<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateLearner extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public static function createNewOrUpdate($input, $userId){
        $new = self::updateOrCreate([
                'user_id'=>$userId
            ],[
                'age'=>$input['age'],
                'level'=>$input['level'] ?? null,
                'gender'=>$input['gender'],
                'school'=>$input['school'] ?? null,
            ]);
        return $new;
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
