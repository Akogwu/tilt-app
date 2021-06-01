<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create School
        </h2>
    </x-slot>

    <div>
        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form method="post" action="{{ route('register.school') }}">
                    @csrf
                    <div class="shadow overflow-hidden sm:rounded-md grid grid-cols-2 bg-white">

                        <div class="school-detail">
                            <h2 class="p-6 display-1 uppercase text-black font-bold">School Details</h2>
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <label for="school_name" class="block font-medium text-sm text-gray-700">School name</label>
                                <input type="text" name="school_name" id="school_name" class="form-input 2xl:focus-within:bg-gray-100 rounded-md shadow-sm mt-1 block w-full"
                                       value="{{ old('school_name', '') }}" />
                                @error('school_name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="px-4 py-5 bg-white sm:p-6">
                                <label for="school_address" class="block font-medium text-sm text-gray-700">School Address</label>
                                <input type="text" name="school_address" id="school_address" class="form-input 2xl:focus-within:bg-gray-100 rounded-md shadow-sm mt-1 block w-full"
                                       value="{{ old('school_address', '') }}" />
                                @error('school_address')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="px-4 py-5 bg-white sm:p-6">
                                <label for="school_description" class="block font-medium text-sm text-gray-700">School description</label>
                                <textarea name="school_description" id="school_description" class="form-input 2xl:focus-within:bg-gray-100 rounded-md shadow-sm mt-1 block w-full" ></textarea>
                                @error('school_description')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="px-4 py-5 bg-white sm:p-6 grid grid-cols-2 gap-2">
                                <div>
                                    <label for="school_country" class="block font-medium text-sm text-gray-700">Select country</label>
                                    <select name="school_country"  id="school_country" class="block rounded-md 2xl:focus-within:bg-gray-100 shadow-sm mt-1 block w-full">
                                        @if($countries)
                                            <optgroup label="Countries">
                                                <option>Select country</option>
                                            @foreach($countries as $country)

                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>

                                            @endforeach
                                            </optgroup>
                                        @endif
                                    </select>
                                    @error('school_country')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="school_state" class="block font-medium text-sm text-gray-700">State</label>
                                    <select name="school_state" disabled id="school_state" placeholder="Select state" class="block rounded-md 2xl:focus-within:bg-gray-100 shadow-sm mt-1 block w-full">

                                    </select>
                                    @error('school_state')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="py-5">
                                    <label for="school_city" class="block font-medium text-sm text-gray-700">School city</label>
                                    <input type="text" name="school_city" id="school_city" class="form-input 2xl:focus-within:bg-gray-100 rounded-md shadow-sm mt-1 block w-full"
                                           value="{{ old('school_city', '') }}" />
                                    @error('school_city')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="py-5">
                                    <label for="school_zipcode" class="block font-medium text-sm text-gray-700">Zipcode</label>
                                    <input type="text" name="school_zipcode" id="school_zipcode" class="form-input 2xl:focus-within:bg-gray-100 rounded-md shadow-sm mt-1 block w-full"
                                           value="{{ old('school_zipcode', '') }}" />
                                    @error('school_zipcode')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="admin-detail">

                            <h2 class="p-6 display-1 uppercase text-black font-bold">School Admin Details</h2>

                            <div class="px-4 py-5 bg-white sm:p-6">
                                <label for="first_name" class="block font-medium text-sm text-gray-700">First name</label>
                                <input type="text" name="first_name" id="first_name" class="form-input rounded-md 2xl:focus-within:bg-gray-100 shadow-sm mt-1 block w-full"
                                       value="{{ old('first_name', '') }}" />
                                @error('first_name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <label for="middle_name" class="block font-medium text-sm text-gray-700">Middle name</label>
                                <input type="text" name="middle_name" id="middle_name" class="form-input rounded-md 2xl:focus-within:bg-gray-100 shadow-sm mt-1 block w-full"
                                       value="{{ old('middle_name', '') }}" />
                                @error('middle_name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <label for="last_name" class="block font-medium text-sm text-gray-700">Last name</label>
                                <input type="text" name="last_name" id="last_name" class="form-input rounded-md 2xl:focus-within:bg-gray-100 shadow-sm mt-1 block w-full"
                                       value="{{ old('last_name', '') }}" />
                                @error('last_name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="form-input rounded-md 2xl:focus-within:bg-gray-100 shadow-sm mt-1 block w-full"
                                       value="{{ old('email', '') }}" />
                                @error('email')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <label for="phone_number" class="block font-medium text-sm text-gray-700">Phone number</label>
                                <input type="tel" name="phone_number" id="phone_number" class="form-input rounded-md 2xl:focus-within:bg-gray-100 shadow-sm mt-1 block w-full"
                                       value="{{ old('phone_number', '') }}" />
                                @error('phone_number')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="px-4 py-5 bg-white sm:p-6">
                                <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                                <input type="password" name="password" id="password" class="form-input 2xl:focus-within:bg-gray-100 rounded-md shadow-sm mt-1 block w-full" />
                                @error('password')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="/js/app.js"></script>

        <script>
            $('#school_country').on('change',function(){
                var countryId = $(this).val();
                let url = '{{route('country.states',':id')}}';
                var action = url.replace(':id',countryId);
                $.get(action, function (data) {
                    $('#school_state').empty().attr('disabled',false);
                    var dropdowncont = '<select  class=\"form-control select2-show-search border-bottom-0 w-100 select2-show-search\"  name="state_id" id="lga_id" data-style=\"select-with-transition\"  >';
                    var options = "<option disabled> Choose State </option>";
                    $.each(data, function(index,name){
                        //alert(name.id);
                        options+="<option value= "+name.id+" >" +name.name + "</option>";
                    });
                    dropdowncont+=options;
                    dropdowncont+="</select>";
                    $('#school_state').html(dropdowncont);
                });

            });

        </script>
    @endpush
</x-app-layout>

