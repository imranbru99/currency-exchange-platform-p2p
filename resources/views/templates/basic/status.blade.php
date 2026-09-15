@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="pm-page-head">
    <span class="pm-kicker">@lang('Transparency')</span>
    <h1>@lang('Platform status & reserves')</h1>
    <p>@lang('Live desk counters, available methods and recently settled orders. Rates and reserve update when the market desk changes them.')</p>
</div>

<div class="pm-stats">
    <div class="pm-card p-4">
        <span class="pm-muted">@lang('Completed')</span>
        <h2>{{ number_format($stats['completed']) }}</h2>
    </div>
    <div class="pm-card p-4">
        <span class="pm-muted">@lang('Pending')</span>
        <h2>{{ number_format($stats['pending']) }}</h2>
    </div>
    <div class="pm-card p-4">
        <span class="pm-muted">@lang('Settled today')</span>
        <h2>{{ number_format($stats['today']) }}</h2>
    </div>
    <div class="pm-card p-4">
        <span class="pm-muted">@lang('Members')</span>
        <h2>{{ number_format($stats['members']) }}</h2>
    </div>
    <div class="pm-card p-4">
        <span class="pm-muted">@lang('Refunded')</span>
        <h2>{{ number_format($stats['refunded']) }}</h2>
    </div>
    <div class="pm-card p-4">
        <span class="pm-muted">@lang('Live methods')</span>
        <h2>{{ number_format($stats['methods']) }}</h2>
    </div>
</div>

<div class="pm-card pm-table-card mt-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h3 class="mb-0">@lang('Proof of reserve')</h3>
        <a href="{{ route('rates') }}" class="btn btn--base">@lang('Full rate table')</a>
    </div>
    <div class="table-responsive">
        <table class="pm-table">
            <thead>
                <tr>
                    <th>@lang('Method')</th>
                    <th>@lang('Reserve')</th>
                    <th>@lang('Buy')</th>
                    <th>@lang('Sell')</th>
                    <th>@lang('Availability')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($currencies as $currency)
                    <tr>
                        <td>
                            <strong>{{ $currency->name }}</strong>
                            <span class="pm-muted">{{ $currency->cur_sym }}</span>
                        </td>
                        <td>{{ getAmount($currency->reserve) }} {{ $currency->cur_sym }}</td>
                        <td>{{ getAmount($currency->buy_at) }}</td>
                        <td>{{ getAmount($currency->sell_at) }}</td>
                        <td>
                            @if($currency->available_for_buy && $currency->available_for_sell)
                                <span class="pm-badge pm-badge-success">@lang('Buy & Sell')</span>
                            @elseif($currency->available_for_buy)
                                <span class="pm-badge pm-badge-info">@lang('Buy only')</span>
                            @else
                                <span class="pm-badge pm-badge-warn">@lang('Sell only')</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">@lang('No reserves published yet')</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pm-card mt-4">
    <h3 class="mb-3">@lang('Recently settled')</h3>
    <div class="table-responsive">
        <table class="pm-table">
            <thead>
                <tr>
                    <th>@lang('Exchange ID')</th>
                    <th>@lang('Pair')</th>
                    <th>@lang('Send')</th>
                    <th>@lang('Receive')</th>
                    <th>@lang('Time')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent as $exchange)
                    <tr>
                        <td>
                            <a href="{{ route('exchangeDetail', $exchange->exchange_id) }}">{{ $exchange->exchange_id }}</a>
                        </td>
                        <td>
                            {{ optional($exchange->payment_from_getway)->cur_sym }}
                            →
                            {{ optional($exchange->payment_to_getway)->cur_sym }}
                        </td>
                        <td>{{ getAmount($exchange->get_amount) }} {{ optional($exchange->payment_from_getway)->cur_sym }}</td>
                        <td>{{ getAmount($exchange->send_amount) }} {{ optional($exchange->payment_to_getway)->cur_sym }}</td>
                        <td>{{ $exchange->updated_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">@lang('No completed exchanges yet')</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
