<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Questionnaire;
use App\Models\QuestionnaireWeightPoint;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionnaireController extends Controller
{
    public function index(){
        return view('pages.admin.questionnaire');
    }
    public function getSingle($id){
        $questionnaire =  Questionnaire::where('id', $id)->first();
        if ($questionnaire == null)
            return [];
        return $questionnaire->schema();
    }
    public function create(Request $request){
        $this->validate($request,[
            'section_id'=>"required | numeric",
            'question'=>"required",
            //'weight_point'=>"required|array"
        ]);
        //check sectionid
        $section = Section::find($request->section_id);

        if ($section == null)
            return response()->json(["status"=>"sectionId ".$request->section_id." does not exist"],409);

        $questionnaire = Questionnaire::createNew($request);

        if ($request->weight_point != null)
        foreach ($request->weight_point as $item){
            QuestionnaireWeightPoint::createNew($questionnaire->id, $item["weight_point"], $item["remark"]);
        }

        return response()->json(['status'=>true, "message"=>"Created successfully"], 201);
    }

    public function update($id, Request $request){
        $this->validate($request,[
            'question'=>'required',
        ]);
        try {
            $questionnaire = Questionnaire::findOrFail($id);
        }catch (\Exception $exception){
            return response()->json(['status'=>false, "message"=>"Questionnaire Id ".$id." not found"]);
        }
        //Update section id
        if ($request->section_id){
            if (!$this->isSectionExist($request->section_id))
                return response()->json(['status'=>false, "message"=>"Section Id ".$request->section_id." not found"]);

            $questionnaire->update(["section_id"=>$request->section_id]);
        }

        //update question
        if ($request->question)
        $questionnaire->update(["question"=>$request->question]);
        //update or create weight points
        if ($request->weight_point){
            foreach ($request->weight_point as $item){
                QuestionnaireWeightPoint::updateOrCreate(
                    ['questionnaire_id' => $questionnaire->id, 'weight_point' => $item["weight_point"]],
                    ['remark' => $item["remark"]]);
            }
        }

        return response()->json(['status'=>true, "message"=>"Updated successfully"]);
    }

    public function delete($id){
        try {
            $questionnaire = Questionnaire::findOrFail($id);
            //delete all related weight point
            foreach ($questionnaire->weightPoints as $weightPoint)
                $weightPoint->delete();

            $questionnaire->delete();

            return response()->json(['status'=>true, "message"=>"Deleted successfully"], 201);

        }catch (\Exception $exception){
            Log::error("QuestionnaireController",['delete'=>$exception->getMessage()]);
            return response()->json(['status'=>false, "message"=>"groupId ".$id." does not exist"], 404);
        }
    }
 /*
  * Questionnaire weight point
  * */

    public function addWeightPoint($questionnaireId, Request $request){
        $this->validate($request,[
            'weight_point'=>"required|array"
        ]);

        try {
            Questionnaire::findOrFail($questionnaireId);
        }catch (\Exception $exception){
            return response()->json(['status'=>false, "message"=>"Group Id ".$questionnaireId." not found"]);
        }

        foreach ($request->weight_point as $item){
            QuestionnaireWeightPoint::createNew($questionnaireId, $item["weight_point"], $item["remark"]);
        }

        return response()->json(['status'=>true, "message"=>"Created successfully"], 201);
    }

    private function isSectionExist($sectionId){
        try {
            Section::findOrFail($sectionId);
            return true;
        }catch (\Exception $exception){
            return false;
        }
    }
}
