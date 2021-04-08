@extends('layouts.client')

@section('content')

    <section class="section pb-0 bg-soft bg-gray-50 text-dark">
        <div class="container pb-5">
            <div class="row align-items-center flex flex-auto">

                <div class="col-8 col-md-7 col-lg-6 order-lg-2">
                    <h1 class="text-4xl text-green-800 font-weight-bold d-none d-md-inline uppercase">
                        <span class="font-bold">Welcome To The Test</span>
                    </h1>
                    <p class="lead text-gray-500 mt-4">
                        Together we will find the cause of each learning deficiency
                    </p>
                    <h2 class="md:text-base mb-0 text-orange">Patiently answer every question honestly.</h2>
                    <p>Ask your teacher or guardian to explain any question you do not clearly understand</p>
                    <div class="mt-4 mt-lg-5 mb-5 mb-lg-0">
                        <a href="#" class="btn btn-md btn-facebook btn-pill animate-up-2 mr-3">
                            <span class="btn-inner-text">
                                Begin the test <i class="fas fa-arrow-right ml-2"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-4 col-md-5 col-lg-6 order-lg-1">
                    <img src="/images/student.svg" class="img-fluid mb-lg-6 mb-0" alt="Banner illustration">
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="font-semibold text-center text-gray-600 mb-0">How the test works!</h2>
            <p class="font-medium text-gray-800 text-center">The following are the various stages of our assessment</p>
            <div class="flex flex-wrap -mx-4 pt-4 pb-3">

                <div class="mt-2 w-full px-4 lg:w-1/2 xl:w-1/3">
                    <div class="flex items-center rounded-lg bg-white shadow-lg overflow-hidden transition duration-500 ease-in-out transform hover:-translate-y-1 ">
                        <img class="h-32 w-32 flex-shrink-0 img-fluid" src="/images/survey.svg" alt="">

                        <div class="px-2 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-0">Complete our Questionnaire.</h3>
                            <p class="text-gray-600">Answer the questions on the TILT online testing platform.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-2 w-full px-4 lg:w-1/2 xl:w-1/3">
                    <div class="flex items-center rounded-lg bg-white shadow-lg overflow-hidden transition duration-500 ease-in-out transform hover:-translate-y-1">
                        <img class="h-32 w-32 flex-shrink-0 img-fluid" src="/images/result.svg" alt="">

                        <div class="px-2 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-0">Get the result of the test</h3>
                            <p class="text-gray-600">Download the result from the platform based on your answers.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-2 w-full px-4 lg:w-1/2 xl:w-1/3">
                    <div class="flex items-center rounded-lg bg-white shadow-lg overflow-hidden transition duration-500 ease-in-out transform hover:-translate-y-1">
                        <img class="h-32 w-32 flex-shrink-0" src="/images/recommendations.svg" alt="">
                        <div class="px-2 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-0">Follow our expert Recommendations</h3>
                            <p class="text-gray-600">Start making adjustments based on the recommendations you find in the result.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 mt-lg-5 mb-5 mb-lg-0 text-center">
                <a href="#" class="btn btn-md btn-facebook btn-pill animate-up-2 mr-3">
                    <span class="btn-inner-text">
                        Begin the test <i class="fas fa-arrow-right ml-2"></i>
                    </span>
                </a>
            </div>
        </div>
    </section>
@endsection
