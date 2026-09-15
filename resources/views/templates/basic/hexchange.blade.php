@php
$banner = getContent('banner.content', true);
@endphp
@extends($activeTemplate.'layouts.exchange')
@section('content')
<section class="container py-4">
    @include($activeTemplate.'partials.calculator', [
        'currencys_sell' => $currencys_sell,
        'currencys_buy' => $currencys_buy,
        'calculatorTitle' => __('Exchange desk'),
        'calculatorLead' => __('Live rates, reserve check and a fee-aware receive amount before you confirm.'),
    ])
    @include($activeTemplate.'partials.trust_strip')
</section>

<section class="container-fluid pb-4">
    <div class="pm-page-head">
        <span class="pm-kicker">@lang('Market')</span>
        <h2>@lang('Current buy and sell rates')</h2>
    </div>
    <div class="pm-card pm-table-card">
        <div class="table-responsive">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th>@lang('Currency')</th>
                        <th>@lang('Buy rate')</th>
                        <th>@lang('Minimum')</th>
                        <th>@lang('Sell rate')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($currencys->where('show_rate', 1)->take(15) as $currency)
                        <tr>
                            <td><strong>{{ $currency->name }}</strong> <span class="pm-muted">{{ $currency->cur_sym }}</span></td>
                            <td>{{ getAmount($currency->buy_at) }}</td>
                            <td>{{ getAmount($currency->min_exchange) }} {{ $currency->cur_sym }}</td>
                            <td>{{ getAmount($currency->sell_at) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">@lang('No rates available')</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="transaction-section padding-bottom container-fluid">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="pm-card">
                <h2 class="mb-3">@lang('Pending exchange')</h2>
                <div class="table-responsive">
                    <table class="pm-table">
                        <thead>
                            <tr>
                                <th>@lang('Ex. ID')</th>
                                <th>@lang('Send')</th>
                                <th>@lang('Receive')</th>
                                <th>@lang('Time')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pending_exchange->take(8) as $exchange)
                                <tr>
                                    <td>{{ __($exchange->exchange_id) }}</td>
                                    <td>{{ getAmount($exchange->get_amount) }} {{ optional($exchange->payment_from_getway)->cur_sym }}</td>
                                    <td>{{ getAmount($exchange->send_amount) }} {{ optional($exchange->payment_to_getway)->cur_sym }}</td>
                                    <td>{{ $exchange->created_at->format('d M, h:i A') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">@lang('No pending exchange')</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="pm-card">
                <h2 class="mb-3">@lang('Completed exchange')</h2>
                <div class="table-responsive">
                    <table class="pm-table">
                        <thead>
                            <tr>
                                <th>@lang('Ex. ID')</th>
                                <th>@lang('Send')</th>
                                <th>@lang('Receive')</th>
                                <th>@lang('Time')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($accpted_exchange->take(8) as $exchange)
                                <tr>
                                    <td>
                                        <a href="{{ route('exchangeDetail', $exchange->exchange_id) }}">{{ __($exchange->exchange_id) }}</a>
                                    </td>
                                    <td>{{ getAmount($exchange->get_amount) }} {{ optional($exchange->payment_from_getway)->cur_sym }}</td>
                                    <td>{{ getAmount($exchange->send_amount) }} {{ optional($exchange->payment_to_getway)->cur_sym }}</td>
                                    <td>{{ $exchange->created_at->format('d M, h:i A') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">@lang('No completed exchange')</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script src="{{ asset($activeTemplateTrue . 'js/homesection.js') }}"></script>
@endpush
