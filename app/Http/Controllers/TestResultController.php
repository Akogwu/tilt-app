<?php

namespace App\Http\Controllers;

use App\Models\Group;

use App\Models\Session;
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

    public function getTestResult($sessionId){

            $result = $this->testResultRepository->getTestResult($sessionId);

            if (is_null($result) || empty($result)){
                abort('404','Result not found for this session');
            }

            if ((int)$result['payment_status'] != 1){

                abort('403','This result has not been paid for');
            }

            $testResult = $result['data'];

        return view('pages.results.complete', compact('testResult'));
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
