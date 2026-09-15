@extends($activeTemplate.'layouts.basic')

@section('content')

@php
  $login = getContent('login.content', true);
  $bg = getContent('auth.content', true);
@endphp

    <!-- account section start -->
    <section class="pt-100 pb-100">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-10">
            <div class="account-wrapper">
              <div class="row">
                <div class="col-md-6">
                  <div class="account-thumb bg_img h-100 d-flex flex-wrap align-items-center justify-content-center" style="background-image: url('{{ getImage('assets/images/frontend/auth/' .@$bg->data_values->image, '1920x1280') }}');">
                    <div class="text-center">
                      <h2 class="text-white">@lang('Welcome to') {{ __(@$general->sitename) }}</h2>
                      <p class="text-white mt-2">{{ __(@$login->data_values->text) }}</p>
                      <p class="text-white-50 mt-2">@lang('Official desk only. Dark mode and live quotes included.')</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="account-content">
                    <div class="text-center mb-5">
                      <span class="pm-kicker">@lang('Secure login')</span>
                      <h2 class="account-content__title">@lang('Welcome back')</h2>
                      <p class="mt-2 fs--14px">@lang("Haven't an account")? <a href="{{ route('user.register') }}">@lang('Create New')</a></p>
                    </div>
                    <form method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();">
                        @csrf
                      <div class="form-group">
                        <label class="mb-0" for="username">@lang('Username or Email')</label>
                        <div class="custom-icon-field">
                          <i class="las la-user"></i>
                          <input type="text" name="username" value="{{ old('username') }}" id="username" class="form--control" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="mb-0" for="password">@lang('Password')</label>
                        <div class="custom-icon-field">
                          <i class="las la-key"></i>
                          <input id="password" type="password" class="form--control" name="password" required>
                        </div>

                      </div>

                        <div class="form-group">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                @php echo loadReCaptcha() @endphp
                            </div>
                        </div>

                        @include($activeTemplate.'partials.custom_captcha')

                      <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        @lang('Remember Me')
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div>
                                    <a href="{{route('user.password.request')}}" class="fs--14px">
                                        @lang('Forgot Your Password')?
                                    </a>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div class="text-center mt-4">
                        <button type="submit" class="btn btn--gradient w-100">@lang('Login Now')</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div><!-- account-wrapper end -->
          </div>
        </div>
      </div>
    </section>
    <!-- account section end -->

@endsection

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }

        $('.main-wrapper').addClass('d-flex flex-wrap justify-content-center align-items-center h-100 account-section');

        $(".main-wrapper").css("background-image", "url('{{ getImage('assets/images/frontend/auth/' .@$bg->data_values->image, '1920x1280') }}')");

    </script>
@endpush

@push('script-lib')
<script src="{{ asset('assets/common/custom.js') }}"></script>
@endpush

