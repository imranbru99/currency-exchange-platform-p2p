@php
$date = Carbon\Carbon::now()->format('d-m-Y, h:i:s A');
$dhakaHour = Carbon\Carbon::now('Asia/Dhaka')->hour;
$deskOpen = $dhakaHour >= 6 && $dhakaHour < 22;
@endphp
<header>
    <div class="header-top">
        <div class="container">
            <div class="header-top-area">
                <div class="header-wrapper">
                    <div class="header-top-right-item header-top-item">
                        <i class="fas fa-clock"></i>
                        <span>@lang('Present Time'): <strong data-live-clock>{{ $date }}</strong></span>
                    </div>
                    <div class="header-top-right-item header-top-item">
                        <i class="fas fa-users-cog"></i>
                        <span>@lang('Working Time'): <strong>6 AM To 10 PM</strong>
                            <em class="pm-desk-dot {{ $deskOpen ? 'is-open' : 'is-closed' }}">{{ $deskOpen ? __('Open') : __('Closed') }}</em>
                        </span>
                    </div>
                    <div class="header-top-right-item header-top-item">
                        <a href="https://api.whatsapp.com/send/?phone=8801601888285">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp: <strong>+8801601888285</strong></span>
                        </a>
                    </div>
                    <div class="header-top-right-item header-top-item">
                        <a href="{{ route('track.exchange') }}"><i class="fas fa-search-location"></i> @lang('Track Order')</a>
                    </div>
                    <div class="header-top-right-item header-top-item">
                        <button type="button" class="pm-theme-toggle" data-theme-toggle aria-label="@lang('Toggle theme')">
                            <i class="las la-moon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header-bottom-area">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="@lang('logo')">
                    </a>
                </div>
                <div class="menu-area">
                    <ul class="menu">
                        <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                        <li><a href="{{ route('tryexchange') }}">@lang('Exchange')</a></li>
                        <li><a href="{{ route('rates') }}">@lang('Rates')</a></li>
                        <li><a href="{{ route('status') }}">@lang('Reserves')</a></li>
                        <li><a href="{{ route('post.all') }}">@lang('Forum')</a></li>
                        <li><a href="{{ route('how') }}">@lang('How it works')</a></li>
                        <li><a href="{{ route('faq') }}">@lang('FAQ')</a></li>
                        <li><a href="{{ route('blog') }}">@lang('News')</a></li>
                        @guest
                            <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                            <li>
                                <a href="{{ route('user.login') }}" class="btn btn-md btn--gradient d-flex align-items-center"><i class="las la-user fs--18px me-2"></i>@lang('Login')</a>
                            </li>
                            <li>
                                <a href="{{ route('user.register') }}" class="btn btn-md btn--gradient d-flex align-items-center"><i class="las la-user-plus fs--18px me-2"></i>@lang('Register')</a>
                            </li>
                        @endguest
                        @auth
                            @if(request()->is('user/authorization'))
                                <li>
                                    <a href="{{ route('user.logout') }}" class="btn btn-md btn--gradient d-flex align-items-center"><i class="las la-sign-out-alt fs--18px me-2"></i>@lang('Logout')</a>
                                </li>
                            @else
                                <li><a href="{{ route('user.notifications') }}">@lang('Alerts')</a></li>
                                <li>
                                    <a href="{{ route('user.home') }}" class="btn btn-md btn--gradient d-flex align-items-center"><i class="las la-user fs--18px me-2"></i>@lang('Dashboard')</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    <div class="header-bar-area d-lg-none">
                        <div class="header-bar">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="ellipsis-bar d-xl-none">
                        <i class="fas fa-ellipsis-v"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
