
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($user->student->school->name) }}
        </h2>
    </x-slot>

    <div class="section py-7">
        <div class="container mt-n5">
        <div class="row">
            <h3 class="pl-5">Student details</h3>
        </div>
            <div class="row">
                <div class="col-4">
                    <div class="mx-auto" style="border:2px solid #bcbcbc">

                        @php
                            //default image
                            $image = '/images/profile2.png';
                            if (!is_null($user->image_url)) {
                                $image = $user->image_url;
                            }
                            $age = $user->student->age;
                        @endphp

                        <figure class=" rounded-xl  md:p-4">
                            <img class="w-32 h-32 md:w-48 md:h-auto  rounded-full mx-auto" src="{{asset($image) }}" alt=""
                                 width="384" height="512">
                            <div class="pt-2 md:p-8 text-md-left text-blue-700">
                                <figcaption class="" style="font-size: 1.1rem;">
                                    <div class="pt-3">
                                        <strong class="font-bold">Full name: </strong> {{ $user->name }}
                                    </div>

                                    <div class="pt-1">
                                        <strong class="font-bold">Email: </strong> {{ $user->email }}
                                    </div>
                                    <div class="pt-1">
                                        <strong class="font-bold">Phone Number: </strong> {{ $user->phone_number ?? 'nill' }}
                                    </div>
                                    <div class="pt-1">
                                        <strong class="font-bold">Gender: </strong>{{ $user->student->gender }}
                                    </div>
                                    <div class="pt-1">
                                        <strong class="font-bold">Age: </strong>{{ $age }}
                                    </div>
                                    <div class="pt-1">
                                        <strong class="font-bold">Class: </strong> {{ $user->student->level }}
                                    </div>
                                    <div class="pt-1">
                                        <strong class="font-bold">State: </strong> {{ $user->student->level }}
                                    </div>
                                    <div class="pt-1">
                                        <strong class="font-bold">Country: </strong> {{ $user->student->level }}
                                    </div>
                                </figcaption>
                                <button class="rounded-full w-5 h-5 text-tertiary" title="Edit Profile"><i
                                        class="fa fa-edit" data-toggle="modal" data-target="#profileEditModal" style="padding-top: 10px; font-size: 30px;"></i></button>
                            </div>
                        </figure>
                    </div>


                </div>

                <div class="col-8">

                    <div class="tab-content mt-4 mt-lg-5 pt-5" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-causes" role="tabpanel"
                             aria-labelledby="nav-causes-tab">
                            <div class="row justify-content-between">
                                <div class="col-12 col-lg-12 card shadow-sm border-soft">
                                    <div class="card-body">
                                        <h1 class="text-gray-700 font-bold" style="font-size: 25px;">Test History <span class="badge badge-warning">{{ $testDetail['total_tests'] }}</span></h1>
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
                                                                    <a href="{{ route('result.getResult', $result->testResult->session_id) }}" target='_blank'>
                                                                        <i class="fa fa-print"></i>
                                                                    </a>
                                                                @else
                                                                    <i class="fa fa-print" disabled=""></i>
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
                    <h5 class="modal-title" id="profileEditModalLabel">Edit Student details</h5>
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
                                        <form class="form" novalidate="" action="{{route('school-admin.updateStudent', $user->id)}}" method="post" enctype="multipart/form-data" name="update_profile">
                                            @method('PUT')
                                            @csrf
                                            <div class="row">
                                                <div class="col-12  col-sm-auto mb-3 p-2">
                                                    <div class="mx-auto relative" style="width: 140px;">
                                                        <i class="fa fa-fw fa-close reset-thumbnail text-red-500 absolute d-none"></i>
                                                        <div class="d-flex justify-content-center align-items-center rounded"
                                                             style="height: 140px; background-color: rgb(233, 236, 239);">
                                                            <img src="{{asset($image)}}" alt="" id="preview-thumbnail">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col  d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                    <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                        <h4 class="pt-sm-2 pb-1 mb-0 text-wrap text-sm">{{ $user->name }}</h4>
                                                        <p class="mb-0">{{ $user->email }}</p>
                                                        <input type="hidden" id="image-url" value="{{$image}}">
                                                        <div class="mt-2">
                                                            <button class="btn btn-primary p-1" type="button" id="change-photo">
                                                                <i class="fa fa-fw fa-camera"></i>
                                                                <span style="font-size: 0.656rem">Change Photo</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="text-center text-sm-right">
                                                        <span class="badge badge-secondary">{{ $user->role_id }}</span>
                                                        <div class="text-muted"><small>Joined {{ $user->created_at->format("d-m-Y") }}</small></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-content pt-3">
                                                <div class="tab-pane active">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>First Name</label>
                                                                        <input class="form-control" type="text" name="first_name"
                                                                               placeholder="First name" value="{{$user->first_name}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Middle Name</label>
                                                                        <input class="form-control" type="text"
                                                                               name="middle_name" placeholder="Middle name"
                                                                               value="{{$user->middle_name}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Last Name</label>
                                                                        <input class="form-control" type="text"
                                                                               name="last_name" placeholder="Last name"
                                                                               value="{{$user->last_name}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Phone Number</label>
                                                                        <input class="form-control" type="text" value="{{ $user->phone }}"
                                                                               placeholder="Phone Number">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input class="form-control" type="email" value="{{ $user->email }}"
                                                                               placeholder="Email address" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Age</label>
                                                                        <select name="age" id="age" class="block mt-1 w-full border-gray-200" required>
                                                                            <option value="">Select Age Range</option>
                                                                            <option value="5-12" {{($age =='5-12') ? 'selected' : ''}}>5 - 12 yrs</option>
                                                                            <option value="12-20" {{($age =='12-20') ? 'selected' : ''}}>12 - 20 yrs</option>
                                                                            <option value="20-35" {{($age =='20-35') ? 'selected' : ''}}>20 - 35 yrs</option>
                                                                            <option value="35-55" {{($age =='35-55') ? 'selected' : ''}}>35 - 55 yrs</option>
                                                                        </select>
                                                                        {{--<input class="form-control" type="text" name="age"
                                                                               placeholder="Age" value="{{}}">--}}
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Level</label>
                                                                        <input class="form-control" type="text"
                                                                               name="level" placeholder="Class"
                                                                               value="{{$user->student->level}}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 mb-3">
                                                            <div class="mb-2"><b>Change Password</b>
                                                                <input type="checkbox" class="form-control" id="edit_password" name="edit_password"
                                                                       style="width: 20px; height: 20px; border: 1px solid #ccc;">
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>New Password</label>
                                                                        <input class="form-control password" name="password" type="password" placeholder="••••••" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Confirm <span
                                                                                class="d-none d-xl-inline">Password</span></label>
                                                                        <input class="form-control password" name="confirmPassword" type="password" placeholder="••••••" disabled>
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
                                                    <input type="file" name="profile_image" id="profile-img">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!--/Form-->
            </div>




        @push('scripts')
        <script src="/js/app.js"></script>
        <script src="/js/script.js"></script>
        <script src="/js/axios.min.js"></script>
        <script src="/js/sweetalert2.all.min.js"></script>
                <script>
                    $('#edit_password').on('click',function (e){
                        $('.password').val('');
                        if($(this).prop('checked')){
                            $('.password').attr('disabled', false)
                        }else {
                            $('.password').attr('disabled', true);

                        }
                    })

                
                </script>

    @endpush
</x-app-layout>
