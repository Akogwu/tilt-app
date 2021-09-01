@extends('layouts.client')

@section('content')
    <section class="section bg-gray-200 overlay-gray-100 " data-background="">
        <div class="container">
            <div class="row justify-content-center pt-5">
                <div class="col-8">
                    <img src="{{asset('images/tilt-test-result.png')}}" width="200" class="image" alt="Tilt Test Result" style="float: right">
                </div>
                <div class="col-4">
                    <h4>Transaction Summary</h4>
                    <table>
                        <tr>
                            <td>Payment Description</td>
                            <td>{{$data['description']}}</td>
                        </tr>
                        <tr>
                            <td>Reference Number</td>
                            <td>{{$data['reference_num']}}</td>
                        </tr>
                        <tr>
                            <td>Sub total</td>
                            <td>{{$data['amount']}}</td>
                        </tr>
                        <tr>
                            <td>Quantity</td>
                            <td>{{$data['quantity']}}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td> </td>
                        </tr>

                    </table>
                    <form id="paymentForm">
                        <input type="hidden" id="email-address" value="{{$user->email}}" />

                        <input type="hidden" id="amount" value="{{$data['amount']}}" />

                        <div class="form-submit mt-4">
                            <button type="submit" class="btn btn-success" id="checkout" onclick="payWithPaystack()"> Checkout </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        const paymentForm = document.getElementById('paymentForm');
        paymentForm.addEventListener("submit", payWithPaystack, false);
        function payWithPaystack(e) {
            e.preventDefault();
            document.getElementById("checkout").disabled = true;

            let handler = PaystackPop.setup({
                key: '{{env('PAYSTACK_PUBLIC_KEY')}}', // Replace with your public key
                email: document.getElementById("email-address").value,
                amount: document.getElementById("amount").value * 100,
                ref: '{{$data['reference_num']}}', // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                // label: "Optional string that replaces customer email"
                firstname: '{{$data['first_name']}}',
                lastname: '{{$data['last_name']}}',
                // label: "Optional string that replaces customer email"
                metadata: {
                    custom_fields: [
                        {
                            display_name: "Mobile Number",
                            variable_name: "payment_type",
                            value: "{{$data['payment_type']}}"
                        },
                        {
                            display_name: "Payment For",
                            variable_name: "payment_for",
                            value: "{{$data['payment_for']}}"
                        },
                        {
                            display_name: "User Id",
                            variable_name: "user_id",
                            value: "{{$data['user_id']}}"
                        },
                        {
                            display_name: "Quantity",
                            variable_name: "quantity",
                            value: "{{$data['quantity']}}"
                        }
                    ]
                },
                callback: function(response){
                    console.log(response)
                    if (response.status =='success'){
                        alert('Payment Successful')
                        setTimeout(function (){
                            //window.location = '{{route('result.getResult',$data['payment_for'])}}';
                            window.location = '/transactions/confirm?ref='+response.reference+'&trans='+response.trans
                        }, 1500)

                    }

                },
                onClose: function(){

                    alert('Action aborted');
                },
            });
            handler.openIframe();
        }
    </script>
@endpush
