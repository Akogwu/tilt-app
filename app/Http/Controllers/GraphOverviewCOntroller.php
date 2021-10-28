<?php

namespace App\Http\Controllers;

use App\Models\GraphOverview;
use Illuminate\Http\Request;

class GraphOverviewCOntroller extends Controller
{

    public function getOverview(){
        return GraphOverview::latest()->first();

    }

    public function createUpdate(Request $request){
        $this->validate($request, [
            'overview'=>'required',
            'id'=>'nullable'
        ]);

        GraphOverview::createOrUpdate(
            ['id'=>$request->id ?? null],
            ['overview'=>$request->overview]
        );

        return response()->json(['message'=>'successful']);

    }

    public function delete($id){
        $overview = GraphOverview::findOrFail($id);
        //check if in use, disable else delete
        $overview->delete();
    }
}
