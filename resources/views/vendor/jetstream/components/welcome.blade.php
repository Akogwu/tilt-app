@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection
<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div>
        <x-jet-application-logo class="block h-12 w-auto" />
    </div>


    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-green-400 via-green-500 to-green-700">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <img src="/images/graduation.svg" height="24px" width="24px" alt="">
                    </div>
                    <div class="text-3xl font-bold leading-8 mt-6">4
                    </div>
                    <div class="text-base text-gray-600 mt-1">Students Registered</div>
                </div>
            </div>
        </div>
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-700">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <img src="/images/school.svg" height="24px" width="24px" alt="">

                    </div>
                    <div class="text-3xl font-bold leading-8 mt-6">3</div>
                    <div class="text-base text-gray-600 mt-1">School Enrolled</div>
                </div>
            </div>
        </div>
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-gray-300 via-gray-500 to-gray-700">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <img src="/images/test.svg" height="24px" width="24px" alt="">
                    </div>
                    <div class="text-3xl font-bold leading-8 mt-6">20</div>
                    <div class="text-base text-gray-600 mt-1 text-white">Total Test Taken</div>
                </div>
            </div>
        </div>
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-indigo-400 via-indigo-500 to-indigo-700">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <img src="/images/credit-card.svg" height="24px" width="24px" alt="">
                    </div>
                    <div class="text-3xl font-bold leading-8 mt-6">8</div>
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Average Score
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    Jane Cooper
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    jane.cooper@example.com
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm text-gray-500">
                                                   90%
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">1 week ago</div>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                </tr>

                                <!-- More items... -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1">
            <h1 class="uppercase text-gray-700 font-bold my-2.5">High Performing Schools</h1>
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    School
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No. of Tests
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                Gateway Int'l
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Area 2, garki, Abuja Capital Territory, Nigeria
                                            </div>
                                        </div>
                                    </div>



                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">5</div>

                                </td>
                            </tr>

                            <!-- More items... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
