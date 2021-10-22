<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupResource extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }
}
