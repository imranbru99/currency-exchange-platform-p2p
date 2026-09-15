@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="pm-page-head">
    <span class="pm-kicker">@lang('Order status')</span>
    <h1>@lang('Track Exchange')</h1>
    <p>@lang('Enter your exchange ID to see the current status of your order. No login required.')</p>
</div>

<div class="pm-card pm-track-card">
    <form method="GET" action="{{ route('track.exchange') }}" class="pm-track-form">
        <input type="text" name="exchange_id" value="{{ request('exchange_id') }}" class="form--control" placeholder="@lang('Enter Exchange ID')" required>
        <button type="submit" class="btn btn--gradient">@lang('Track Now')</button>
    </form>
</div>

@if($searched)
    @if($exchange)
        <div class="pm-card mt-4" data-print-area>
            <div class="pm-track-result">
                <div>
                    <span class="pm-muted">@lang('Exchange ID')</span>
                    <h3>
                        <span data-copy-value>{{ $exchange->exchange_id }}</span>
                        <button type="button" class="pm-icon-btn" data-copy title="@lang('Copy ID')"><i class="las la-copy"></i></button>
                    </h3>
                </div>
                <div>
                    @if($exchange->status == 0)
                        <span class="pm-badge pm-badge-warn">@lang('Pending')</span>
                    @elseif($exchange->status == 1)
                        <span class="pm-badge pm-badge-success">@lang('Completed')</span>
                    @elseif($exchange->status == 2)
                        <span class="pm-badge pm-badge-danger">@lang('Cancelled')</span>
                    @else
                        <span class="pm-badge pm-badge-info">@lang('Refunded')</span>
                    @endif
                </div>
            </div>
            <div class="pm-track-grid">
                <div>
                    <span>@lang('Send')</span>
                    <strong>{{ getAmount($exchange->get_amount) }} {{ optional($exchange->payment_from_getway)->cur_sym }}</strong>
                    <small>{{ optional($exchange->payment_from_getway)->name }}</small>
                </div>
                <div>
                    <span>@lang('Receive')</span>
                    <strong>{{ getAmount($exchange->send_amount) }} {{ optional($exchange->payment_to_getway)->cur_sym }}</strong>
                    <small>{{ optional($exchange->payment_to_getway)->name }}</small>
                </div>
                <div>
                    <span>@lang('Created')</span>
                    <strong>{{ $exchange->created_at->format('d M Y, h:i A') }}</strong>
                </div>
            </div>
            <div class="pm-action-row mt-3">
                <a href="{{ route('exchangeDetail', $exchange->exchange_id) }}" class="btn btn--base">@lang('View Full Details')</a>
                <button type="button" class="btn btn--gradient" data-print>@lang('Print receipt')</button>
            </div>
        </div>
    @else
        <div class="pm-card mt-4 text-center">
            <p>@lang('No exchange found with this ID. Please check the ID and try again.')</p>
        </div>
    @endif
@endif
@endsection
