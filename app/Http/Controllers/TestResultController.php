<?php

namespace App\Http\Controllers;

use App\Models\Group;

use App\Models\Session;
use App\Models\Student;
use App\Models\TestResult;

use App\Repository\TestResultRepository;
use App\Repository\TestResultV2Repository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class TestResultController extends Controller
{
    private $testResultRepository;
    private $testResultV2Repository;
     public function __construct(TestResultRepository $testResultRepository, TestResultV2Repository $testResultV2Repository)
     {
         $this->testResultRepository = $testResultRepository;
         $this->testResultV2Repository = $testResultV2Repository;
     }
    //TODO remove method

    public function getTestResultSummary($sessionId){

        $testResult = TestResult::where('session_id', $sessionId)->first();

        if ($testResult == null )
            abort(404);

        $payment_status = $testResult->payment_status;
        $user = $testResult->session->user;
        $testResult = $testResult->getResult($sessionId);

        return view('pages.results.summary', compact('testResult','payment_status','user','sessionId'));

    }
    //TODO remove method
    public function getCompleteResult($sessionId)
    {
        try {

            return $this->testResultRepository->getCompleteResult($sessionId);

        }catch (\Exception $exception){
            return [];
        }

    }



    public function viewTestResult($sessionId){

        return $detail = $this->testResultV2Repository->detailResult($sessionId);
        $data = $this->testResultV2Repository->summaryResult($sessionId);
        $data["overview"] = $detail["overview"];
        $data["dominant_group"] = [];
        $data["detailedReport"] = [];
        $data["dominant_group"] = $detail["dominant_group"];
        $data["detailedReport"] = $detail["report"];
        return view("pages.result", $data);
        // return Redirect::to('/transactions/result/'.$sessionId);
    }

    public function summaryResult($sessionId){
         return $this->testResultV2Repository->summaryResult($sessionId);
    }


}
