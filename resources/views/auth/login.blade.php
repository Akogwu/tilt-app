<x-guest-layout>

    <div class="authentication">
        <div class="navigation">
            <div class="logo">
                <a href="/">
                    <img src="/images/tilt-logo.svg" width="80" class="m-t-15">
                    <br><span class="small">Tilt.ng</span>
                </a>
            </div>


            <ul class="nav-items">
                <li data-list="1">
                    <a href="#" class="nav-link" data-link="1"  id="loginlink">
                        <i class="fa fa-fw fa-user"></i> <span>LOGIN</span>
                    </a>
                </li>
                <li data-list="3">
                    <a href="#" class="nav-link" data-link="3" id="resetlink">
                        <i class="fa fa-fw fa-refresh"></i> <span>RESET PASSWORD</span>
                    </a>
                </li>
                <li data-list="4"> <a href="#" class="nav-link" data-link="4"> <i class="fa fa-fw fa-question"></i> <span>NEED HELP?</span> </a> </li>
            </ul>
        </div>

        <div class="middle-color">
            <div class="content">
                <div class="text">
                    <h2></h2>
                    <div class="banner">
                    </div>
                </div>

                <div class="socials">
                    <p>
                        <a href="#"><i class="fa fa-fw fa-facebook-f"></i></a>&emsp;
                        <a href="#"><i class="fa fa-fw fa-twitter"></i></a>&emsp;
                        <a href="#"><i class="fa fa-fw fa-instagram"></i></a>
                    </p>
                </div>
            </div>
        </div>

        <div class="action-pane">
            <x-jet-validation-errors class="mb-4 table" />
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <div id="fh" class="loadingdiv localized">
                <div class="ld-outer">
                    <div class="ld-inner">
                        <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                        <br><br><p style="padding:20px"><em id="loadingmessage">Please wait. . .</em></p>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="content-changeable" id="content-1" data-content="1" style="display:none">
                    <p class="headliner m-b-20"><span class="highlighted">Login</span> to your Tilt account</p>

                    <form method="post" action="{{ route('login') }}" name="loginForm">
                        @csrf
                        <div>
                            <x-jet-label for="email" value="{{ __('Email') }}" />
                            <x-jet-input placeholder="Email Address" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="password" value="{{ __('Password') }}" />
                            <x-jet-input placeholder="Password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        </div>

                        <div class="block my-4">
                            <label for="remember_me" class="flex items-center remember-me">
                                <x-jet-checkbox id="remember_me" name="remember" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <x-jet-button>
                            {{ __('Login to your account') }}
                        </x-jet-button>
                    </form>
                    <p class="headliner m-t-20">Not Registered yet? <span class="highlighted"><a href="/register" >Register here</a></span></p>
                    <p class="headliner m-t-20">Forgot your password? <span class="highlighted"><a href="#" onClick="goReset();">Click here</a></span></p>
                </div>

                <div class="content-changeable" id="content-2" data-content="2">
                    <p class="headliner m-t-20">Already have an account?
                        <span class="highlighted">
                            <a href="#" id="login-btn">Sign In!</a>
                        </span>
                    </p>
                </div>

                <div class="content-changeable" id="content-3" data-content="3" style="display:none">
                    <p class="headliner m-b-20"><span class="highlighted">Reset your password</span> to gain access to your account just in case you have forgotten it</p>

                    <form method="post" action="/auth/">
                        <input type="text" name="email" placeholder="Email Address">
                        <button name="doResetPassword" type="submit">Reset your password</button>
                    </form>
                    <p class="headliner m-t-20">Know your password? <span class="highlighted">
                            <a href="#" class="login-btn" onClick="goLogin();">Sign In!</a></span>
                    </p>
                </div>

                <div class="content-changeable" id="content-4" data-content="4" style="display:none">
                    <p class="headliner">Send an email to <span class="highlighted"><a href="mailto:help@tilt.ng">help@tilt.ng</a></span></p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

        <script src="/js/app.js"></script>
        <script src="/js/jquery.matchHeight.js"></script>
        <script>
            document.getElementById('login-btn').onclick = function (e){
                e.preventDefault();
                $('.nav-items > li').removeClass('active');
                $('.nav-items > li[data-list="'+1+'"]').addClass('active');
                $('.content-changeable').hide();
                $('div[data-content="'+1+'"]').slideDown(500);
            }
            function goLogin(){
                $('#loginlink').click();
            }
            function goSignup(){ $('#signuplink').click(); }
            function goReset(){ $('#resetlink').click(); }

            var wWidth = $(window).width();
            if(wWidth > 899){
                $('.middle-color, .action-pane').matchHeight({target: $('.authentication')});
            }
            $('.nav-link').on('click', function(e){
                e.preventDefault();
                var num = $(this).data('link');
                $('.nav-items > li').removeClass('active');
                $('.nav-items > li[data-list="'+num+'"]').addClass('active');
                $('.content-changeable').hide();
                $('div[data-content="'+num+'"]').slideDown(500);
            });
        </script>
    @endpush
</x-guest-layout>
