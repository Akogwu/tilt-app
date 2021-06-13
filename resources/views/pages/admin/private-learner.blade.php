<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Private Learner') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div>
                        <x-jet-application-logo class="block h-12 w-auto" />
                    </div>

{{--                    <div class="grid grid-cols-12 gap-6 mt-5">--}}
{{--                        <h4>ABC</h4>--}}
{{--                    </div>--}}

                    <div class="my-8 w-full justify-content-between">
                        <div class="recent-tests pr-3">
                            <h1 class="uppercase text-gray-700 font-bold my-2.5">Private Learner({{$privateLearners->total()}})</h1>
                            <div class="w-full">
                                <div class="-my-2 overflow-x-auto sm:-mx-12 lg:-mx-12">
                                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Name
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Email
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        phone Number
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Age Range
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Gender
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        School
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Level
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Test Taken
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Status
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">

                                                @foreach($privateLearners as $privateLearner)
                                                    @php
                                                        $image = $privateLearner->user->image_url ?? \App\Util\GeneralUtil::DEFAULT_IMAGE_PLACEHOLDER_URL;
                                                    @endphp
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0 h-10 w-10">
                                                                    <img class="h-10 w-10 rounded-full"
                                                                         src="{{asset($image)}}"
                                                                         alt="" />
                                                                </div>
                                                                <div class="ml-4">
                                                                    <div class="text-sm text-gray-500">
                                                                        {{$privateLearner->user->name}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="ml-4">
                                                                    <div class="text-sm text-gray-500">
                                                                        {{$privateLearner->user->email}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-500">
                                                                {{$privateLearner->user->phone_number}}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-500">
                                                                {{$privateLearner->age}}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-500">
                                                                {{$privateLearner->gender}}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-500">
                                                                {{$privateLearner->school}}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-500">
                                                                {{$privateLearner->level}}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-500">
                                                                {{$privateLearner->user->status}}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-500">
                                                                <select name="status" id="" class="form-control">
                                                                    <option value="1" {{($privateLearner->user->status ==1) ? 'selected': ''}}>Active</option>
                                                                    <option value="0" {{($privateLearner->user->status ==0) ? 'selected': ''}}>Inactive</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <tfoot class="bg-gray-50">
                                                <tr class="pb-4">
                                                    <td class="px-5">

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
