<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div>
                        <x-jet-application-logo class="block h-12 w-auto" />
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div
                            class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-green-400 via-green-500 to-green-700">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <img src="/images/graduation.svg" height="24px" width="24px" alt="" />
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{ $data['total_students'] }}</div>
                                    <div class="text-base text-gray-600 mt-1">Students Registered</div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-700">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <img src="/images/school.svg" height="24px" width="24px" alt="" />
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$data['total_school']}}</div>
                                    <div class="text-base text-gray-600 mt-1">School Enrolled</div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-gray-300 via-gray-500 to-gray-700">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <img src="/images/test.svg" height="24px" width="24px" alt="" />
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$data['total_test_taken']}}</div>
                                    <div class="text-base text-gray-600 mt-1 text-white">Total Test Taken</div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-indigo-400 via-indigo-500 to-indigo-700">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <img src="/images/credit-card.svg" height="24px" width="24px" alt="" />
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{ $data['successful_transaction'] }}</div>
                                    <div class="text-base text-gray-600 mt-1">Successful Transactions</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my-8  flex  w-full justify-content-between">
                        <div class="recent-tests w-4/6 pr-3">
                            <h1 class="uppercase text-gray-700 font-bold my-2.5">Recent Tests</h1>
                            <div class="flex flex-col w-full">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Name
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Average Score
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Date
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($data['latest_test'] as $test)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0 h-10 w-10">
                                                                    <img class="h-10 w-10 rounded-full"
                                                                         src="{{$test['image']}}"
                                                                         alt="" />
                                                                </div>
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        {{ $test['name']  }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="ml-4">
                                                                    <div class="text-sm text-gray-500">
                                                                        {{$test['percentage']}}%
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-900">{{$test['date']}}</div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <tfoot class="bg-gray-50">
                                                <tr class="pb-4">
                                                    <td class="px-5">
                                                        {{$data['latest_test']->withPath('/dashboard')}}
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1">
                            <h1 class="uppercase text-gray-700 font-bold my-2.5" style="color: #db7f16">High Performing Schools</h1>
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    School
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    No. of Tests
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($data['schools'] as $school)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{$school['school_name']}}
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    {{$school['location']}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{$school['total_test_taken']}}</div>

                                                    </td>
                                                </tr>
                                            @endforeach
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
    @push('scripts')
        <script src="/js/app.js"></script>
    @endpush
</x-app-layout>
