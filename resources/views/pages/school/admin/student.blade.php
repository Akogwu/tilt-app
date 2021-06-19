@push('styles')
{{--    <link rel="stylesheet" href="/css/custom.css">--}}
{{--    <link rel="stylesheet" href="/dist/slick/slick/slick.css">--}}
{{--    <link rel="stylesheet" href="/dist/slick/slick/slick-theme.css">--}}
    <style>
        /*add full-width input fields*/
        .form-control {
             border: 1px solid #ccc;
             box-sizing: border-box;
         }
          /*set a style for all buttons*/
            .add-student {
                float: right;
            }
        /*set styles for the cancel button*/
        .cancelbtn {
            padding: 14px 20px;
            background-color: #FF2E00;
        }
        /*float cancel and signup buttons and add an equal width*/
        .cancelbtn,
        .signupbtn {
            float: left;
            width: 50%
        }


        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        /*define the modal-content background*/

        .modal-content {
            background-color: #fefefe;
            margin: 0 auto 5% auto;
            border: 1px solid #888;
            width: 80%;
            padding-bottom: 40px;
        }
        /*define the close button*/

        .close {
            position: absolute;
            right: 35px;
            top: 5px;
            color: #000;
            font-size: 40px;
            font-weight: bold;
        }
        /*define the close hover and focus effects*/

        .close:hover,
        .close:focus {
            color: red;
            cursor: pointer;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        @media screen and (max-width: 300px) {
            .cancelbtn,
            .signupbtn {
                width: 100%;
            }
        }
    </style>

@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($schoolName) }}
        </h2>
    </x-slot>

    <div class="py-5">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white">
            <div class="py-4">
                <h2 class="text-md text-gray-800">Students list</h2>
                <img src="{{asset('images/icons-add.png')}}" onclick="document.getElementById('id01').style.display='block'" alt="" id="add-student">
            </div>
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">S/N</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Phone Number </th>
                            <th class="px-4 py-3">Date Enrolled</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @if(count($students) > 0)
                            @foreach($students as $student)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        {{($students->currentPage()-1) * $students->perpage() + $loop->index +1}}
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="font-semibold">{{$student->user->name}}</p>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{$student->user->email}}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{$student->user->phone}}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{$student->created_at}}
                                    </td>
                                    <td>
                                        <span><i class="fa fa-edit link" data-link="{{$student->id}}"></i></span>
                                        <span><i class="fa fa-trash"></i></span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-3"> No record found </td>
                            </tr>
                        @endif


                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>


    </div>
    <div class="container-fluid">

        <div id="id01" class="modal">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>

            <form class="modal-content animate" id="addStudentForm" method="post" action="{{ route('student.register') }}">
                <div class="container">
                @csrf
                <div class="row justify-content-center">

                    <div class="col-8">
                        <div class="py-5">
                            <h3>Create Student</h3>
                            <div class="row text-danger px-3" id="errorMessage"></div>
                            <div class="row text-success px-3" id="successMessage"></div>
                            <div class="row">

                                <div class="col">
                                    <div class="form-group">
                                        <label for="first_name" class="">First Name</label>
                                        <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" required />
                                        <small class="text-danger" id="first_name_error"></small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="middle_name" >Middle Name</label>
                                        <input type="text" id="middle_name" name="middle_name" class="form-control" placeholder="Middle Name" />
                                        <small class="text-danger" id="middle_name_error"></small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="last_name" >Last Name</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" required />
                                        <small class="text-danger" id="last_name_error"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="email" class="" >Email Address</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required />
                                        <small class="text-danger" id="email_error"></small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="phone_number" class="" >Phone Number</label>
                                        <input type="tel" id="phone_number" name="phone_number" class="form-control"  placeholder="Phone Number"/>
                                        <small class="text-danger" id="phone_number_error"></small>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="age" class="" >Age</label>
                                        <input type="text" id="age" name="age" class="form-control" placeholder="Age" required />
                                        <small class="text-danger" id="age_error"></small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="gender" class="" >Gender</label>
                                        <select class="form-control" name="gender" required>
                                            <option value="">Select gender</option>
                                            <option value="Male" >Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        <small class="text-danger" id="gender_error"></small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="age" class="" >Class/Level</label>
                                        <input type="text" id="level" name="level" class="form-control" placeholder="Class/Level" required/>
                                        <small class="text-danger" id="age_error"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="password" class="" >Password</label>
                                        <input type="tel" id="password" name="password" class="form-control" placeholder="Password" required/>
                                        <small class="text-danger" id="password_error"></small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="password" class="" >Confirm Password</label>
                                        <input type="tel" id="confirm-password" name="confirm_password" class="form-control" placeholder="Confirm password" required/>
                                        <small class="text-danger" id="confirm_password_error"></small>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="school_id" value="{{$schoolId}}">
                        <div class="row">
                            <button class="btn btn-danger add-student">Submit</button>
                        </div>
                    </div>
                </div>
                </div>
            </form>

        </div>


    </div>
@push('scripts')
        <script src="/js/app.js"></script>
        <script src="/js/script.js"></script>
        <script src="/js/axios.min.js"></script>
        <script src="/dist/slick/slick/slick.js"></script>
        <script>
            var modal = document.getElementById('id01');
            //const axios = require('axios');
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
            $('.link').on('click', function (e){
                alert($(this).data('link'));
                axios({
                    method: 'get',
                    url: '/countries',
                    responseType: 'stream'
                }).then(function (response) {
                        console.log(response.data)
                    });
            });

            //submit form
                $('#addStudentForm').on('submit', function (e){
                    e.preventDefault();

                    axios({
                        method: 'post',
                        url: $(this).attr('action'),
                        data: $(this).serialize()
                    }).then(function (response){
                        try {
                            response.data
                            $('#successMessage').html(response.data.message);
                            //reload

                            setTimeout(function(){
                                location.reload();
                                }, 2500);

                        }catch (error){
                            console.error(error)
                        }
                    }).catch(function (error) {
                        if (error.response) {
                            console.log(error.response.data);
                            $('#errorMessage').html(error.response.data.message);

                        } else if (error.request) {

                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.log('Error', error.message);
                            $('#errorMessage').html('Error occurred, please try again');

                        }
                        //console.log(error.config);
                    });

                });
        </script>

    @endpush
</x-app-layout>
