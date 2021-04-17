<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PDF;

class PDFController extends Controller
{
    function generateResult(){
        
        return PDF::loadView('pages.results.complete')->stream('myResult.pdf');

    }
}
