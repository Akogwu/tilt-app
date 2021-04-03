<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateProvince extends Model
{
    protected $table = "states_provinces";
    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
}
