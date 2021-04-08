<?php

namespace App\Http\Controllers;

use App\Http\Resources\SectionAllResource;
use App\Models\Questionnaire;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    public function getAll(){
        return SectionAllResource::collection(Section::with('group')->orderBy('name','asc')->get()) ;
    }

    public function getQuestionnaires($sectionId){
        return Questionnaire::where('section_id', $sectionId)->latest()->with('weightPoints')->get();;
    }

    public function getSingle($id){
        $section = Section::where('id', $id)->first();
        return new SectionAllResource($section);
    }
    public function create(Request $request){
        $this->validate($request,[
            'name'=>"required",
            'group_id'=>"required",
            'description'=>"required"
        ]);
        //return $request->group_id;
        if ($this->isNameExist($request->name, $request->group_id))
            return response()->json(['status'=>false, "message"=>"Name already exists in this group"], 409);

        Section::createNew(ucwords(strtolower($request->name)), $request->group_id, $request->description);

        return response()->json(['status'=>true, "message"=>"Action successful"], 201);
    }

    public function update($sectionId, Request $request){
        $this->validate($request,[
            'name'=>"required",
            'recommendation'=>"required"
        ]);
        $name = ucwords(strtolower($request->name));
        $recommendation = $request->recommendation;
        $section = Section::where("id", $sectionId)->first();
        //check if found
        if ($section == null)
            return response()->json(['status'=>false, "message"=>"Section Id does not exist"], 409);

        $section->update([
            'name'=>$name,
            'recommendation'=> $recommendation,
            'description'=>$request->description
        ]);

        return response()->json(['status'=>true, "message"=>"Update successful"], 201);
    }

    //delete
    public function delete($sectionId){
        try {
            $section = Section::findOrFail($sectionId);

            $section->delete();

            return response()->json(['status'=>true, "message"=>"Deleted successfully"], 201);

        }catch (\Exception $exception){
            Log::error("SectionController",['delete'=>$exception->getMessage()]);
            return response()->json(['status'=>false, "message"=>"SectionId ".$sectionId." does not exist"]);
        }
    }

    private function isNameExist($name, $groupId){
        try {
            $section = Section::where([['name',$name],['group_id', $groupId]])->first();
            if ($section==null)//empty
                return false;
            return true;
        }catch (\Exception $exception){
            Log::error("SectionController",['isNameExist'=>$exception->getMessage()]);
            return true;
        }

    }
}
