@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="pm-page-head">
    <span class="pm-kicker">@lang('Help center')</span>
    <h1>{{ __(@$faq->data_values->heading) ?: __('Frequently Asked Questions') }}</h1>
    <p>{{ __(@$faq->data_values->sub_heading) ?: __('Answers about exchange, fees, reserve and support.') }}</p>
</div>

<div class="pm-faq-list">
    @forelse($faqs as $item)
        <details class="pm-card pm-faq-item">
            <summary>{{ __($item->data_values->question) }}</summary>
            <div class="pm-faq-body">{!! $item->data_values->answer !!}</div>
        </details>
    @empty
        <div class="pm-card">
            <h4>@lang('How long does an exchange take?')</h4>
            <p>@lang('Most orders are processed within a few minutes during working hours. Technical delays are completed within a few hours.')</p>
        </div>
        <div class="pm-card">
            <h4>@lang('Is my money guaranteed?')</h4>
            <p>@lang('Yes. Place orders only through this official website. If we fail to deliver the requested currency, your money is returned.')</p>
        </div>
        <div class="pm-card">
            <h4>@lang('How do I track an order?')</h4>
            <p>@lang('Use Track Exchange from the menu and enter your exchange ID, or log in to view your exchange history.')</p>
        </div>
    @endforelse
</div>
@endsection
