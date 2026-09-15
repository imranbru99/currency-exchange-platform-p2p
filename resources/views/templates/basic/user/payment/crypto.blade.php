@extends($activeTemplate.'layouts.master')


@section('content')
<div class="deposit-section padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-deposit text-center section-bg">
                    <div class="card-header card-header-bg">
                        <h3 class="text-white text-center">@lang('Payment Preview')</h3>
                    </div>
                    <div class="card-body card-body-deposit text-center section-bg">
                        <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{$data->currency}}</h4>
                        <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
                        <img src="{{$data->img}}" alt="..">
                        <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
