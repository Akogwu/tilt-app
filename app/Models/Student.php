<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\This;
use Webpatser\Uuid\Uuid;

class Student extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function school(){
        return $this->belongsTo(School::class, 'school_id');
    }
    public function state()
    {
        return $this->belongsTo(StateProvince::class,'state_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public static function createNew($userId, $schoolId, $request){
        $new= self::firstOrCreate(
            [
                'user_id'=>$userId,
                'school_id'=>$schoolId
            ],
            [
                'age'=>$request->age,
                'level'=>$request->level,
                'gender'=>$request->gender,
            ]
        );
        $student = new Student();
        $num = $student->generateStudentNumber($new->id);

        $new->update([
            'tilt_no'=> $num
        ]);
        return $new;
    }
    private function generateStudentNumber($id){
        return 'T'.($id + 9999);
    }

    public function detail(){
        return [
            'id'=> $this->user->id,
            'first_name'=>$this->user->first_name,
            'last_name'=>$this->user->last_name,
            'middle_name'=>$this->user->middle_name,
            'fullname'=>$this->user->fullname(),
            'address'=>$this->address,
            'school'=>$this->school,
            'email'=>$this->user->email,
            'role'=>$this->user->role->role,
            'phone_number'=>$this->user->phone_number,
            'image_url'=>$this->user->image_url,
            'status'=>$this->user->status,
            'created_at'=>$this->user->created_at,
            'updated_at'=>$this->user->updated_at,
            'request_delete'=>$this->request_delete,
            'age'=>$this->age ?? '',
            'level'=>$this->level ?? '',
            'gender'=>$this->gender ?? '',

        ];
    }

    public function schema(){
        return [
            'id'=> $this->user->id,
            'first_name'=>$this->user->first_name,
            'last_name'=>$this->user->last_name,
            'middle_name'=>$this->user->middle_name,
            'fullname'=>$this->user->fullname(),
            'address'=>$this->address,
            'email'=>$this->user->email,
            'role'=>$this->user->role->role,
            'phone_number'=>$this->user->phone_number,
            'image_url'=>$this->user->image_url,
            'status'=>$this->user->status,
            'created_at'=>$this->user->created_at,
            'request_delete'=>$this->request_delete,
            'age'=>$this->age ?? '',
            'level'=>$this->level ?? '',
            'gender'=>$this->gender ?? '',
        ];
    }
}
