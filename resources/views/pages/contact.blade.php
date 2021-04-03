@extends('layouts.client')
@section('content')
    <section class="section" id="sub-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="uppercase">Contact us</h1>
                    <p class="lead">If you have any enquiry, suggestion or just want to say hi, please contact us and we will be in touch as soon as possible.  </p>
                </div>
            </div><!-- End row -->
        </div><!-- End container -->
        <div class="divider_top"></div>
    </section>

    <section class="section" style="background: url('/images/dots.svg') repeat center/auto;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="shadow-lg p-4 sm:px-2 bg-white w-full rounded">
                        @livewire('contact')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

