<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Tilt') }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/tailwind.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/custom.css">
    <script src="https://kit.fontawesome.com/c8d84f105a.js" crossorigin="anonymous"></script>
    @stack('styles')
    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
    @livewireStyles
</head>
<body cc>

<header class="header-global">
    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light navbar-theme-primary headroom py-lg-2 px-lg-6">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img class="navbar-brand-dark" src="/images/tilt-logo-light.svg" alt="Tilt Logo">
                <img class="navbar-brand-light" src="/images/tilt-logo.svg" alt="Tilt Logo"></a>
            <div class="navbar-collapse collapse" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="/">
                                <img src="/images/tilt-logo.svg" alt="Tilt">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <a href="#navbar_global" role="button" class="fas fa-times" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation"></a>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav navbar-nav-hover m-auto">
                    <li class="nav-item">
                        <a href="/" class="nav-link">
                            <span class="nav-link-inner-text">Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/about" class="nav-link">
                            <span class="nav-link-inner-text">About</span>
                        </a>
                    </li>
                    {{--<li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-link-inner-text">Gallery</span>
                        </a>
                    </li>--}}

                    {{--<li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown" role="button">
                            <span class="nav-link-inner-text mr-1">Tilt Learn</span> <i class="fas fa-angle-down nav-link-arrow"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg">
                            <div class="col-auto px-0" data-dropdown-content>
                                <div class="list-group list-group-flush">
                                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-0 py-3 px-lg-4">
                                        <span class="icon icon-sm icon-secondary"><i class="fas fa-file-alt"></i></span>
                                        <div class="ml-4">
                                            <span class="text-dark d-block">E-Learning
                                                <span class="badge badge-sm badge-danger ml-2">new</span>
                                            </span>
                                            <span class="small">Enroll in our online courses to boost your academic performance</span>
                                        </div>
                                    </a>
                                    <a href="" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center p-0 py-3 px-lg-4">
                                        <span class="icon icon-sm icon-primary"><i class="fas fa-book"></i></span>
                                        <div class="ml-4">
                                            <span class="text-dark d-block">Books</span>
                                            <span class="small">Access Books to Boost Academic Performance</span>
                                        </div>
                                    </a>
                                    <a href="" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center p-0 py-3 px-lg-4">
                                        <span class="icon icon-sm icon-tertiary"><i class="fas fa-blog"></i></span>
                                        <div class="ml-4">
                                            <span class="text-dark d-block">Blog & Articles</span>
                                            <span class="small">Read our blog and articles</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>--}}
                    <li class="nav-item">
                        <a href="/contact" class="nav-link">
                            <span class="nav-link-inner-text">Contact us</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="d-none d-lg-flex">
                @if(auth()->check())
                    @php
                    $image = auth()->user()->image_url;
                      if ($image)
                        $imageUrl = asset($image);
                      else
                          $imageUrl = asset('images/profile.png');
                    @endphp
                    <div class="relative d-inline-flex">
                        <button class="block w-8 h-8 rounded-full overflow-hidden" id="profile-btn">
                            <img class="object-cover h-full w-full " src="{{$imageUrl}}" alt="" aria-hidden="true">
                        </button>
                        <div class="mt-2 w-48 bg-white rounded-lg py-2 shadow-md d-none profile-menu mt-50" id="profile-menu">
                            <a href="/profile" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 ">Profile</a>
                            <a href="/logout" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 ">Logout</a>
                        </div>
                    </div>
                @endif

                @guest()
                <a href="/login" role="button" class="btn btn-sm btn-tertiary btn-pill animate-up-2">
                    <i class="fas fa-user-alt mr-2"></i>Account
                </a>
                @endguest


                <a href="/test" role="button" class="btn btn-sm btn-pill btn-facebook animate-up-2 ml-3 d-inline-flex">
                    <i class="fas fa-book-reader mr-2"></i> Take Test
                </a>
            </div>
            <div class="d-flex d-lg-none align-items-center">
                <a href="/login" role="button" class="btn btn-sm btn-tertiary animate-up-2">
                    <i class="fas fa-user-alt mr-1"></i>Account
                </a>
                <a href="/test" role="button" class="btn btn-sm btn-facebook animate-up-2 ml-2">
                    <i class="fas fa-book-reader mr-1"></i>Take Test </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </nav>
</header>

<main>
    @yield('content')
</main>

<section class="section py-0">
    <div class="container">
        <div class="row position-relative align-items-center no-gutters z-2">
            <div class="col">
                <!-- Card -->
                <div class="card-group">
                    <div class="card border-left-md border-soft py-2 px-3 py-lg-4 px-lg-5">
                        <div class="card-body">
                            <h4>Follow us</h4>
                            <p class="lead mt-3 mb-4">We are more than happy to connect with you</p>
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a href="#" target="_blank" class="btn btn-link btn-facebook" rel="noopener nofollow" data-toggle="tooltip"
                                       data-placement="bottom" title="Like us on Facebook">
                                        <span class="icon icon-sm"><i class="fab fa-facebook"></i></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" target="_blank" class="btn btn-link btn-twitter" rel="noopener nofollow" data-toggle="tooltip"
                                       data-placement="bottom" title="Follow us on Twitter">
                                        <span class="icon icon-sm"><i class="fab fa-twitter"></i></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" target="_blank" class="btn btn-link btn-instagram" rel="noopener nofollow" data-toggle="tooltip"
                                       data-placement="bottom" title="Like us on Instagram">
                                        <span class="icon icon-sm"><i class="fab fa-instagram"></i></span>
                                    </a>
                                </li>
                            </ul><!-- End Social Networks -->
                        </div>
                    </div>
                    <div class="card border-left-md border-soft py-2 px-3 py-lg-4 px-lg-5">
                        <div class="card-body">
                            <h4>Join The Learning Revolution</h4>

                            <a href="/test" class="btn btn-md btn-primary btn-pill animate-up-2 mr-3"><i class="fas fa-book-reader mr-1"></i> Take Test</a>
                            @guest()
                            <a href="/login" class="btn btn-md btn-tertiary btn-pill animate-up-2 mr-3"><i class="fas fa-user mr-1"></i> Account</a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Footer -->
<footer class="footer pt-10 pt-lg-11 pb-4 bg-soft text-dark mt-n9">
    <div class="container">
        <div class="row">
            <div class="col text-center justify-content-center d-flex flex-column">
                <a class="footer-brand align-self-center" href="#">
                    <img src="/images/tilt-logo.svg" class="align-self-center" alt="Tilt">
                </a>
                <h6 class="text-primary pt-4 pb-2">The Intentional Learning Testing Platform.</h6><!-- List -->
                <ul class="list-inline list-group-flush list-group-borderless mb-0">
                    <li class="list-inline-item px-0 px-sm-2">
                        <a href="#" target="_blank" class="text-gray">Tilt</a></li>
                    <li class="list-inline-item px-0 px-sm-2">
                        <a href="/about"  class="text-gray">About Us</a></li>
                    <li class="list-inline-item px-0 px-sm-2">
                        <a href="#" target="_blank" class="text-gray">Documentation</a></li>
                </ul><!-- End List -->
            </div>
        </div>
        <hr class="mb-5">
        <div class="row">
            <div class="col mb-4 mb-md-0">
                <div class="d-flex text-center justify-content-center align-items-center">
                    <p class="small text-gray mb-0">©<a href="#" >Tilt</a> <span class="current-year"></span>. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer><!-- End of Footer -->

@livewireScripts
<script src="/js/app.js"></script>
<script src="/js/script.js"></script>
@stack('scripts')

</body>
</html>


