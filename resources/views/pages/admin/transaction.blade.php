<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div>
                        <x-jet-application-logo class="block h-12 w-auto" />
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-700">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <img src="/images/transaction.svg" height="24px" width="24px" alt="" />
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$data['total']}}</div>
                                    <div class="text-base text-gray-600 mt-1">Total Transactions</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-red-400 via-red-500 to-red-700">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <img src="/images/close.svg" height="24px" width="24px" alt="" />
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$data['failed']}}</div>
                                    <div class="text-base text-gray-600 mt-1">Failed Transaction</div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-green-400 via-green-500 to-green-700">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <img src="/images/check-mark.svg" height="24px" width="24px" alt="" />
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$data['success']}}</div>
                                    <div class="text-base text-gray-600 mt-1 text-white">Successful Transactions</div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-indigo-400 via-indigo-500 to-indigo-700">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <img src="/images/naira_sign.svg" height="24px" width="24px" alt="" />
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{$data['total_funds']}}</div>
                                    <div class="text-base text-gray-600 mt-1">Total Funds</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my-8 w-full justify-content-between">
                        <div class="recent-tests pr-3">
                            <h1 class="uppercase text-gray-700 font-bold my-2.5">Transactions</h1>
                            <div class="w-full">
                                <div class="-my-2 overflow-x-auto sm:-mx-12 lg:-mx-12">
                                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        S/N
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Name
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Purpose
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Amount(&#8358;)
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Date
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">

                                                @foreach($transactions as $transaction)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">

                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        {{$loop->iteration}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">

                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        {{$transaction->user->name}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="ml-4">
                                                                    <div class="text-sm text-gray-500">
                                                                        {{$transaction->payment_type}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-900">{{$transaction->amount}}</div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            {{($transaction->status==0) ? 'pending' : 'paid'}}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            {{$transaction->created_at}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot class="bg-gray-50">
                                                    <tr class="pb-4">
                                                        <td class="px-5">
                                                            {{$transactions->links()}}
                                                        </td>
                                                    </tr>
                                                </tfoot>
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
    @push('scripts')
        <script src="/js/app.js"></script>
    @endpush
</x-app-layout>
