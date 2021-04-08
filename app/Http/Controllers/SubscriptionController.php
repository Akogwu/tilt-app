<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function getAll(){
        return Subscription::all();
    }
    public function create(Request $request){
        $this->validate($request, [
           'name'=>'required',
           'capacity'=>'required|numeric|min:1',
           'price'=>'required|numeric|min:1',
        ]);

        Subscription::createNew($request);

        return response()->json(['status'=>true, 'message'=>'Successful'], 201);
    }
}
