<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class SchoolAdmin extends Model
{
    use SoftDeletes;
    protected $casts = [
        'id' => 'string',
    ];
    public $incrementing = false;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function school(){
        return $this->belongsTo(School::class, 'school_id');
    }

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function detail(){
        return[
            'id'=> $this->user->id,
            'first_name'=>$this->user->first_name,
            'last_name'=>$this->user->last_name,
            'middle_name'=>$this->user->middle_name,
            'fullname'=>$this->user->fullname(),
            'phone_number'=>$this->user->phone_number,
            'school'=>$this->school,
            'status'=>$this->user->status
        ];
    }

    public function adminDetail(){
        return[
            'id'=> $this->user->id,
            'first_name'=>$this->user->first_name,
            'last_name'=>$this->user->last_name,
            'middle_name'=>$this->user->middle_name,
            'fullname'=>$this->user->fullname(),
            'phone_number'=>$this->user->phone_number,
            'status'=>$this->user->status
        ];
    }

    public static function createNew($userId, $schoolId){
        $schooladmin= self::firstOrCreate(
            [
                'user_id'=>$userId,
                'school_id'=>$schoolId
            ]
        );
        return $schooladmin;
    }
}
