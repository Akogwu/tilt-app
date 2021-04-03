<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;

class Subscription extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
    ];
    protected $primaryKey = "id";
    public $incrementing = false;

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function schools(){
        return $this->hasMany(School::class, 'subscription_id');
    }

    public static function createNew($request){
        $new = self::create(
            [
                'name'=> ucwords($request->name),
                'slug'=> Str::slug($request->name, '-'),
                'description'=>$request->description,
                'icon'=>$request->icon,
                'capacity'=>$request->capacity,
                'price'=>$request->price,
            ]
        );
    }
    protected $hidden = ['created_at','updated_at','deleted_at'];
}
