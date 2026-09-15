@php
    $recentTrades = \App\Models\Exchange::with('payment_from_getway', 'payment_to_getway')
        ->where('status', 1)
        ->latest()
        ->take(8)
        ->get();
@endphp
<div class="pm-notice">
    <div class="pm-ticker">
        <span class="pm-ticker-label">@lang('Live desk')</span>
        <marquee>
            <strong>@lang('100% guaranteed exchange.')</strong>
            @lang('Place orders only on this official website. Do not send money through Facebook, WhatsApp groups or unofficial pages. Working hours: 6 AM – 10 PM.')
            @foreach($recentTrades as $trade)
                &nbsp;·&nbsp;
                <strong>{{ $trade->exchange_id }}</strong>
                {{ optional($trade->payment_from_getway)->cur_sym }} → {{ optional($trade->payment_to_getway)->cur_sym }}
                {{ getAmount($trade->get_amount) }}
                @lang('settled')
            @endforeach
        </marquee>
    </div>
</div>
