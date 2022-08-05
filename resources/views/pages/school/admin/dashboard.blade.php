<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($data['school']['name']) }}
        </h2>
    </x-slot>

    <div class="py-5">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Cards -->
            <div class="grid gap-6 mb-5 md:grid-cols-2 xl:grid-cols-3">
                <!-- Card -->
                <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Students
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{$data['total_students']}}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Tests
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200" >
                            {{$data['total_test']}}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800" style="position: relative;">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Student Capacity
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{$data['school_capacity']}}
                            @if($data['school_capacity'] < 5)
                                <button class="btn btn-danger rounded" style="position: absolute; right: 1.2rem;"
                                        data-toggle="modal" data-target="#addStudentCapacity"> Increase Capacity
                                </button>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addStudentCapacity" tabindex="-1" role="dialog" aria-labelledby="addStudentCapacityTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #11AB7C">
                            <h5 class="modal-title" style="color: #f5f5f5">Increase School Capacity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="text-white">&times;</span>
                            </button>
                        </div>

                        <form class="needs-validation" action="{{route('schoolCapacity.payment', ['school_id'=>$data['school']['id']])}}" method="GET" novalidate>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <span class="badge badge-danger mb-2">Rate: &#8358; {{$data['INDIVIDUAL_STUDENT_FLAT_RATE']}} per student</span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="capacity">Student Capacity</label>
                                    <input type="number" class="form-control" name="capacity" id="capacity" placeholder="0" min="1" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="capacity">Total Amount</label>
                                    <input type="text" class="form-control" id="total" disabled>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Proceed</button>
                        </div>
                    </form>
                    </div>

                </div>
            </div>

            <div class="">
                <h3 class="text-muted">Most recent students</h3>
            </div>
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Phone Number</th>
                            <th class="px-4 py-3">Date Registered</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">


                        @if(count($data['students']) > 0)
                            @foreach($data['students'] as $student)
                                <tr class="text-gray-700 dark:text-gray-400">
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
                                        {{$student->created_at->diffForHumans()}}
                                    </td>

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

            <div class="py-5">
                <h3 class="text-muted">Most recent Transactions</h3>
            </div>
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Transaction ID</th>
                            <th class="px-4 py-3">Payment purpose</th>
                            <th class="px-4 py-3">Quantities </th>
                            <th class="px-4 py-3">Amount </th>
                            <th class="px-4 py-3">Date</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                        <tr>
                            <td colspan="5" class="text-center py-3"> No record found </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
    @push('scripts')
        <script src="/js/app.js"></script>
        <script>
            $('#capacity').on('change',function(){
                let rate= {!! $data['INDIVIDUAL_STUDENT_FLAT_RATE'] !!};
                let capacity=$('#capacity').val();
                let sum = parseInt(capacity) * parseInt(rate);
                $('#total').val('₦' + sum);
                //alert(sum);
            });
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>
    @endpush
</x-app-layout>
