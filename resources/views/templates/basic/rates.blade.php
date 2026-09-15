@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="pm-page-head">
    <span class="pm-kicker">@lang('Transparency')</span>
    <h1>@lang('Live Rates & Fees')</h1>
    <p>@lang('Check buy/sell rates, limits, charges and current reserve before you place an order.')</p>
</div>

<div class="pm-card p-3 mb-3">
    <div class="pm-toolbar">
        <input type="search" class="form--control" data-rate-search placeholder="@lang('Search currency or symbol')" aria-label="@lang('Search rates')">
        <div class="pm-filter-pills" data-rate-filter>
            <button type="button" class="is-active" data-filter="all">@lang('All')</button>
            <button type="button" data-filter="both">@lang('Buy & Sell')</button>
            <button type="button" data-filter="buy">@lang('Buy only')</button>
            <button type="button" data-filter="sell">@lang('Sell only')</button>
        </div>
    </div>
</div>

<div class="pm-card pm-table-card">
    <div class="table-responsive">
        <table class="pm-table" data-rate-table>
            <thead>
                <tr>
                    <th>@lang('Currency')</th>
                    <th>@lang('Buy')</th>
                    <th>@lang('Sell')</th>
                    <th>@lang('Min / Max')</th>
                    <th>@lang('Fee')</th>
                    <th>@lang('Reserve')</th>
                    <th>@lang('Status')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($currencies as $currency)
                    @php
                        $avail = $currency->available_for_buy && $currency->available_for_sell ? 'both' : ($currency->available_for_buy ? 'buy' : 'sell');
                    @endphp
                    <tr data-rate-row data-filter="{{ $avail }}" data-search="{{ strtolower($currency->name.' '.$currency->cur_sym) }}">
                        <td>
                            <strong>{{ $currency->name }}</strong>
                            <span class="pm-muted">{{ $currency->cur_sym }}</span>
                        </td>
                        <td>{{ getAmount($currency->buy_at) }}</td>
                        <td>{{ getAmount($currency->sell_at) }}</td>
                        <td>{{ getAmount($currency->min_exchange) }} – {{ getAmount($currency->max_exchange) }} {{ $currency->cur_sym }}</td>
                        <td>{{ getAmount($currency->fixed_charge) }} + {{ getAmount($currency->percent_charge) }}%</td>
                        <td>{{ getAmount($currency->reserve) }} {{ $currency->cur_sym }}</td>
                        <td>
                            @if($avail === 'both')
                                <span class="pm-badge pm-badge-success">@lang('Buy & Sell')</span>
                            @elseif($avail === 'buy')
                                <span class="pm-badge pm-badge-info">@lang('Buy Only')</span>
                            @else
                                <span class="pm-badge pm-badge-warn">@lang('Sell Only')</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('tryexchange') }}" class="btn btn--base btn-sm">@lang('Exchange')</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">@lang('No currency rates available')</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
