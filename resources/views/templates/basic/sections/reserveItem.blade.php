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