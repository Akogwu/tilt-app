<?php

namespace App\Http\Controllers;

use App\Models\GroupResource;
use App\Http\Resources\SectionAllResource;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GroupResourceController extends Controller
{
    public function getAll(){
        return GroupResource::all();//response()->json(['status'=>])
    }
    public function getSingle($groupResourceId){
        $groupResource = GroupResource::where('id', $groupResourceId)->get();

        return $groupResource;
    }
    public function getGroupResourceByGroupId($groupId){
        $groupResources = GroupResource::where('group_id', $groupId)->get();
        return $groupResources;
    }
    public function create(Request $request){
    
        // $this->validate($request,[
        //     'description'=>"required",
        //     'group_id'=>"required",
        // ]);
        // if ($this->isNameExist($request->name))
        //     return response()->json(['status'=>false, "message"=>"Name already exists"], 409);
        // $result = DB::table('group_resources')->insertGetId([
        //     'group_id'=>$request->group_id,
        //     'description'=>$request->description
        // ]);

        $result = GroupResource::create([
            'group_id'=>$request->group_id,
            'description'=>$request->description
        ]);
        if($result){
            return response()->json(['status'=>true, "message"=>"Action successful"], 201);
        }
        
    }

    public function update($groupId, Request $request){
        $this->validate($request,[
            'name'=>"required",
            'color'=>"required",
            'icon'=>"required",
            'description'=>"required",
            'graph_description'=>"required",
        ]);
        $name = ucwords(strtolower($request->name));
        $group = Group::where("id", $groupId)->first();
        //check if found
        if ($group == null)
            return response()->json(['status'=>false, "message"=>"groupId ".$groupId." does not exist"], 404);

        if ($this->isNameExist($name) && strtolower($group->name) != strtolower($name))
            return response()->json(['status'=>false, "message"=>"Name already exists"], 409);

        //update
        $group->update([
            'name'=>$name,
            'color'=>$request->color,
            'icon'=>$request->icon,
            'description'=>$request->description,
            'graph_description'=>$request->graph_description,
        ]);

        return response()->json(['status'=>true, "message"=>"Update successful"], 201);
    }

    //delete
    public function delete($groupId){
        try {
            $group = Group::findOrFail($groupId);
            //$group->sections->delete();
            $group->delete();

            return response()->json(['status'=>true, "message"=>"Deleted successfully"], 201);

        }catch (\Exception $exception){
            Log::error("GroupController",['delete'=>$exception->getMessage()]);
            return response()->json(['status'=>false, "message"=>"groupId ".$groupId." does not exist"], 404);
        }
    }

    private function isNameExist($name){
        try {
            $group = Group::where('name',$name)->first();
            if ($group==null)//empty
                return false;
            return true;
        }catch (\Exception $exception){
            Log::error("GroupController",['isNameExist'=>$exception->getMessage()]);
            return true;
        }

    }
}
