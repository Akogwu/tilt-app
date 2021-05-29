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

    public function mockResult()
    {
        $data = [
            'user'=>[
                'name'=>'Akos Emmanuel',
                'sex'=>'Male',
                'age'=>'10',
                'school'=>'Glorious Academy',
                'class'=>'Jss 3',
                'state/provice'=>'Imo state',
                'country'=>'Nigeria',
                'image_url'=>'www.googl.com/image'
            ],
            'summary_result'=>[
                ['group_name'=>"Brainy",'score'=>85],
                ['group_name'=>"Puter",'score'=>50],
                ['group_name'=>"Banky",'score'=>46],
                ['group_name'=>"Jack",'score'=>87],
                ['group_name'=>"Temperate",'score'=>32],
                ['group_name'=>"Readiness",'score'=>32],

            ],
            'recommendations'=>[
                [
                    'group_name'=>'Brainy',
                    'goroup_icon'=>'fas fa-user-graduate',
                    'group_color'=>'tertiary',
                    'description'=> 'lorem ipsum dolor. lorem ipsum dolor',
                    'sections'=>[
                        [
                            'section_name'=>'Ability to Read',
                            'scores'=>[20,30,40,50],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Listening Skills',
                            'scores'=>[20,30,40,50],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Ability to write',
                            'scores'=>[40,10,],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Fluency of Language of Instruction',
                            'scores'=>[40],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Memorization/ Cramming',
                            'scores'=>[40],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                    ]
                ],
                [
                    'group_name'=>'Puter',
                    'goroup_icon'=>'fas fa-download',
                    'group_color'=>'primary',
                    'description'=> 'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non',
                    'sections'=>[
                        [
                            'section_name'=>'Asking Question',
                            'scores'=>[20,30,40],
                            'recommendation'=>'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Objective Thinking',
                            'scores'=>[40,50],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Research and Experiment',
                            'scores'=>[40,20],
                            'recommendation'=>'Aliquam elementum augue sit amet ipsum viverra, eu dictum est rutrum.'
                        ],
                    ]
                ],
                [
                    'group_name'=>'Banky',
                    'goroup_icon'=>'fas fa-user-graduate',
                    'group_color'=>'primary',
                    'description'=> 'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non',
                    'sections'=>[
                        [
                            'section_name'=>'Asking Question',
                            'scores'=>[20,30,40],
                            'recommendation'=>'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Objective Thinking',
                            'scores'=>[40,50],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Research and Experiment',
                            'scores'=>[40,20],
                            'recommendation'=>'Aliquam elementum augue sit amet ipsum viverra, eu dictum est rutrum.'
                        ],
                    ]
                ]
            ]

        ];

        return response()->json($data);
    }
}
