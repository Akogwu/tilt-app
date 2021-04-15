@extends('layouts.client')

@section('content')
    <section class="section bg-gray-200 overlay-gray-100 text-white"
             data-background="">
        <div class="container">
            <div class="row justify-content-center pt-5">
                <div class="col-10 mx-auto text-center">

                    @php
                    //default image
                        $image ='/images/profile.jpg';
                            if (!is_null($user->image_url)){
                                $image =$user->image_url;
    }
                    @endphp

                    <figure class=" rounded-xl  md:p-0">
                        <img class="w-32 h-32 md:w-48 md:h-auto  rounded-full mx-auto" src="{{$image}}" alt="" width="384" height="512">
                        <div class="pt-2 md:p-8 text-center md:text-left ">
                            <figcaption class="font-medium">
                                <div class="font-bold text-blue-900">
                                    {{$user->name}}
                                </div>
                                <div class="text-gray-500">
                                    {{$user->role_id}}
                                </div>
                            </figcaption>
                            <button class="rounded-full w-5 h-5 text-tertiary" title="Edit Profile"><i class="fas fa-edit fa-2x"></i></button>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </section>


    <div class="section pt-0">
        <div class="container mt-n5">
            <div class="row">
                <div class="col">
                    <!-- Tab -->
                    <nav>
                        <div class="nav nav-tabs flex-column flex-md-row shadow-sm border-soft justify-content-around bg-white rounded mb-3 py-3"
                             id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-evidence-tab" data-toggle="tab" href="#" role="tab" aria-controls="nav-evidence" aria-selected="true">
                                <i class="fas fa-file-alt"></i>No. of test taken <span class="badge badge-warning">{{$testDetail['total_tests']}}</span>
                            </a>
                            <a class="nav-item nav-link" id="nav-causes-tab" data-toggle="tab" href="#" role="tab" aria-controls="nav-causes" aria-selected="false">
                                <i class="fas fa-chart-pie"></i>Success Transactions <span class="badge badge-dark">0</span>
                            </a>
                            <a class="nav-item nav-link" id="nav-effects-tab" data-toggle="tab" href="#" role="tab" aria-controls="nav-effects" aria-selected="false">&#8358; Total amount spent <span class="badge badge-success">0.00</span></a>
                        </div>
                    </nav><!-- Tab -->

                    <div class="tab-content mt-4 mt-lg-5" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-causes" role="tabpanel" aria-labelledby="nav-causes-tab">
                            <div class="row justify-content-between">
                                <div class="col-12 col-lg-8 card shadow-sm border-soft">
                                    <div class="card-body">
                                        <h1 class="text-gray-700 font-bold">Test History</h1>
                                        <div class="flex justify-content-between my-3">
                                            <table class="table">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th><span class="">Test Date</span></th>
                                                        <th><span class="">Average Score</span></th>
                                                        <th><span class="">Total Score</span></th>
                                                        <th><span class="">Obtainable Score</span></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if(!is_null($testResults))
                                                @foreach($testResults as $result)
                                                    <tr>
                                                        <td>{{$result['created_at']}}</td>
                                                        <td>{{$result->testResult->avg_score}}%</td>
                                                        <td>{{$result->testResult->total_score}}</td>
                                                        <td>{{$result->testResult->obtainable_score}}</td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-muted">No record found</td>

                                                    </tr>
                                                @endif
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <aside class="col-12 col-lg-4 mt-3 mt-lg-0 d-none d-lg-block z-2">
                                    <div class="card shadow-sm border-soft p-3">
                                        <div class="card-body">
                                            <h4 class="pb-3">We live in a Greenhouse</h4>
                                            <p>Life on Earth depends on energy coming from the Sun. About half the light reaching Earth's
                                                atmosphere passes through the air and clouds to the surface, where it is absorbed and then
                                                radiated upward in the form of infrared heat. About 90 percent of this heat is then absorbed
                                                by the greenhouse gases and radiated back toward the surface.</p>
                                        </div>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
