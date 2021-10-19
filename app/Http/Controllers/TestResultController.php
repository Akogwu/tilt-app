<?php

namespace App\Http\Controllers;

use App\Models\Group;

use App\Models\Session;
use App\Models\Student;
use App\Models\TestResult;

use App\Repository\TestResultRepository;
use App\Repository\TestResultV2Repository;
use Illuminate\Support\Facades\Log;

class TestResultController extends Controller
{
    private $testResultRepository;
    private $testResultV2Repository;
     public function __construct(TestResultRepository $testResultRepository, TestResultV2Repository $testResultV2Repository)
     {
         $this->testResultRepository = $testResultRepository;
         $this->testResultV2Repository = $testResultV2Repository;
     }

    public function getTestResultSummary($sessionId){

        $testResult = TestResult::where('session_id', $sessionId)->first();

        if ($testResult == null )
            abort(404);

        $payment_status = $testResult->payment_status;
        $user = $testResult->session->user;
        $testResult = $testResult->getResult($sessionId);

        return view('pages.results.summary', compact('testResult','payment_status','user','sessionId'));

    }

    public function getCompleteResult($sessionId)
    {
        try {

            return $this->testResultRepository->getCompleteResult($sessionId);

        }catch (\Exception $exception){
            return [];
        }

    }



    public function viewTestResult($sessionId){

        $data = $this->testResultV2Repository->summaryResult($sessionId);
        //return $data;
        return view("pages.result", $data);
    }

    public function summaryResult($sessionId){
         return $this->testResultV2Repository->summaryResult($sessionId);
    }

    
}
