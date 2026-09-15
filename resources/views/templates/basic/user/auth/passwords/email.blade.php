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
            <div class="row">
              <div class="col-md-6">
                <div class="account-thumb bg_img h-100 d-flex flex-wrap align-items-center justify-content-center rounded-3" style="background-image: url('{{ getImage('assets/images/frontend/auth/' .@$bg->data_values->image, '1920x1280') }}');">
                  <div class="text-center">
                    <p class="text-dark mt-2">@lang('Nothing to worry about, you can always set a new password as long you have the access to the email you registered with.')</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="account-content">
                  <div class="text-center mb-5">
                    <h2 class="account-content__title">@lang('Reset Password')</h2>
                  </div>
                  <form method="POST" action="{{ route('user.password.email') }}">
                      @csrf
                    <div class="form-group">
                      <label class="mb-0" for="type">@lang('Select One')</label>
                          <select class="form--control select" name="type" id="type" required="">
                              <option value="email">@lang('E-Mail Address')</option>
                              <option value="username">@lang('Username')</option>
                          </select>
                    </div>
                    <div class="form-group">
                      <label class="mb-0 my_value"></label>
                      <input type="text" class="form--control @error('value') is-invalid @enderror" name="value" value="{{ old('value') }}" required autofocus="off">

                      @error('value')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror

                    </div>

                    <div class="text-center mt-4">
                      <button type="submit" class="btn btn--gradient w-100">@lang('Send Password Code')</button>
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
        
        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }

        $('.main-wrapper').addClass('d-flex flex-wrap justify-content-center align-items-center h-100 account-section');

        $(".main-wrapper").css("background-image", "url('{{ getImage('assets/images/frontend/auth/' .@$bg->data_values->image, '1920x1280') }}')");
    })(jQuery)
</script>
@endpush