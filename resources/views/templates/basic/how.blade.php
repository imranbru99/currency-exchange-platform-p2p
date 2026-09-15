@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="pm-page-head">
    <span class="pm-kicker">@lang('Simple flow')</span>
    <h1>@lang('How the exchange works')</h1>
    <p>@lang('Four steps from quote to settlement. Orders are only valid on this official website.')</p>
</div>

<div class="pm-steps">
    <article class="pm-card pm-step">
        <span class="pm-step-num">01</span>
        <h3>@lang('Get a live quote')</h3>
        <p>@lang('Pick the method you will pay with and the method you want to receive. The calculator shows rate, fee, min/max and reserve before you continue.')</p>
        <a href="{{ route('tryexchange') }}" class="btn btn--gradient">@lang('Open calculator')</a>
    </article>
    <article class="pm-card pm-step">
        <span class="pm-step-num">02</span>
        <h3>@lang('Confirm with an account')</h3>
        <p>@lang('Login or register to lock the pair. Guest users can start the calculator; confirmation needs a verified member account.')</p>
        <a href="{{ route('user.register') }}" class="btn btn--base">@lang('Create account')</a>
    </article>
    <article class="pm-card pm-step">
        <span class="pm-step-num">03</span>
        <h3>@lang('Pay or upload proof')</h3>
        <p>@lang('Send funds through the selected method. Automatic gateways redirect you to pay. Manual methods ask for transaction proof and wallet details.')</p>
    </article>
    <article class="pm-card pm-step">
        <span class="pm-step-num">04</span>
        <h3>@lang('Receive after approval')</h3>
        <p>@lang('Our desk checks reserve and payment, then credits the receive method. Track the order by Exchange ID at any time.')</p>
        <a href="{{ route('track.exchange') }}" class="btn btn--base">@lang('Track an order')</a>
    </article>
</div>

<div class="pm-card mt-4 p-4">
    <h3>@lang('What to remember')</h3>
    <ul class="pm-check-list">
        <li>@lang('Never send money through Facebook, IMO or unofficial WhatsApp deals.')</li>
        <li>@lang('Keep your Exchange ID. It is enough to track status without logging in.')</li>
        <li>@lang('If we cannot deliver the requested currency, the amount is refunded. Network fees such as USDT still apply.')</li>
        <li>@lang('Working hours are 6 AM to 10 PM (Asia/Dhaka). After-hours orders wait in the pending queue.')</li>
    </ul>
    <div class="pm-trust-strip mt-4">
        <div class="pm-trust-item">
            <strong>{{ number_format($stats['completed'] ?? 0) }}+</strong>
            <span>@lang('Completed')</span>
        </div>
        <div class="pm-trust-item">
            <strong>{{ number_format($stats['pending'] ?? 0) }}</strong>
            <span>@lang('Pending now')</span>
        </div>
    </div>
</div>
@endsection
