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
            abort(404);

        $payment_status = $testResult->payment_status;
        $user = $testResult->session->user;
        $testResult = $testResult->getResult($sessionId);

        return view('pages.results.summary',compact('testResult','payment_status','user'));

    }


}
