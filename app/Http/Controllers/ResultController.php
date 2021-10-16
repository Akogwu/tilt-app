<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Repository\TestResultRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{

    public function index(){
        $user = Auth::user();
        $testResultRepo = new TestResultRepository();
        $testResults = $testResultRepo->getMyTestResults($user->id);
        $testDetail = $testResultRepo->getTestDetails($user->id);
        $transaction =  Transaction::where([['payment_by', $user->id],['status', 1]])->get();
        $transactions=[
            'count'=>$transaction->count(),
            'total'=>$transaction->sum('amount')
        ] ;

        return view('pages.result', compact('user','testResults','testDetail','transactions'));
    }
}
