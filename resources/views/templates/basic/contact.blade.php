@extends($activeTemplate.'layouts.basic')

@section('content')

@php
    $contact = getContent('contact_us.content', true);
    $contacts = getContent('contact_us.element');
@endphp

<section class="pt-100 pb-50">
  <div class="container">
    <div class="pm-page-head text-center">
      <span class="pm-kicker">@lang('Support')</span>
      <h1>{{ __(@$contact->data_values->heading) ?: __('Contact the desk') }}</h1>
      <p>{{ __(@$contact->data_values->sub_heading) ?: __('Official WhatsApp and ticket support only. No Facebook or IMO deals.') }}</p>
    </div>

    <div class="pm-card p-4 mb-4">
      <h3>@lang('Safe-use terms')</h3>
      <ul class="pm-check-list">
        <li>@lang('Do not use this service for illegal transfers, gambling or money laundering.')</li>
        <li>@lang('We cooperate with lawful authorities on financial crime cases.')</li>
        <li>@lang('Orders are valid only through this official website.')</li>
        <li>@lang('This desk is built for freelancers who need a guaranteed dollar exchange.')</li>
      </ul>
    </div>

    <div class="contact-wrapper">
      <div class="row gy-4">
        @foreach($contacts as $singleContact)
          <div class="col-md-4">
            <div class="contact-item pm-card p-4 h-100 text-center">
              @php echo $singleContact->data_values->icon; @endphp
              <p>{{ __($singleContact->data_values->contact) }}</p>
            </div>
          </div>
        @endforeach
      </div>
      <form class="mt-5" method="post" action="{{ route('contact.send') }}">
        @csrf
        <div class="row">
          <div class="form-group col-lg-6">
            <label for="name">@lang('Name')</label>
            <input type="text" name="name" id="name" class="form--control" value="@if(auth()->user()) {{ auth()->user()->fullname }} @else {{ old('name') }} @endif" @if(auth()->user()) readonly @endif required>
          </div>
          <div class="form-group col-lg-6">
            <label for="email">@lang('Email')</label>
            <input name="email" type="text" id="email" class="form--control" value="@if(auth()->user()) {{ auth()->user()->email }} @else {{old('email')}} @endif" @if(auth()->user()) readonly @endif required>
          </div>
          <div class="form-group col-lg-12">
            <label for="subject">@lang('Subject')</label>
            <input name="subject" id="subject" type="text" class="form--control" value="{{old('subject')}}" required>
          </div>
          <div class="form-group col-lg-12">
            <label for="message">@lang('Message')</label>
            <textarea name="message" id="message" class="form--control" rows="5" required>{{old('message')}}</textarea>
          </div>
          <div class="col-lg-12 text-end">
            <button type="submit" class="btn btn--gradient">@lang('Open support ticket')</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
