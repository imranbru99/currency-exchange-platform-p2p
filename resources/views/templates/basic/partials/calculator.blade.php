@php
    $currencys_sell = $currencys_sell ?? \App\Models\Currency::where('available_for_sell', 1)->latest()->get();
    $currencys_buy = $currencys_buy ?? \App\Models\Currency::where('available_for_buy', 1)->latest()->get();
    $calculatorTitle = $calculatorTitle ?? __('Buy & sell digital currency with guaranteed settlement');
    $calculatorLead = $calculatorLead ?? __('Select a send method, enter the amount, and confirm instantly.');
@endphp
<div class="pm-hero bgImgCenter">
    <div class="pm-page-head text-center mb-4">
        <span class="pm-kicker">@lang('Reserve-backed exchange')</span>
        <h2 class="text-white">{{ $calculatorTitle }}</h2>
        <p class="text-white-50">{{ $calculatorLead }}</p>
    </div>
    <div class="currency-converter pm-converter" data-pm-calculator>
        <div class="pm-converter-pills">
            <span><i class="las la-shield-alt"></i> @lang('Reserve checked')</span>
            <span><i class="las la-bolt"></i> @lang('Live quote')</span>
            <span><i class="las la-lock"></i> @lang('Official website only')</span>
        </div>
        <form class="exchange-form" method="POST" action="{{ route('user.exchange') }}">
            @csrf
            <div class="form-group">
                <label for="send"><strong>@lang('You send')</strong></label>
                <div class="pm-field-row">
                    <input type="text" name="send_amount" id="send_val" placeholder="@lang('Enter the amount')" required
                        inputmode="decimal" autocomplete="off"
                        onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                    <select class="select-bar" name="send" id="send">
                        <option value="">@lang('Select currency')</option>
                        @foreach ($currencys_sell as $currency)
                            <option value="{{ $currency->id }}"
                                data-min_max="{{ filterCollection($currency,'rate','sell_at','buy_at','fixed_charge','percent_charge','reserve','min_exchange','max_exchange','cur_sym','payment_type_sell') }}">
                                {{ $currency->name }} {{ $currency->cur_sym }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="pm-quick-amounts" data-quick-amounts>
                    <button type="button" data-amount="100">100</button>
                    <button type="button" data-amount="500">500</button>
                    <button type="button" data-amount="1000">1,000</button>
                    <button type="button" data-amount="5000">5,000</button>
                    <button type="button" data-amount="max">@lang('Max')</button>
                </div>
            </div>
            <div class="pm-swap-wrap">
                <button type="button" class="pm-swap-btn" data-swap-pair aria-label="@lang('Swap currencies')">
                    <i class="las la-exchange-alt"></i>
                </button>
            </div>
            <div class="form-group receiveData">
                <label for="receive"><strong>@lang('You receive')</strong></label>
                <div class="pm-field-row">
                    <input type="text" name="receive_amount" id="receive_val" min="0"
                        placeholder="@lang('You will get')" readonly>
                    <select class="select-bar" name="receive" id="receive">
                        <option value="" class="wrap">@lang('Select currency')</option>
                        @foreach ($currencys_buy as $currency)
                            <option value="{{ $currency->id }}"
                                data-min_max="{{ filterCollection($currency,'cur_sym','rate','sell_at','buy_at','fixed_charge','percent_charge','reserve','min_exchange','max_exchange','payment_type_sell') }}">
                                {{ $currency->name }} {{ $currency->cur_sym }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="pm-quote" data-quote-panel>
                <div>
                    <span>@lang('Rate')</span>
                    <strong data-quote-rate>—</strong>
                </div>
                <div>
                    <span>@lang('Fee')</span>
                    <strong data-quote-fee>—</strong>
                </div>
                <div>
                    <span>@lang('Limit')</span>
                    <strong data-quote-limit>—</strong>
                </div>
                <div>
                    <span>@lang('Reserve')</span>
                    <strong data-quote-reserve>—</strong>
                </div>
            </div>
            <p class="pm-quote-hint" data-quote-hint>@lang('Choose both currencies and enter an amount to see a live quote.')</p>
            <div class="form-group submit">
                <input type="submit" value="@lang('Continue exchange')">
            </div>
        </form>
    </div>
</div>
