@extends('layouts.client')

@section('content')
    <section class="section bg-gray-200 overlay-gray-100 " data-background="">
        <div class="container">
            <div class="row justify-content-center pt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="mt-4">
                            @if($data['success'])
                            <div class="text-center" style="font-size: 24px; color: #277A5A">
                                <i class="fa fa-check-circle fa-5x success"></i>
                            </div>
                            <div class="text-center mt-4">
                                <h3>Payment Successful</h3>
                                <p>
                                    We've sent you an email with all the details of your transaction.
                                </p>
                                <h4>Reference Number: {{$data['ref']}}</h4>
                                <p>
                                    Thank you for your patronage
                                </p>
                                <p>
                                    <a href="{{$data['link']}}" target="_blank">{{$data['text']}}</a>
                                </p>
                            </div>
                            @else
                                <div class="text-center" style="font-size: 24px; color: #FA5252">
                                    <i class="fa fa-times-circle fa-5x"></i>
                                </div>
                                <div class="text-center mt-4">
                                    <h3>Unknown transaction</h3>
                                    <p>
                                        This transaction is not valid.
                                    </p>

                                    <p>
                                        Please contact support.
                                    </p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@push('scripts')

@endpush
