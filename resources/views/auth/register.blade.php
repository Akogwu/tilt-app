<x-guest-layout>

    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />
        <div class="register-authentication">
                <div class="flex flex-col md:flex-row justify-between" x-data="{tab:'personal'}">

                <div class="nav flex flex-row md:flex-col md:pr-3">
                    <div class="logo">
                        <a href="">
                            <img src="/images/tilt-logo.svg" class="sm:w-24 sm:h-auto" alt="">
                            <span class="text-gray-300 text-sm">Create a Tilt Account</span>
                        </a>
                    </div>
                    <ul class="nav-items text-center py-3.5 flex flex-row md:flex-col justify-between">
                        <li class="py-2.5">
                            <a href="#" @click.prevent="tab = 'personal'" class="text-gray-400">
                                <i class="fas fa-2x fa-user "></i><br> Personal Account
                            </a>
                        </li>
                        <li class="py-2.5">
                            <a href="#" @click.prevent="tab = 'school'" class="text-gray-400 ">
                                <i class="fas fa-2x fa-school"></i><br> School Account
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="form w-full md:w-9/12">
                    <div x-show="tab === 'personal'">
                        <h4 class="font-bold text-gray-600 uppercase py-3">Create Personal Account</h4>
                        <form method="POST" action="{{ route('register') }}" >
                            @csrf
                            <input type="hidden" name="role_id" value="PRIVATE_LEARNER">
                            <div class="grid grid-cols-2 gap-3.5">
                                <div>
                                    <x-jet-label for="firstname" value="{{ __('First Name') }}" />
                                    <x-jet-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
                                </div>
                                <div>
                                    <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
                                    <x-jet-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
                                </div>

                                <div>
                                    <x-jet-label for="gender" value="{{ __('Select Gender') }}" />
                                    <select name="gender" id="gender" class="block mt-1 w-full border-gray-200" required>
                                        <option value="">Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div>
                                    <x-jet-label for="age" value="{{ __('Age') }}" />
                                    <select name="age" id="age" class="block mt-1 w-full border-gray-200" required>
                                        <option value="">Select Age Range</option>
                                        <option value="5-12">5 - 12 yrs</option>
                                        <option value="12-20">12 - 20 yrs</option>
                                        <option value="20-35">20 - 35 yrs</option>
                                        <option value="35-55">35 - 55 yrs</option>
                                    </select>
                                </div>

                                <div class="">
                                    <x-jet-label for="email" value="{{ __('Email') }}" />
                                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                </div>
                                <div class="">
                                    <x-jet-label for="phone" value="{{ __('Phone') }}" />
                                    <x-jet-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required />
                                </div>

                                <div class="">
                                    <x-jet-label for="password" value="{{ __('Password') }}" />
                                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                </div>

                                <div class="">
                                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                    <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                                </div>

                                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                    <div class="mt-4">
                                        <x-jet-label for="terms">
                                            <div class="flex items-center">
                                                <x-jet-checkbox name="terms" id="terms"/>

                                                <div class="ml-2">
                                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </x-jet-label>
                                    </div>
                                @endif

                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a>

                                <x-jet-button class="ml-4">
                                    {{ __('Register') }}
                                </x-jet-button>
                            </div>
                            <input type="hidden" name="session_id" id="session_id" value="">
                        </form>
                    </div>

                    <div x-show="tab === 'school'">
                        <h4 class="font-bold text-gray-600 uppercase py-3">Create an Account as School Admin</h4>
                        <form method="POST" action="{{ route('register') }}" >
                            @csrf
                            <input type="hidden" name="role_id" value="SCHOOL_ADMIN">
                            <div class="grid grid-cols-2 gap-3.5">
                                <div>
                                    <x-jet-label for="firstname" value="{{ __('First Name') }}" />
                                    <x-jet-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
                                </div>
                                <div>
                                    <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
                                    <x-jet-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
                                </div>

                                <div class="">
                                    <x-jet-label for="email" value="{{ __('School Email Address') }}" />
                                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                </div>
                                <div class="">
                                    <x-jet-label  value="{{ __('School Name') }}" />
                                    <x-jet-input  class="block mt-1 w-full" type="text" name="school_name" :value="old('school_name')" required />
                                </div>
                                <div class="">
                                    <x-jet-label  value="{{ __('Phone Number') }}" />
                                    <x-jet-input  class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required />
                                </div>

                                <div class="">
                                    <x-jet-label  value="{{ __('School Address') }}" />
                                    <x-jet-input  class="block mt-1 w-full" type="text" name="address" required autocomplete="address" />
                                </div>

                                <div class="">
                                    <x-jet-label for="password" value="{{ __('Password') }}" />
                                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                </div>

                                <div class="">
                                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                    <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                                </div>

                                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                    <div class="mt-4">
                                        <x-jet-label for="terms">
                                            <div class="flex items-center">
                                                <x-jet-checkbox name="terms" id="terms"/>

                                                <div class="ml-2">
                                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </x-jet-label>
                                    </div>
                                @endif

                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a>

                                <x-jet-button class="ml-4">
                                    {{ __('Register') }}
                                </x-jet-button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        

    </x-jet-authentication-card>
    @push('scripts')
        <script>
            let sessionId;

            sessionId = window.localStorage.getItem('session_id');
            if (sessionId !=null){

                document.getElementById('session_id').setAttribute('value', sessionId);
            }

        </script>
    @endpush
</x-guest-layout>


