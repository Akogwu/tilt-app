<?php

namespace App\Http\Controllers;

use App\Models\Group;

use App\Models\Session;
use App\Models\Student;
use App\Models\TestResult;

use App\Repository\TestResultRepository;
use Illuminate\Support\Facades\Log;

class TestResultController extends Controller
{
    private $testResultRepository;
     public function __construct(TestResultRepository $testResultRepository)
     {
         $this->testResultRepository = $testResultRepository;
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

        $data = $this->testResultRepository->getCompleteResult($sessionId);
        //return $data;
        return view("pages.results.result-pdf", $data);
    }
}
