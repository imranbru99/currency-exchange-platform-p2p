@php
  $footer = getContent('footer.content', true);
  $policy_pages = getContent('policy_pages.element');
@endphp

<footer class="footer-section">
  <div class="footer-bottom">
    <div class="container-fluid px-xxl-5">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-6">
          <div class="item mb-sm50">
            <a class="logo" href="{{ route('home') }}">
              <img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="logo">
            </a>
            <p class="mt-3">
              <strong>@lang('Guaranteed exchange platform with reserve-backed rates, community reviews and 24/7 support.')</strong>
            </p>
            <form class="pm-newsletter mt-3" method="POST" action="{{ route('subscribe') }}">
              @csrf
              <input type="email" name="email" class="form--control" placeholder="@lang('Subscribe for rate alerts')" required>
              <button type="submit" class="btn btn--gradient">@lang('Join')</button>
            </form>
            <a class="d-inline-block mt-3 dmca-badge" href="//www.dmca.com/Protection/Status.aspx?ID=dd5f13ef-bdf2-419f-b41f-73eadfe7dac0" title="DMCA.com Protection Status">
              <img src="https://images.dmca.com/Badges/dmca-badge-w250-2x1-02.png?ID=dd5f13ef-bdf2-419f-b41f-73eadfe7dac0" alt="DMCA.com Protection Status">
            </a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4">
          <div class="item">
            <ul>
              <li><a href="{{ route('home') }}"><strong>@lang('Home')</strong></a></li>
              <li><a href="{{ route('tryexchange') }}"><strong>@lang('Exchange')</strong></a></li>
              <li><a href="{{ route('rates') }}"><strong>@lang('Rates & Fees')</strong></a></li>
              <li><a href="{{ route('status') }}"><strong>@lang('Reserves')</strong></a></li>
              <li><a href="{{ route('track.exchange') }}"><strong>@lang('Track Order')</strong></a></li>
              <li><a href="{{ route('how') }}"><strong>@lang('How it works')</strong></a></li>
            </ul>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4">
          <div class="item">
            <ul>
              <li><a href="{{ route('user.register') }}"><strong>@lang('Register')</strong></a></li>
              <li><a href="{{ route('user.login') }}"><strong>@lang('Login')</strong></a></li>
              <li><a href="{{ route('faq') }}"><strong>@lang('FAQ')</strong></a></li>
              <li><a href="{{ route('tutorial') }}"><strong>@lang('Tutorial')</strong></a></li>
              <li><a href="{{ route('contact') }}"><strong>@lang('Contact Us')</strong></a></li>
              <li><a href="{{ route('post.all') }}"><strong>@lang('Community Forum')</strong></a></li>
              <li><a href="{{ route('blog') }}"><strong>@lang('News')</strong></a></li>
              <li><a href="{{ url('/page/about-us') }}"><strong>@lang('About')</strong></a></li>
            </ul>
          </div>
        </div>

        <div class="col-lg-3 col-md-9">
          <div class="item">
            <img style="width: 167px;margin: 3px 0 0;" src="{{ asset('assets/images/frontend/Guarantee.png') }}" alt="guarantee">
            <p class="mt-3">
              @lang('If we fail to provide your requested currency, we return your money. Network fees such as USDT charges still apply.')
            </p>
            @if($policy_pages)
              <ul class="pm-policy-links mt-3">
                @foreach($policy_pages as $policy)
                  @if(!empty($policy->data_values->title))
                    <li><a href="{{ route('policy.page', [slug($policy->data_values->title), $policy->id]) }}">{{ __($policy->data_values->title) }}</a></li>
                  @endif
                @endforeach
              </ul>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="sub-footer">
      <div class="container">
        <div class="form-group text-center mb-0">
          <strong>Copyright © 2022-{{ date('Y') }} <a href="{{ route('home') }}">{{ __($general->sitename ?? 'PMBUYSELL Ltd') }}</a> @lang('All Rights Reserved.')</strong>
        </div>
      </div>
    </div>
  </div>
</footer>

<a class="pm-float-wa" href="https://api.whatsapp.com/send/?phone=8801601888285&text=I%20want%20to%20exchange" target="_blank" rel="noopener" aria-label="WhatsApp">
  <i class="lab la-whatsapp"></i>
</a>
