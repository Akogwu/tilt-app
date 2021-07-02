<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admins') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div>
                        <x-jet-application-logo class="block h-12 w-auto" />
                    </div>

                    <div class="my-8 w-full justify-content-between">
                        <div class="recent-tests pr-3">
                            <h1 class="uppercase text-gray-700 font-bold my-2.5">Admin( {{$admins->total()}})</h1>
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
                                                        Status
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">

                                                @foreach($admins as $admin)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="ml-4">
                                                                    <div class="text-sm text-gray-500">
                                                                        {{$admin->name}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>


                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-500">
                                                                {{$admin->email}}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-500">
                                                                <select name="status" id="" class="form-control">
                                                                    <option value="1" {{($admin->status ==1) ? 'selected': ''}}>Active</option>
                                                                    <option value="0" {{($admin->status ==0) ? 'selected': ''}}>Inactive</option>
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
