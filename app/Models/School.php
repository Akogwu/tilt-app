<?php

namespace App\Models;

use App\Util\GeneralUtil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Webpatser\Uuid\Uuid;

class School extends Model
{
    use SoftDeletes;
    protected $casts = [
        'id' => 'string',
    ];
    protected $primaryKey = "id";
    protected $guarded = ['id','created_at'];
    public $incrementing = false;

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function schoolAdmin(){
        return $this->hasOne(SchoolAdmin::class, 'school_id');
    }

    public function subscription(){
        return $this->belongsTo(Subscription::class);
    }

    public function student(){
        return $this->hasMany(Student::class, 'school_id');
    }

    public function stateProvince()
    {
        return $this->belongsTo(StateProvince::class,'state');
    }
    public function countryRelation()
    {
        return $this->belongsTo(Country::class,'country');
    }

    public static function createNew($input){
        $school = self::create(
            [
                'name' => $input['school_name'],
                'description' => $input['school_description'] ?? null,
                'address' => $input['school_address'] ?? null,
                'country' => $input['school_country'] ?? null,
                'state' => $input['school_state'] ?? null,
                'city' => $input['school_city'] ?? null,
                'zipcode' => $input['school_zipcode'] ?? null,
                'school_capacity'=> GeneralUtil::DEFAULT_SCHOOL_CAPACITY
            ]
        );
        return $school;
    }

    public function getRemainingCapacity(){
        return $this->school_capacity;
    }

    public function schema(){
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'address'=> $this->address,
            'logo_url'=> $this->logo_url,
            'description'=> $this->description,
            'country'=> $this->country,
            'state'=> $this->state,
            'city'=> $this->city,
            'zipcode'=> $this->zipcode,
            'created_at'=> $this->created_at,
            'subscription'=>$this->subscription,
            'total_student'=>$this->student->count(),
            'number_left'=>$this->getRemainingCapacity()
        ];
    }
}
