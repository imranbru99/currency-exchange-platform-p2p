@extends($activeTemplate.'layouts.master')

@section('content')

    <div class="container padding-top padding-bottom">
        <div class="card section-bg">
            <div class="card-header">
                <h5 class="title m-0 text-center text-white">@lang('Payment Preview')</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top" alt=".." class="w-100">
                    </div>
                    <div class="col-md-8">
                        <ul class="preview_list">
                            <li>
                                @lang('Please Pay') {{getAmount($deposit->amount)}} {{$deposit->method_currency}}
                            </li>
                            <li>
                                @lang('To Get') {{getAmount($deposit->exchange->send_amount)}}  {{$deposit->exchange->payment_to_getway->cur_sym}}
                            </li>
                        </ul>
                        <button type="button" class="btn bg_theme text-white mt-4" id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
                        <script
                            src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                        <script>
                            
                            var btn = document.querySelector("#btn-confirm");
                            btn.setAttribute("type", "button");
                            const API_publicKey = "{{$data->API_publicKey}}";

                            function payWithRave() {
                                var x = getpaidSetup({
                                    PBFPubKey: API_publicKey,
                                    customer_email: "{{$data->customer_email}}",
                                    amount: "{{$data->amount }}",
                                    customer_phone: "{{$data->customer_phone}}",
                                    currency: "{{$data->currency}}",
                                    txref: "{{$data->txref}}",
                                    onclose: function () {
                                    },
                                    callback: function (response) {
                                        var txref = response.tx.txRef;
                                        var status = response.tx.status;
                                        var chargeResponse = response.tx.chargeResponseCode;
                                        if (chargeResponse == "00" || chargeResponse == "0") {
                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                        } else {
                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                        }
                                        // x.close(); // use this to close the modal immediately after payment.
                                    }
                                });
                            }
                        </script>


                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@push('script')

@endpush
