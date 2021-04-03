<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Role extends Model
{
    use HasFactory;

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
    public static function createNew($name){
        $role = self::firstOrCreate(
            ['role'=>$name],
            ['role'=>$name]
        );
        return $role;
    }
    public function user(){
        return $this->hasMany(User::class);
    }

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
