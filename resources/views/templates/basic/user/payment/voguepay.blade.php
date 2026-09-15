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

                        <img src="{{$deposit->gateway_currency()->methodImage()}}" class="card-img-top" alt=".."
                             class="w-100">
                    </div>
                    <div class="col-md-8 text-center">
                         <ul class="preview_list">
                            <li>
                                @lang('Please Pay') {{getAmount($deposit->final_amo)}} {{$deposit->method_currency}}
                            </li>
                            <li>
                                @lang('To Get') {{getAmount($deposit->exchange->send_amount)}}  {{$deposit->exchange->payment_to_getway->cur_sym}}
                            </li>
                        </ul>
                       
                        <button type="button"
                                class=" mt-4 bg_theme text-white btn-round text-center"
                                id="btn-confirm">@lang('Pay Now')</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection



@push('script')

    <script src="//voguepay.com/js/voguepay.js"></script>
    <script>
        'use strict';

        var closedFunction = function() {
        }
        var successFunction = function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}';
        }
        var failedFunction=function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}' ;
        }

        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo:"{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '5af93ca2913fd',
                store_id:"{{ $data->store_id }}",
                custom: "{{ $data->custom }}",

                closed:closedFunction,
                success:successFunction,
                failed:failedFunction
            });
        }

        $(document).ready(function () {
            $(document).on('click', '#btn-confirm', function (e) {
                e.preventDefault();
                pay('Buy', {{ $data->Buy }});
            });
        });
    </script>
@endpush
