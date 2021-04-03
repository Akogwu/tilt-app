<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Settings extends Model
{
    use SoftDeletes;

    protected $casts = ['id' => 'string'];
    public $incrementing = false;
    protected $guarded = [];

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public static function createNew($name, $value){
        self::updateOrCreate(
            ['name'=>$name],
            ['value'=>$value]
        );
    }

    protected $hidden = ['deleted_at','updated_at','created_at','id'];

}
