@extends('layouts.client')

@section('content')
    <section class="section bg-gray-200 overlay-gray-100 text-white" data-background="">
        <div class="container">
            <div class="row justify-content-center pt-5">
                <div class="col-10 mx-auto text-center">

                    @php
                        //default image
                        $image = '/images/profile.jpg';
                        if (!is_null($user->image_url)) {
                            $image = $user->image_url;
                        }
                    @endphp

                    <figure class=" rounded-xl  md:p-0">
                        <img class="w-32 h-32 md:w-48 md:h-auto  rounded-full mx-auto" src="{{ $image }}" alt=""
                            width="384" height="512">
                        <div class="pt-2 md:p-8 text-center md:text-left ">
                            <figcaption class="font-medium">
                                <div class="font-bold text-blue-900">
                                    {{ $user->name }}
                                </div>
                                <div class="text-gray-500">
                                    {{ $user->role_id }}
                                </div>
                            </figcaption>
                            <button class="rounded-full w-5 h-5 text-tertiary" title="Edit Profile"><i
                                    class="fas fa-edit fa-2x" data-toggle="modal"
                                    data-target="#profileEditModal"></i></button>
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
                            <a class="nav-item nav-link active" id="nav-evidence-tab" data-toggle="tab" href="#" role="tab"
                                aria-controls="nav-evidence" aria-selected="true">
                                <i class="fas fa-file-alt"></i>No. of test taken <span
                                    class="badge badge-warning">{{ $testDetail['total_tests'] }}</span>
                            </a>
                            <a class="nav-item nav-link" id="nav-causes-tab" data-toggle="tab" href="#" role="tab"
                                aria-controls="nav-causes" aria-selected="false">
                                <i class="fas fa-chart-pie"></i>Success Transactions <span class="badge badge-dark">0</span>
                            </a>
                            <a class="nav-item nav-link" id="nav-effects-tab" data-toggle="tab" href="#" role="tab"
                                aria-controls="nav-effects" aria-selected="false">&#8358; Total amount spent <span
                                    class="badge badge-success">0.00</span></a>
                        </div>
                    </nav><!-- Tab -->

                    <div class="tab-content mt-4 mt-lg-5" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-causes" role="tabpanel"
                            aria-labelledby="nav-causes-tab">
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
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (!is_null($testResults))
                                                        @foreach ($testResults as $result)
                                                            <tr>
                                                                <td>{{ $result['created_at'] }}</td>
                                                                <td>{{ $result->testResult->avg_score }}%</td>
                                                                <td>{{ $result->testResult->total_score }}</td>
                                                                <td>{{ $result->testResult->obtainable_score }}</td>
                                                                <td>
                                                                    <a href="{{ route('result.summary', $result->testResult->session_id) }}"
                                                                        class="pr-1 text-tertiary"
                                                                        title="view summary result"><i
                                                                            class="fa fa-eye"></i></a>
                                                                    @if ($result->testResult->payment_status == 1)
                                                                        <a
                                                                            href="{{ route('result.getResult', $result->testResult->session_id) }}"><i
                                                                                class="fa fa-print"></i></a>
                                                                    @else
                                                                        <i class="fa fa-print" disabled="">
                                                                    @endif
                                                                </td>
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
                                            <p>Life on Earth depends on energy coming from the Sun. About half the light
                                                reaching Earth's
                                                atmosphere passes through the air and clouds to the surface, where it is
                                                absorbed and then
                                                radiated upward in the form of infrared heat. About 90 percent of this heat
                                                is then absorbed
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


    <!-- Modal -->
    <div class="modal fade" id="profileEditModal" tabindex="-1" aria-labelledby="profileEditModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileEditModalLabel">Edit your details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--Form-->

                    <div class="row">
                        <div class="col mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="e-profile">
                                        <div class="row">
                                            <div class="col-12 col-sm-auto mb-3">
                                                <div class="mx-auto" style="width: 140px;">
                                                    <div class="d-flex justify-content-center align-items-center rounded" 
                                                    style="height: 140px; background-color: rgb(233, 236, 239);">
                                                    <img src="/images/thumbnail.png" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">John Smith</h4>
                                                    <p class="mb-0">@johnny.s</p>
                                                    <div class="text-muted"><small>Last seen 2 hours ago</small></div>
                                                    <div class="mt-2">
                                                        <button class="btn btn-primary p-1" type="button">
                                                            <i class="fa fa-fw fa-camera"></i>
                                                            <span style="font-size: 0.656rem">Change Photo</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="text-center text-sm-right">
                                                    <span class="badge badge-secondary">administrator</span>
                                                    <div class="text-muted"><small>Joined 09 Dec 2017</small></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-content pt-3">
                                            <div class="tab-pane active">
                                                <form class="form" novalidate="">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Full Name</label>
                                                                        <input class="form-control" type="text" name="name"
                                                                            placeholder="John Smith" value="John Smith">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Username</label>
                                                                        <input class="form-control" type="text"
                                                                            name="username" placeholder="johnny.s"
                                                                            value="johnny.s">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input class="form-control" type="text"
                                                                            placeholder="user@example.com">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <div class="form-group">
                                                                        <label>About</label>
                                                                        <textarea class="form-control" rows="5"
                                                                            placeholder="My Bio"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 mb-3">
                                                            <div class="mb-2"><b>Change Password</b></div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>New Password</label>
                                                                        <input class="form-control" type="password"
                                                                            placeholder="••••••">
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Confirm <span
                                                                                class="d-none d-xl-inline">Password</span></label>
                                                                        <input class="form-control" type="password"
                                                                            placeholder="••••••">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col d-flex justify-content-end">
                                                            <button class="btn btn-primary" type="submit">Save
                                                                Changes</button>
                                                        </div>
                                                    </div>
                                                    <input type="file" name="" id="profile-img">
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!--/Form-->
            </div>
        @endsection
