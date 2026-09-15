@extends($activeTemplate.'layouts.exchange')
@php
    $contact = getContent('contact_us.content',true)
@endphp
@section('content')
<section class="container py-5">
    <div class="pm-page-head text-center">
        <span class="pm-kicker">@lang('Guide')</span>
        <h1>@lang('Exchange tutorial')</h1>
        <p>@lang('Watch the walkthrough, then start with a live quote on the exchange desk.')</p>
    </div>
    <div class="pm-card p-3 pm-video-wrap">
        <iframe src="https://www.youtube.com/embed/BACuUngrSyQ" title="YouTube video player" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <div class="row g-4 mt-2">
        <div class="col-md-4">
            <div class="pm-card p-4 h-100">
                <span class="pm-muted">@lang('Email')</span>
                <strong>Support@pmbuysell.com</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="pm-card p-4 h-100">
                <span class="pm-muted">@lang('Phone')</span>
                <strong>+8801601888285</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="pm-card p-4 h-100">
                <span class="pm-muted">@lang('Location')</span>
                <strong>@lang('Dhaka, Bangladesh')</strong>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('how') }}" class="btn btn--base">@lang('Read how it works')</a>
        <a href="{{ route('tryexchange') }}" class="btn btn--gradient">@lang('Start exchange')</a>
    </div>
</section>
@endsection
