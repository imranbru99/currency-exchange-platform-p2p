@extends($activeTemplate . 'layouts.exchange')
@section('content')
<section class="container py-5">
    <div class="pm-page-head text-center">
        <span class="pm-kicker">@lang('Public receipt')</span>
        <h1>@lang('Exchange details')</h1>
    </div>
    @if($exchanges)
        <div class="pm-card p-4" data-print-area>
            <div class="pm-track-result">
                <div>
                    <span class="pm-muted">@lang('Exchange ID')</span>
                    <h3>
                        <span data-copy-value>{{ $exchanges->exchange_id }}</span>
                        <button type="button" class="pm-icon-btn" data-copy title="@lang('Copy ID')"><i class="las la-copy"></i></button>
                    </h3>
                    <p class="pm-muted mb-0">{{ optional($exchanges->user)->fullname }}</p>
                </div>
                <div>
                    @if($exchanges->status == 0)
                        <span class="pm-badge pm-badge-warn">@lang('Pending')</span>
                    @elseif($exchanges->status == 1)
                        <span class="pm-badge pm-badge-success">@lang('Completed')</span>
                    @elseif($exchanges->status == 2)
                        <span class="pm-badge pm-badge-danger">@lang('Cancelled')</span>
                    @else
                        <span class="pm-badge pm-badge-info">@lang('Refunded')</span>
                    @endif
                </div>
            </div>
            <div class="pm-receipt-grid">
                <div>
                    <span>@lang('Send from')</span>
                    <strong>{{ optional($exchanges->payment_from_getway)->name }}</strong>
                    <small>{{ getAmount($exchanges->get_amount) }} {{ optional($exchanges->payment_from_getway)->cur_sym }}</small>
                </div>
                <div>
                    <span>@lang('Receive in')</span>
                    <strong>{{ optional($exchanges->payment_to_getway)->name }}</strong>
                    <small>{{ getAmount($exchanges->send_amount) }} {{ optional($exchanges->payment_to_getway)->cur_sym }}</small>
                </div>
                <div>
                    <span>@lang('Created')</span>
                    <strong>{{ optional($exchanges->created_at)->format('d M Y, h:i A') }}</strong>
                </div>
                <div>
                    <span>@lang('Updated')</span>
                    <strong>{{ optional($exchanges->updated_at)->format('d M Y, h:i A') }}</strong>
                </div>
            </div>
            <div class="pm-action-row mt-4">
                <a href="{{ route('track.exchange', ['exchange_id' => $exchanges->exchange_id]) }}" class="btn btn--base">@lang('Track again')</a>
                <button type="button" class="btn btn--gradient" data-print>@lang('Print receipt')</button>
            </div>
        </div>
    @else
        <div class="pm-card text-center p-5">
            <h3>@lang('Exchange not found')</h3>
            <a href="{{ route('track.exchange') }}" class="btn btn--gradient mt-3">@lang('Go to tracker')</a>
        </div>
    @endif
</section>
@endsection
