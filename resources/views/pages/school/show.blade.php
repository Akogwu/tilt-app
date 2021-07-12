<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schools') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="block mb-8">
                <a href="{{ route('schools.index') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Schools</a>
            </div>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Country</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">State</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">City</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zipcode</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $school->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $school->address }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $school->countryRelation->name ?? '' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $school->stateProvince->name ?? '' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $school->city }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $school->zipcode }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered on:</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Number of students</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan status/(No. left)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Admin</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin Phone Number</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $school->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $school->student->count() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $school->getRemainingCapacity() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $school->schoolAdmin->user->name ?? '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $school->schoolAdmin->user->phone }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="flex flex-col my-9">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr class="bg-gray-200">
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Phone Number
                                    </th>
                                     <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        City
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        State
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Country
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>


                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @if($students)
                                    @foreach($students as $student)
                                        <tr>
                                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <a href="#" class="font-semibold">{{ $student->user->name }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $student->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $student->user->phone}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $student->city }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $student->state->name }}</div>
                                            </td>


                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $student->country->name }}
                                            </td>

                                            <td class="px-6 py-4 inline-flex justify-content-around whitespace-nowrap text-right text-sm font-medium">
                                                @if($student->request_delete == 1)
                                                    <span><i class="fa fa-check text-danger request-delete" data-user_id="{{$student->user_id}}" data-action="2" title="Approve Request delete"></i></span>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <span><i class="fa fa-ban text-success request-delete" data-user_id="{{$student->user_id}}" data-action="-1" title="Reject Request delete"></i></span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No data found</td>
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

    @push('scripts')
        <script src="/js/app.js"></script>
        <script src="/js/script.js"></script>

        <script src="/js/axios.min.js"></script>
        <script src="/js/sweetalert2.all.min.js"></script>
        <script>
            $('.request-delete').on('click', function (e){
                let studentId = $(this).data('user_id');
                let action = $(this).data('action');
                let title = $(this).attr('title');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: title + '?',
                    text: "This action can not be undo",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        //request delete
                        axios({
                            method: 'post',
                            url: '/school-management/request-delete/'+studentId,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "action": action
                            }
                        }).then(function (response){
                            swalWithBootstrapButtons.fire(
                                'Success!',
                                'Action successful.',
                                'success'
                            )
                            setTimeout(function(){
                                location.reload();
                            }, 2000);

                        });

                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Action cancelled :)',
                            'error'
                        );

                    }
                })
            })
        </script>
    @endpush

</x-app-layout>
