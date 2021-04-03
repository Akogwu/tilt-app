<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getAll(){
        $settings = Settings::all();
        return response()->json($settings);
    }

    public function update(Request $request){
        foreach ($request->all() as $item=>$value){
            if (is_int($value))
                Settings::createNew($item, $value);
            else
                return response()->json(['status'=>false, 'message'=>'invalid value '.$value.' for item '.$item.' Expecting integer']);
        }
        return response()->json(['status'=>true, 'message'=>'Updated successfully'], 201);
    }
}
