<x-app-layout>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div>
                        <x-jet-application-logo class="block h-12 w-auto" />
                    </div>


                    <div class="my-8 w-full justify-content-between">
                        <div class="recent-tests pr-3">
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
                                                        value
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Action
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                @if($settings)
                                                    @foreach($settings as $setting)
                                                        <tr>

                                                            <td class="px-3 py-4 whitespace-nowrap text-muted" style="font-size: 15px;">
                                                                {{$setting->name}}
                                                            </td>

                                                            <td class="px-3 py-4 whitespace-nowrap">
                                                                {{$setting->value}}
                                                            </td>

                                                            <td class="px-3 py-4 whitespace-nowrap">
{{--                                                                <a href="#" class="pr-1 text-tertiary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="view">--}}
{{--                                                                    <i class="fa fa-eye"></i>--}}
{{--                                                                </a>--}}

                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#{{$setting->name}}">
                                                                    Edit
                                                                </button>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" rowspan="5"> <p class="text-center"> No record available</p></td>
                                                    </tr>
                                                @endif


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

                            @foreach($settings as $setting)
                                <div class="modal fade" id="{{$setting->name}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="{{$setting->name}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Update Settings</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{route('setting.update')}}" method="post">
                                                @csrf
                                            <div class="modal-body">

                                                    <div class="mb-3 row">
                                                        <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="hidden" value="{{$setting->name}}"  name="name" />
                                                            <input type="text" class="form-control" value="{{$setting->name}}" name="tag_name" id="tag_name" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="inputValue" class="col-sm-2 col-form-label">Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control" name="value" value="{{$setting->value}}" id="value">
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                            </form>

                                            {{--                                            endform--}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>



    <!-- Modal -->


    @push('scripts')
        <script src="/js/app.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    @endpush
</x-app-layout>
