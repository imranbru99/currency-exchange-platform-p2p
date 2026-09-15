@extends($activeTemplate.'layouts.master')

@section('content')
  
    <!-- Preview Section -->
    <section class="preview-section padding-top padding-bottom">
        <div class="container">
            <div class="item-rounded primary-bg item-padding">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 col-lg-4 col-xl-5">
                        <div class="deposit-item active mb-lg-0 primary-bg-2">
                            <div class="deposit-thumb">
                                <img src="{{ $data->gateway_currency()->methodImage() }}" alt="deposit">
                                
                            </div>
                            <div class="deposit-content">
                                <h5 class="title">{{ __($data->gateway_currency()->name) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-7">
                        <div class="preview-header">
                            <h5 class="title">@lang('Preview')</h5>
                        </div>
                        <ul class="preview-lists mb-30">
                            <li>
                                <span class="title">@lang('Amount')</span>
                                <span class="details text-info">{{ getAmount($data->amount) }} {{ $data->gateway_currency()->currency }}</span>
                            </li>
                            <li>
                                <span class="title">@lang('Charge')</span>
                                <span class="details text-danger">{{ getAmount($data->charge) }} {{ $data->gateway_currency()->currency }}</span>
                            </li>
                            <li>
                                <span class="title">@lang('Payable')</span>
                                <span class="details text-success">{{ getAmount($data->amount + $data->charge) }}
                                {{ $data->gateway_currency()->currency }}</span>
                            </li>
                            <li>
                                <span class="title">@lang('Conversion Rate')</span>
                                <span class="details">1 {{ $data->gateway_currency()->currency }} = {{ number_format(getAmount(1  /  $data->gateway_currency()->rate),2) }}
                                    {{ $general->cur_text }}</span>
                            </li>
                            <li>
                                <span class="title">@lang('Payable in') {{ $data->gateway_currency()->currency }}</span>
                                <span class="details text-success">{{ getAmount($data->final_amo) }} {{ $data->gateway_currency()->currency }}</span>
                            </li>


                            <li>
                                <span class="title">@lang('You Get In') {{$general->cur_text}}</span>
                                <span class="details text-success">{{ number_format(getAmount($data->amount  /  $data->gateway_currency()->rate),2) }} {{ $general->cur_text }}</span>
                            </li>

                             @if ($data->gateway->crypto == 1)
                                <p class="list-group-item">
                                    @lang('Conversion with')
                                    <b> {{ $data->method_currency }}</b> @lang('and final value will Show on next step')
                                </p>
                            @endif
                        </ul>
                        <div class="text-center mt-30">
                            @if (1000 > $data->method_code)
                                <a href="{{ route('user.deposit.confirm') }}"
                                    class="btn btn-success btn-block py-3 font-weight-bold">@lang('Pay Now')</a>
                            @else
                                <a href="{{ route('user.deposit.manual.confirm') }}"
                                    class="btn btn-success btn-block py-3 font-weight-bold">@lang('Pay Now')</a>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Preview Section -->
    
@stop
