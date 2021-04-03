<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Session extends Model
{
    protected $casts = ['id' => 'string'];
    public $incrementing = false;
    protected $guarded = [];

    protected $table = 'user_sessions';

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function testResult(){
        return $this->hasOne(TestResult::class);
    }

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public static function createNew($userId){
        $new = self::create(['user_id'=>$userId]);
        return $new;
    }

    protected $hidden = ['deleted_at','updated_at','completed'];
}
