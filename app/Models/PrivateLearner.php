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
                'country_id'=>$input['country_id'] ?? null,
                'state_id'=>$input['state_id'] ?? null,
            ]);
        return $new;
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state(){
        return $this->belongsTo(StateProvince::class, 'state_id');
    }
}
