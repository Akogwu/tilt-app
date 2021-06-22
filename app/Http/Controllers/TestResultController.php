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
                'image_url'=> url('/images/roman-reigns.jpg')
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
                            'labels'=>[
                                ['score'=>20,'color'=>'#000000'],
                                ['score'=>30,'color'=>'#333333'],
                                ['score'=>40,'color'=>'#FFFFFF'],
                                ['score'=>50,'color'=>'#009900'],
                            ],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Listening Skills',
                            'labels'=>[
                                ['score'=>20,'color'=>'#000000'],
                                ['score'=>30,'color'=>'#333333'],
                                ['score'=>40,'color'=>'#FFFFFF'],
                                ['score'=>50,'color'=>'#009900'],
                            ],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Ability to write',
                            'labels'=>[
                                ['score'=>20,'color'=>'#000000'],
                                ['score'=>30,'color'=>'#333333'],
                                ['score'=>40,'color'=>'#FFFFFF'],
                                ['score'=>50,'color'=>'#009900'],
                            ],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Fluency of Language of Instruction',
                            'labels'=>[
                                ['score'=>20,'color'=>'#000000'],
                                ['score'=>30,'color'=>'#333333'],
                                ['score'=>40,'color'=>'#FFFFFF'],
                                ['score'=>50,'color'=>'#009900'],
                            ],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Memorization/ Cramming',
                            'labels'=>[
                                ['score'=>20,'color'=>'#000000'],
                                ['score'=>30,'color'=>'#333333'],
                                ['score'=>40,'color'=>'#FFFFFF'],
                                ['score'=>50,'color'=>'#009900'],
                            ],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                    ]
                ],
                [
                    'group_name'=>'Puter',
                    'goroup_icon'=>'fas fa-laptop',
                    'group_color'=>'primary',
                    'description'=> 'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non',
                    'sections'=>[
                        [
                            'section_name'=>'Asking Question',
                            'labels'=>[
                                ['score'=>20,'color'=>'#000000'],
                                ['score'=>30,'color'=>'#333333'],
                                ['score'=>40,'color'=>'#FFFFFF'],
                                ['score'=>50,'color'=>'#009900'],
                            ],
                            'recommendation'=>'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Objective Thinking',
                            'labels'=>[
                                ['score'=>20,'color'=>'#000000'],
                                ['score'=>30,'color'=>'#333333'],
                                ['score'=>40,'color'=>'#FFFFFF'],
                                ['score'=>50,'color'=>'#009900'],
                            ],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Research and Experiment',
                            'labels'=>[
                                ['score'=>20,'color'=>'#000000'],
                                ['score'=>30,'color'=>'#333333'],
                                ['score'=>40,'color'=>'#FFFFFF'],
                                ['score'=>50,'color'=>'#009900'],
                            ],
                            'recommendation'=>'Aliquam elementum augue sit amet ipsum viverra, eu dictum est rutrum.'
                        ],
                    ]
                ],
                [
                    'group_name'=>'Banky',
                    'goroup_icon'=>'fas fa-download',
                    'group_color'=>'primary',
                    'description'=> 'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non',
                    'sections'=>[
                        [
                            'section_name'=>'Asking Question',
                            'labels'=>[
                                ['score'=>20,'color'=>'#333333'],
                                ['score'=>30,'color'=>'#000000'],
                                ['score'=>40,'color'=>'#ffffff'],
                                ['score'=>50,'color'=>'#009900'],
                            ],
                            'recommendation'=>'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Objective Thinking',
                            'labels'=>[
                                ['score'=>20,'color'=>'#000000'],
                                ['score'=>30,'color'=>'#333333'],
                                ['score'=>40,'color'=>'#FFFFFF'],
                                ['score'=>50,'color'=>'#009900'],
                            ],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Research and Experiment',
                            'labels'=>[
                                ['score'=>20,'color'=>'#000000'],
                                ['score'=>30,'color'=>'#333333'],
                                ['score'=>40,'color'=>'#FFFFFF'],
                                ['score'=>50,'color'=>'#009900'],
                            ],
                            'recommendation'=>'Aliquam elementum augue sit amet ipsum viverra, eu dictum est rutrum.'
                        ],
                    ]
                ],
                [
                    'group_name'=>'Jack',
                    'goroup_icon'=>'user-secret',
                    'group_color'=>'secondary',
                    'description'=> 'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non',
                    'sections'=>[
                        [
                            'section_name'=>'Practice',
                            'labels'=>[
                                ['score'=>10,'color'=>'#333333'],
                                ['score'=>17,'color'=>'#000000'],
                                ['score'=>20,'color'=>'#ffffff'],
                                ['score'=>40,'color'=>'#009900'],
                            ],
                            'recommendation'=>'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Imagination',
                            'labels'=>[
                                ['score'=>15,'color'=>'#000000'],
                                ['score'=>20,'color'=>'#333333'],
                            ],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Competition',
                            'labels'=>[
                                ['score'=>10,'color'=>'#FFFFFF'],
                                ['score'=>40,'color'=>'#009900'],
                            ],
                            'recommendation'=>'Aliquam elementum augue sit amet ipsum viverra, eu dictum est rutrum.'
                        ],
                    ]
                ],
                [
                    'group_name'=>'Temperate',
                    'goroup_icon'=>'fas fa-temperature-high',
                    'group_color'=>'primary',
                    'description'=> 'Temperate represents a group of learning behaviours that helps a learner to regulate their learning behaviours. This essentially provides balance, intensity and continuity in the masterful and intentional use of the learning skills.',
                    'sections'=>[
                        [
                            'section_name'=>'Humility',
                            'labels'=>[
                               ['score'=>15,'color'=>'#ffffff'],
                                ['score'=>20,'color'=>'#009900'],
                            ],
                            'recommendation'=>'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Ability to admit and correct mistake',
                            'labels'=>[
                                ['score'=>10,'color'=>'#333333'],
                                ['score'=>15,'color'=>'#000000'],
                                ['score'=>17,'color'=>'#ffffff'],
                                ['score'=>20,'color'=>'#009900'],
                                ['score'=>40,'color'=>'#000000'],
                            ],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Self-Discipline',
                            'labels'=>[
                                ['score'=>10,'color'=>'#009900'],
                            ],
                            'recommendation'=>'Aliquam elementum augue sit amet ipsum viverra, eu dictum est rutrum.'
                        ],
                    ]
                ],
                [
                    'group_name'=>'Level of Readiness',
                    'goroup_icon'=>'fas fa-temperature-high',
                    'group_color'=>'primary',
                    'description'=>'This represents a set of salient requirements that ensures that a learner is mentally, emotionally, socially and physically adjusted and therefore ready to receive learning instructions.',
                    'sections'=>[
                        [
                            'section_name'=>'Distraction',
                            'labels'=>[
                                ['score'=>15,'color'=>'#ffffff'],
                                ['score'=>20,'color'=>'#009900'],
                            ],
                            'recommendation'=>'Cras tempus ligula ligula, vitae lacinia lacus vestibulum non. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Demotivation',
                            'labels'=>[
                                ['score'=>10,'color'=>'#333333'],
                                ['score'=>15,'color'=>'#000000'],
                                ['score'=>17,'color'=>'#ffffff'],
                                ['score'=>20,'color'=>'#009900'],
                                ['score'=>40,'color'=>'#000000'],
                            ],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ],
                        [
                            'section_name'=>'Sport and Games',
                            'labels'=>[
                                ['score'=>15,'color'=>'#009900'],
                            ],
                            'recommendation'=>'Aliquam elementum augue sit amet ipsum viverra, eu dictum est rutrum.'
                        ],
                        [
                            'section_name'=>'Music and Dance',
                            'labels'=>[
                                ['score'=>10,'color'=>'#333333'],
                                ['score'=>17,'color'=>'#ffffff'],
                                ['score'=>20,'color'=>'#009900'],
                                ['score'=>40,'color'=>'#000000'],
                            ],
                            'recommendation'=>'lorem ipsum dolor. lorem ipsum dolor'
                        ]
                    ]
                ]
            ]

        ];
        return $data;
        //return response()->json($data);
    }

    public function viewTestResult(){
        $data = $this->mockResult();
        return view("result-to-pdf/result-pdf", $data);
    }
}
