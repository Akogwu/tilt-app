<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PDF;
// use Knp\Snappy\Pdf;

class PDFController extends Controller
{
    function generateResult(){

        $testResult = [];
        
        return PDF::loadView('pages.results.complete2', ['testResult' => $testResult])
        ->setOptions([
            'enable-javascript' => true,
            'enable-internal-links' => true,
            'enable-local-file-access' => true,
            'allow' => '/images/',
            'images' => true,
            'javascript-delay' => 5000,
            

        ])
        ->stream('myResult.pdf');
        
        // $snappy = new Pdf('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64');
        // header('Content-Type: application/pdf');
        // header('Content-Disposition: attachment; filename="file.pdf"');
        // echo $snappy->getOutput('http://www.github.com');
    }
}
