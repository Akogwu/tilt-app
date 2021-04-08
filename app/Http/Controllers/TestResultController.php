<?php

namespace App\Http\Controllers;

use App\Models\Group;

use App\Models\Session;
use App\Models\TestResult;

use Illuminate\Support\Facades\Log;

class TestResultController extends Controller
{
    public function getTestResult($sessionId){
        $testResult = TestResult::where('session_id', $sessionId)->first();
        if ($testResult == null )
            return response()->json(['status'=>false, 'data'=>[], 'message'=>'No record found'], 404);
        //check for payment
        if (!$testResult->payment_status)
            return response()->json(['status'=>false, 'data'=>[], 'message'=>'non_payment']);

        return response()->json(['status'=>true, 'data'=>$testResult->getResult($sessionId, true), 'payment_status'=> $testResult->payment_status,
        ], 200);
    }
    public function getTestResultSummary($sessionId){
        $testResult = TestResult::where('session_id', $sessionId)->first();
        if ($testResult == null )
            return response()->json(['status'=>false, 'data'=>[], 'message'=>'No record found'], 404);

        return response()->json(['status'=>true, 'data'=>$testResult->getResult($sessionId), 'payment_status'=> $testResult->payment_status,
        ], 200);
    }

    public function getMyTestResults($userId){

        $sessionWithResult = Session::where([['user_id', $userId],['completed', true]])->orderBy('created_at', 'desc')
            ->with('testResult');
        //TestResult::where('session_id')
        return $sessionWithResult->get();
    }
    public function getTestDetails($userId){
        $session = Session::where('user_id', $userId);
        $attempts = $session->count();
        $total_results = TestResult::whereIn('session_id', $session->pluck('id'))->count();
        $data=[
          'attempts'=>$attempts,
          'total_tests'=> $total_results
        ];

        return response()->json(['status'=>true, 'data'=>$data], 200);
    }

}
