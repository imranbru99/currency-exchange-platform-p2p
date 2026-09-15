@php
    $currencys = App\Models\Currency::where('available_for_sell',1)->where('available_for_buy',1)->where('show_rate',1)->latest()->take(3)->get();
    $reserve = getContent('reserve.content',true);
@endphp
<section class="reserve-section padding-top padding-bottom">
    <div class="container">
        <div class="section-header">
           
            <h3 class="title">@lang($reserve->data_values->heading)</h3>
            <p>
                @lang($reserve->data_values->sub_heading)
            </p>
        </div>
        <div class="row justify-content-center mb-30-none" id="loadMore">
        @foreach($currencys as $currency)
            <div class="col-sm-6 col-lg-4">
                <div class="reserve_item">
                    <div class="reserve_header">
                        <h5 class="title">{{$currency->name}}</h5>
                    </div>
                    <div class="reserve_body">
                        <h6 class="subtitle">
                           
                            <span class="cl-theme">{{$currency->reserve}} {{$currency->cur_sym}}</span>
                        </h6>
                        <ul class="reserve_amounts">
                            <li>
                                <span class="name">@lang('Buy Rate') :</span>
                                <span class="rate">{{$currency->buy_at}} {{$general->cur_sym}}</span>
                            </li>
                            <li>
                                <span class="name">@lang('Sell Rate') :</span>
                                <span class="rate">{{$currency->sell_at}} {{$general->cur_sym}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    
        <div class="load-more text-center mt-4 mt-lg-5">
            <a href="javascript:void(0)" class="custom-button" data-text="{{$reserve->data_values->button_text}}" data-item="3">
                @php
                    $textArray = str_split($reserve->data_values->button_text)
                @endphp
                @foreach ( $textArray as $text)
                    <span>{{$text}}</span>
                @endforeach                 
            </a>
        </div>
    </div>
</section>


@push('script')
    <script>
        'use strict'
        $(function(){
            $('.custom-button').on('click',function(){
                var item = $(this).data('item');
                $.ajax({
                    method:'GET',
                    url:"{{route('load')}}",
                    data:{items:item},
                    success:function(response){
                       $('#loadMore').html(response);
                       
                    }
                })  
            })
        })
    </script>
@endpush