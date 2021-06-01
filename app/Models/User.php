<?php

namespace App\Models;

use App\Notifications\PasswordResetNotification;
use App\Models\PrivateLearner;
use App\Models\SchoolAdmin;
use App\Models\Student;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Webpatser\Uuid\Uuid;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'email_verified_at' => 'datetime',
    ];

    protected $primaryKey = "id";
    public $incrementing = false;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string)Uuid::generate(4);
        });
    }



    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function privateLearner()
    {
        return $this->hasOne(PrivateLearner::class, 'user_id');
    }

    public function schoolAdmin()
    {
        return $this->hasOne(SchoolAdmin::class, 'user_id');
    }

    public function fullname()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public static function createNew($request){
        $role = self::firstOrCreate(
            ['email'=>$request->email],
            [
                'name' => $request->last_name.' '.$request->first_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_name' => $request->middle_name,
                'role_id' => $request->role_id,
                'phone' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );
        return $role;
    }



    public function detail(){
        if ($this->role->role =="PRIVATE_LEARNER")
            return [
                'id'=>$this->id,
                'first_name'=>$this->first_name,
                'last_name'=>$this->last_name,
                'middle_name'=>$this->middle_name,
                'fullname'=>$this->fullname(),
                'email'=>$this->email,
                'phone_number'=>$this->phone_number,
                'role'=>$this->role->role,
                'status'=>$this->status,
                'age'=>$this->privateLearner->age ?? '',
                'gender'=>$this->privateLearner->gender ?? '',
                'school'=>$this->privateLearner->school ?? '',
                'level'=>$this->privateLearner->level ?? ''
            ];

        return [
            'id'=>$this->id,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'middle_name'=>$this->middle_name,
            'fullname'=>$this->fullname(),
            'email'=>$this->email,
            'phone_number'=>$this->phone_number,
            'role'=>$this->role->role,
            'status'=>$this->status
        ];
    }

//    public function sendPasswordResetNotification($token)
//    {
//        $this->notify(new PasswordResetNotification($token, $this->email));
//    }
}
