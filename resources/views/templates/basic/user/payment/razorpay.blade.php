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
                        <form action="{{$data->url}}" method="{{$data->method}}">


                       <ul class="preview_list">
                            <li>
                                @lang('Please Pay') {{getAmount($deposit->amount)}} {{$deposit->method_currency}}
                            </li>
                            <li>
                                @lang('To Get') {{getAmount($deposit->exchange->send_amount)}}  {{$deposit->exchange->payment_to_getway->cur_sym}}
                            </li>
                        </ul>


                            <script src="{{$data->checkout_js}}"
                                    @foreach($data->val as $key=>$value)
                                    data-{{$key}}="{{$value}}"
                                @endforeach >

                            </script>

                            <input type="hidden" custom="{{$data->custom}}" name="hidden">

                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection


@push('script')
    <script>
        'use strict';
        $(document).ready(function () {
            $('input[type="submit"]').addClass("ml-4 mt-4 btn-custom2 text-center btn-lg");
        })
    </script>
@endpush
