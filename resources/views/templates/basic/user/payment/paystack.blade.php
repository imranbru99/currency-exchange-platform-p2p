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
                         <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                             <ul class="preview_list">
                                <li>
                                    @lang('Please Pay') {{getAmount($deposit->amount)}} {{$deposit->method_currency}}
                                </li>
                                <li>
                                    @lang('To Get') {{getAmount($deposit->exchange->send_amount)}}  {{$deposit->exchange->payment_to_getway->cur_sym}}
                                </li>
                            </ul>

                            <button type="button" class=" btn bg_theme text-white mt-4" id="btn-confirm">@lang('Pay Now')</button>

                            <script
                                src="//js.paystack.co/v1/inline.js"
                                data-key="{{ $data->key }}"
                                data-email="{{ $data->email }}"
                                data-amount="{{$data->amount}}"
                                data-currency="{{$data->currency}}"
                                data-ref="{{ $data->ref }}"
                                data-custom-button="btn-confirm"
                            >
                            </script>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection


