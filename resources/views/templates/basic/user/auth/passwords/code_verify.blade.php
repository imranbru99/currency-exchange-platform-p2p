@extends($activeTemplate.'layouts.basic')
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
                  <div class="text-center">
                    <p class="text-dark mt-2">
                        @lang('Please check including your Junk/Spam Folder. if not found, you can')
                        <a href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="account-content">
                  <div class="text-center mb-5">
                    <h2 class="account-content__title">@lang('Verification')</h2>
                  </div>
                  <form method="POST" action="{{ route('user.password.verify.code') }}">
                      @csrf

                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="form-group">
                      <label class="mb-0" for="code">@lang('Verification Code')</label>
                      <input type="text" name="code" id="code" class="form--control" required="">
                    </div>

                    <div class="text-center mt-4">
                      <button type="submit" class="btn btn--gradient w-100">@lang('Verify Code')</button>
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