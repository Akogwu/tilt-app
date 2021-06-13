<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($schoolName) }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white">
            <div class="py-4">
                <h2 class="text-md text-gray-800">Students list</h2>

                <button class="btn btn-circle btn-behance">Add Student</button>
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
                        <tr>
                            <td colspan="6" class="text-center py-3"> No record found </td>
                        </tr>
                        {{--<tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <p class="font-semibold">1</p>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                3456
                            </td>
                            <td class="px-4 py-3 text-sm">
                                rty66
                            </td>
                            <td class="px-4 py-3 text-sm">
                                7s
                            </td>
                            <td class="px-4 py-3 text-sm">
                                69.95
                            </td>
                            <td class="px-4 py-3 text-sm">
                                6/10/2020
                            </td>
                        </tr>--}}

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
    @push('scripts')
        <script src="/js/app.js"></script>
    @endpush
</x-app-layout>
