<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\StateProvince;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getAll(){
        return Country::all();
    }
    public function getState($countryId){
        return StateProvince::where('country_id', $countryId)->orderBy('name','asc')->get();
    }
}
