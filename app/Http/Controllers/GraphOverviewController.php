<?php

namespace App\Http\Controllers;

use App\Models\GraphOverview;
use Illuminate\Http\Request;

class GraphOverviewController extends Controller
{

    public function getOverview(){
        return GraphOverview::all();

    }

    public function createUpdate(Request $request){
        $this->validate($request, [
            'description'=>'required',
            'id'=>'nullable'
        ]);

        GraphOverview::updateOrCreate(
            ['id'=>$request->id ?? null],
            ['description'=>$request->description]
        );

        return response()->json(['message'=>'successful']);

    }

    public function delete($id){
        $description = GraphOverview::findOrFail($id);
        //check if in use, disable else delete
        $description->delete();
    }
}
