@extends($activeTemplate.'layouts.master')

@push('style')
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .card button {
            padding-left: 0px !important;
        }
    </style>
@endpush

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
                         <form action="{{$data->url}}" method="{{$data->method}}">
                        <ul class="preview_list">
                            <li>
                                @lang('Please Pay') {{getAmount($deposit->amount)}} {{$deposit->method_currency}}
                            </li>
                            <li>
                                @lang('To Get') {{getAmount($deposit->exchange->send_amount)}}  {{$deposit->exchange->payment_to_getway->cur_sym}}
                            </li>
                        </ul>
                        <script
                                src="{{$data->src}}"
                                class="stripe-button"
                                @foreach($data->val as $key=> $value)
                                data-{{$key}}="{{$value}}"
                                @endforeach
                            >
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('style')
<style>
    .stripe-button-el{
        background: #{{ $general->base_color }} !important;
    }
    .stripe-button-el span{
        background: #{{ $general->base_color }} !important;
        box-shadow: none !important;
    }
</style>
@endpush