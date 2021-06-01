<?php

namespace App\Http\Controllers;

use App\Repository\SchoolRepository;
use App\Repository\TestResultRepository;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $totalCompletedTest = TestResultRepository::getCountCompletedTest();
        $totalRegisteredSchool = SchoolRepository::countSchool();
        $totalTestedLearners = TestResultRepository::getCountUniqueLearnerCompletedTest();

        return view('pages.home', compact('totalCompletedTest','totalTestedLearners','totalRegisteredSchool'));
    }
}
