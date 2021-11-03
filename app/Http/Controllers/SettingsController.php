<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getAll(){
        $settings = Settings::all();

        return view('pages.admin.setting', compact('settings'));
    }

    public function update(Request $request){
       Settings::createNew($request->name, $request->value);

        return back();
    }


}
