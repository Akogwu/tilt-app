@extends('layouts.client')
@push('styles')
    <link rel="stylesheet" href="/dist/slick/slick/slick.css">
    <link rel="stylesheet" href="/dist/slick/slick/slick-theme.css">
@endpush
@section('content')
    <section class="section-header bg-soft bg-gray-50 text-dark">
        <div class="container mx-auto">
            <div class="row align-items-center flex flex-auto">
                <div class="col-12 d-md-none">
                    <h1 class="font-weight-bold text-green-800 mb-0 text-gray-500 uppercase">
                        Every learner can <span class="font-bold text-primary">excel</span>
                    </h1>
                </div>
                <div class="col-8 col-md-7 col-lg-6 order-lg-1">
                    <h1 class="text-4xl text-green-800 font-weight-bold d-none d-md-inline uppercase">
                        Every learner can <span class="font-bold text-primary">excel</span>
                    </h1>
                    <p class="lead text-gray-500 mt-4"><span class="font-bold">The Intentional Learning Testing Platform</span> is a unique technology that tests for and identifies the causes of learning difficulties and offers expert guidance to help learners improve in their learning outcomes in record time.<br
                            class="d-none d-lg-inline"><span class="font-bold text-primary">TILT</span> is designed based on learning psychology.</p>
                    <div class="mt-4 mt-lg-5 mb-5 mb-lg-0">
                        <a href="/test" class="btn btn-md btn-facebook btn-pill animate-up-2 mr-3">
                            <span class="btn-inner-text">
                                Take the test <i class="fas fa-arrow-right ml-2"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-4 col-md-5 col-lg-6 order-lg-2">
                    <img src="/images/students-banner.svg" class="img-fluid mb-lg-6 mb-0" alt="Banner illustration">
                </div>
            </div>
        </div>
    </section>
    <div class="section py-0">
        <div class="container">
            <div class="grid lg:grid-cols-3 gap-5 mt-n9">
                <div class="mb-5 d-flex">
                    <a class="card animate-up-3 rounded-t-2xl shadow-md border-soft" href="html/pages/our-mission.html">
                        <div class="px-5 bg-gray-100 border-t border-blue-500 rounded-t-md pt-4 pb-5">
                            <span class="badge badge-secondary badge-pill mb-2">Survey</span>
                            <h5 class="mb-3">Complete our Questionnaire</h5>
                            <p class="text-gray mb-0">Answer the questions on the TILT online testing platform.</p>
                        </div>
                        <div class="px-5">
                            <img src="/images/survey.svg" class="img-fluid img-center py-4" alt="Illustration">
                        </div>
                    </a>
                </div>
                <div class=" mb-5 d-flex">
                    <a class="card animate-up-3 rounded-t-2xl shadow-md border-soft" href="html/pages/our-mission.html">
                        <div class="px-5 bg-gray-100 border-t border-green-500 rounded-t-md  pt-4 pb-5">
                            <span class="badge badge-primary badge-pill mb-2">Result</span>
                            <h5 class="mb-3">Get the result of the test</h5>
                            <p class="text-gray mb-0">Download the result from the platform based on your answers.</p>
                        </div>
                        <div class="px-5">
                            <img src="/images/result.svg" class="img-fluid img-center py-4" alt="Illustration">
                        </div>
                    </a>
                </div>
                <div class=" mb-5 d-flex">
                    <a class="card animate-up-3 rounded-t-2xl   shadow-md border-soft" href="html/pages/our-mission.html">
                        <div class="px-5 bg-gray-100 border-t border-orange rounded-t-md pt-4 pb-3">
                            <span class="badge badge-tertiary badge-pill mb-2">Recommendations</span>
                            <h5 class="mb-3">Follow our expert Recommendations</h5>
                            <p class="text-gray mb-0">Start making adjustments based on the recommendations you find in the result.</p>
                        </div>
                        <div class="px-5">
                            <img src="/images/recommendations.svg" class="img-fluid img-center py-4" alt="Illustration">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="section section-md bg-soft">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center text-dark">
                    <h2 class="h1">See the Impact of  <span class="font-bold text-success">TILT</span></h2>
                    <p class="lead text-gray my-4"> <span class="font-bold text-tertiary">The TILT Platform</span> is empowering student and schools to determine the causes of academic failures and address them. See the numbers for yourself.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-lg py-0">
        <div class="container mt-n5 mt-md-n6">
            <div class="row">
                <div class="col-12">
                    <div class="card-group">

                        <div class="card border-left-md border-soft align-content-center">
                            <div class="card-body row justify-content-center">
                                <div class="text-right">
                                    <span class="icon-primary mr-3">
                                        <i class="fas fa-file-alt fa-4x"> </i>
                                    </span>
                                </div>
                                <div class="text-left">
                                    <h2 class="text-gray mb-0">
                                        <span class="counter display-3 mr-2">318</span>
                                    </h2>
                                    <span class="text-center text-muted mb-0">Test Completed</span>
                                </div>
                            </div>
                        </div>

                        <div class="card border-left-md border-soft align-content-center">
                            <div class="card-body row justify-content-center">
                                <div class="text-right">
                                    <span class="icon-primary mr-3">
                                        <i class="fas fa-school fa-4x"> </i>
                                    </span>
                                </div>
                                <div class="text-left">
                                    <h2 class="text-gray mb-0">
                                        <span class="counter display-3 mr-2">14</span>
                                    </h2>
                                    <span class="text-center text-muted mb-0">Schools Registered</span>
                                </div>
                            </div>
                        </div>

                        <div class="card border-left-md border-soft align-content-center">
                            <div class="card-body row justify-content-center">
                                <div class="text-right">
                                    <span class="icon-primary mr-3">
                                        <i class="fas fa-user-graduate fa-4x"> </i>
                                    </span>
                                </div>
                                <div class="text-left">
                                    <h2 class="text-gray mb-0">
                                        <span class="counter display-3 mr-2">127</span>
                                    </h2>
                                    <span class="text-center text-muted mb-0">Learners Tested</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section py-0" >
        <div class="container">
            <div class="row position-relative align-items-center no-gutters z-2">
                <div class="col">
                    <!-- Card -->
                    <div class="card rounded-none  py-2 px-3 py-lg-4 px-lg-5" style="background-color: #f9fbfc;">
                        <div class="card-body ">
                            <h2 class="uppercase text-center mb-0.5">Testimonials</h2>
                            <p class="text-center">Here are some testimonies from students, parents, teachers and partners on the impact of the <span class="font-bold text-green-600">TILT Platform.</span></p>

                            <div class="testimonial_cards">

                                <div class="mt-2 d-flex">
                                    <div class="bg-white rounded m-2.5 shadow-md px-2.5 lg:px-5 py-3.5">
                                        <div class="person-info">
                                            <h2 class="mb-0.5 sm:text-lg">Rosemary Kayode</h2>
                                            <h4 class="text-gray-600">Parent</h4>
                                        </div>
                                        <div class="testimonial">
                                            <p class="sm:text-sm md:text-base">
                                                TILT has helped my child focus on the most important aspects of his studies which has impacted us positive.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 d-flex">
                                    <div class="bg-white rounded m-2.5 shadow-md px-2.5 lg:px-5 py-3.5">
                                        <div class="person-info">
                                            <h2 class="mb-0.5 sm:text-lg">Innocent Danjuma</h2>
                                            <h4 class="text-gray-600">Teacher</h4>
                                        </div>
                                        <div class="testimonial">
                                            <p class="sm:text-sm md:text-base">
                                                Our students now have better understanding of their course works as we have better understood their academic needs through the TILT Platform.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 d-flex">
                                    <div class="bg-white rounded m-2.5 shadow-md px-2.5 lg:px-5 py-3.5">
                                        <div class="person-info">
                                            <h2 class="mb-0.5 sm:text-lg">Ibrahim Bala</h2>
                                            <h4 class="text-gray-600">Student</h4>
                                        </div>
                                        <div class="testimonial">
                                            <p class="sm:text-sm md:text-base">
                                                TILT has helped me have a better understanding of what my academic deficiencies are.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="/dist/slick/slick/slick.js"></script>
    <script>
        $('.testimonial_cards').slick({
            centerMode: true,
            centerPadding: '2rem',
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            arrows:true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: true,
                        centerMode: true,
                        centerPadding: '1.5rem',
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: true,
                        centerMode: true,
                        centerPadding: '1.5rem',
                        slidesToShow: 1
                    }
                }
            ]
        });

    </script>
@endpush
