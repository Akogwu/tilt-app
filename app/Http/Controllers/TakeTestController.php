<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Resources\AllQuestionnaireResource;
use App\Http\Resources\SessionAnswersResource;
use App\Models\Role;
use App\Models\Session;
use App\Models\TestRecord;
use App\Models\User;
use App\Repository\TestResultRepository;
use App\Util\TestResultCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TakeTestController extends Controller
{
    private $testResultRepository;

    public function __construct(TestResultRepository $testResultRepository)
    {
        $this->testResultRepository = $testResultRepository;
    }

    //create session
    public function createSession(Request $request){
        $userId = "";
        if ($request->user_id){
            $user = User::find($request->user_id);
            if ($user == null)
                return response()->json(['status'=>false, "message"=>"No user found"],403);
            $userId = $user->id;
        }else{//For Anonymous user
            $role = Role::where('role', "ANONYMOUS")->first();
            $user = User::where('role_id', $role->id)->first();
            $userId = $user->id;
        }
    //create session
        $session = Session::createNew($userId);
        return response()->json(['status'=>true, 'message'=>"Session created successfully", 'session_id'=>$session->id],201);
    }
    //submit Test
    public function submitTest(Request $request){

        $this->validate($request,[
           'session_id'=>"required",
           'questionnaire'=>'required|array'
        ]);
        //check is session valid
        $sessionId = $request->session_id;
        $session = Session::find($sessionId);
        if ($session ==null)
            return response()->json(['status'=>false, 'message'=>"Session does not exist"],403);
        $data = [];
        if ($request->questionnaire != null)
            foreach ($request->questionnaire as $item){
                $data[]=$item;
                //$session_id, $questionnaire_id, $answer
                TestRecord::createNew($session->id, $item["questionnaire_id"], $item["weight_point_id"]);
            }
        try {
            //calculate the result
            $this->testResultRepository->calculate($request->session_id);
            //update session to completed
            $session->update(['completed'=>true]);
        }catch (\Exception $exception){
                Log::error("TakeTestController",['method'=>'submitTest','error'=>$exception->getMessage()]);
        }
        return response()->json(['status'=>true, 'message'=>'Submitted successfully'],201);
    }
    //get all users answers
    public function getAllSessionAnswers($sessionId){
        $sessions = TestRecord::where('session_id', $sessionId)->orderBy('created_at','asc')->get();
        return SessionAnswersResource::collection($sessions);
    }
    public function getAllQuestions(){
        return AllQuestionnaireResource::collection(Group::orderBy('name','asc')->get());
    }
}
