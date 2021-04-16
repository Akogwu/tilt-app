<?php

namespace App\Http\Controllers;

use App\Repository\TestResultRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index(){
        $user = Auth::user();
        $testResultRepo = new TestResultRepository();
        $testResults = $testResultRepo->getMyTestResults($user->id);
        $testDetail = $testResultRepo->getTestDetails($user->id);

        return view('pages.profile', compact('user','testResults','testDetail'));
    }
}
