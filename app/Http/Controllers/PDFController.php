<?php

namespace App\Http\Controllers;

use App\Repository\TestResultRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PDF;


class PDFController extends Controller
{
    private $testResultRepository;
    public function __construct(TestResultRepository $testResultRepository)
    {
        $this->testResultRepository = $testResultRepository;
    }

    function generateResult($sessionId = '0d35113f-5a4e-4a38-a2de-bcec80f37595'){


        $result = $this->testResultRepository->getTestResult($sessionId);

        if (is_null($result) || empty($result)){
            abort('404','Result not found for this session');
        }

        if ((int)$result['payment_status'] != 1){
            abort('403','This result has not been paid for');
        }

        $testResult = $result['data'];

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
