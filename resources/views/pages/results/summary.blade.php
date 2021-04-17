@extends('layouts.client')

@section('content')
    <section class="section-header bg-soft pb-0 mb-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center flex flex-col align-items-center">
                    <img src="/images/result-celebration.svg" class="w-1/2 h-1/2"  alt="">
                    <h1 class="display-1 font-bold text-primary">Congratulations</h1>
                    <p class="lead">You completed the test. Let’s see the result.</p>
                </div>
            </div><!-- End row -->
        </div><!-- End container -->
    </section>
    <x-summary-result payment_status="$payment_status" user="$user" testResult="$testResult"/>
@endsection
