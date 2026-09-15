@extends($activeTemplate .'layouts.basic')
@section('content')

@php 
  $bg = getContent('auth.content', true);
@endphp

<!-- account section start -->
<section class="pt-100 pb-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10">
        <div class="account-wrapper">
          <div class="row gy-4">
            <div class="col-lg-6">
              <div class="account-thumb bg_img h-100 d-flex flex-wrap align-items-center justify-content-center rounded-3" style="background-image: url('{{ getImage('assets/images/frontend/auth/' .@$bg->data_values->image, '1920x1280') }}');">
                <div class="text-center text-white">
                  <p>@lang('If you don\'t get any code'), <a href="{{route('user.send.verify.code')}}?type=phone" class="forget-pass"> @lang('Try again')</a></p>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="account-content">
                <div class="text-center mb-5">
                  <h4 class="account-content__title">@lang('Please Verify Your Mobile to Get Access')</h4>
                </div>
                <form action="{{route('user.verify.sms')}}" method="POST" class="login-form">
                    @csrf
                  <div class="form-group">
                    <p class="text-center">@lang('Your Mobile Number'):  <strong>{{auth()->user()->mobile}}</strong></p>
                  </div>
                  <div class="form-group">
                    <label class="mb-0" for="password">@lang('Verification Code')</label>
                    <input type="text" name="sms_verified_code" id="code" class="form--control" required="">
                    @if ($errors->has('resend'))
                        <br/>
                        <small class="text-danger">{{ $errors->first('resend') }}</small>
                    @endif
                  </div>

                  <div class="text-center mt-4">
                    <button type="submit" class="btn btn--gradient w-100">@lang('Submit')</button>
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
    (function($){
        "use strict";
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;
          $(this).val(function (index, value) {
             value = value.substr(0,7);
              return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
          });
      });
    })(jQuery)
</script>
@endpush