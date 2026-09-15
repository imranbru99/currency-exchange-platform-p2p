@php
    $trustCompleted = \App\Models\Exchange::where('status', 1)->count();
    $trustPending = \App\Models\Exchange::where('status', 0)->count();
    $trustMethods = \App\Models\Currency::where(function ($query) {
        $query->where('available_for_sell', 1)->orWhere('available_for_buy', 1);
    })->count();
    $dhakaHour = \Carbon\Carbon::now('Asia/Dhaka')->hour;
    $deskOpen = $dhakaHour >= 6 && $dhakaHour < 22;
@endphp
<div class="pm-trust-strip">
    <div class="pm-trust-item">
        <strong>{{ number_format($trustCompleted) }}+</strong>
        <span>@lang('Completed orders')</span>
    </div>
    <div class="pm-trust-item">
        <strong>{{ number_format($trustMethods) }}</strong>
        <span>@lang('Live methods')</span>
    </div>
    <div class="pm-trust-item">
        <strong>{{ number_format($trustPending) }}</strong>
        <span>@lang('In processing')</span>
    </div>
    <div class="pm-trust-item">
        <strong class="{{ $deskOpen ? 'text-success' : 'text-warning' }}">{{ $deskOpen ? __('Desk open') : __('After hours') }}</strong>
        <span>@lang('6 AM – 10 PM (Dhaka)')</span>
    </div>
</div>
