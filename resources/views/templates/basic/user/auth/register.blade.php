@extends($activeTemplate.'layouts.basic')
@php
  $register = getContent('register.content', true);
  $bg = getContent('auth.content', true);
  $policy_pages = getContent('policy_pages.element');
@endphp
@section('content')
    <!--=======Account-Service Starts Here=======-->
    <section class="pt-100 pb-100">
        <div class="container" >
            <div class="section-header margin-olpo left-style">
                <div class="text-center">
                    <h2 class="text-dark">@lang('Welcome to') {{ __(@$general->sitename) }}</h2>
                    <p class="text-dark mt-2">{{ __(@$register->data_values->text) }}</p>
                    <p class="text-dark">@lang('Already have an account')? <a href="{{ route('user.login') }}" ><strong>Login </strong> </a></p>
                  </div>
            </div>
            <form class="account-form" action="{{ route('user.register') }}" method="POST" onsubmit="return submitUserForm();">
                @csrf

                @if (session()->get('reference') != null)
                    <div class="form-group col-md-6">
                        <label for="firstname"
                            class="">{{ __('Reference BY') }}</label>
                            <input type="text" name="referBy" id="referenceBy" class="form-control"
                                value="{{ session()->get('reference') }}" readonly>
                        
                    </div>
                @endif
                <div class="form-group col-md-6">
                    <label for="name01">@lang('First Name')</label>
                    <input id="firstname" type="text" class="form-control" name="firstname"
                                        value="{{ old('firstname') }}" required placeholder="@lang('First Name')">
                </div>
                <div class="form-group col-md-6">
                    <label for="name02">@lang('Last Name')</label>
                    <input id="lastname" type="text" class="form-control" name="lastname"
                                        value="{{ old('lastname') }}" required placeholder="@lang('Last Name')">
                </div>
                <div class="form-group col-md-6">
                    <label for="email01">@lang('Email Address')</label>
                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" required placeholder="@lang('Email')">
                </div>

                <div class="form-group col-md-6">
                    <label for="email01">@lang('User name')</label>
                    <input id="username" type="text" class="form-control" name="username"
                                        value="{{ old('username') }}" required placeholder="@lang('User Name')"> 
                </div>

                <div class="form-group col-md-6">

                                <label for="mobile" class="text-md-right">{{ __('Mobile') }}</label>
                                

                                    <div class=" country-code">

                                        <div class="input-group ">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <select name="country_code">
                                                        @include('partials.country_code')
                                                    </select>
                                                </span>
                                            </div>
                                            <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="@lang('Your Phone Number')">
                                        </div>
                                    </div>

                                
                            </div>

                             <div class="form-group col-md-6" style="display: none;">
                                <label for="email" class="text-md-right">{{ __('Country') }}</label>
                                <input type="text" name="country" class="form-control" readonly>
                            </div>

               
                            <div class="form-group col-md-6">
                                <label for="pass01">@lang('Your Password')</label>
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required
                                        placeholder="@lang('Password')">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            

                <div class="form-group col-md-12">
                    <div class="row">
                        @include($activeTemplate.'partials.custom-captcha')
                    </div>
                </div>

               
                @include($activeTemplate.'partials.custom_captcha')

                    @if($general->agree)
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="checkbox" id="agree" name="agree">
                                <label for="agree">
                                    @lang('I agree with ')
                                    @foreach($policy_pages as $singlePolicy)
                                        <a href="{{ route('policy.page', ['page'=>slug($singlePolicy->data_values->title), 'id'=>$singlePolicy->id]) }}" target="_blank">
                                            {{ __($singlePolicy->data_values->title) }}
                                            {{ $loop->last ? '.' : ', ' }}
                                        </a>
                                    @endforeach
                                </label>
                            </div>
                        </div>
                    @endif

                 <div class="form-group col-md-12">
                    <input type="submit" value="Sign Up">
                </div>
                <div class="form-group checkgroup">
                <label for="check02" class="w-100 p-0">@lang('Already Have an account??') <a href="{{route('user.login')}}">@lang('Sign
                            In')</a></label>
                </div>
            </form>
        </div>
    </section>
    <!--=======Account-Service Ends Here=======-->

@endsection
@push('style-lib')

    <link href="{{ asset($activeTemplateTrue) . '/css/intlTelInput.css' }}" rel="stylesheet">

@endpush


@push('script-lib')
    <script src="{{ asset($activeTemplateTrue) . '/js/intlTelInput-jquery.min.js' }}"></script>
@endpush

@push('script')

    <script>
        'use strict'
        @if($country_code)
        var t = $(`option[data-code={{ $country_code }}]`).attr('selected','');
      @endif
        $('select[name=country_code]').change(function(){
            $('input[name=country]').val($('select[name=country_code] :selected').data('country'));
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
        }).change();

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    '<span style="color:red;">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }

        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }

    </script>
@endpush


@push('style')

    <style>
        .iti{
            display: block
        }

        .country-code .input-group-prepend .input-group-text{
        background: #fff !important;
    }
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }

    .input-group-text{
            padding: 0;
    }
    

    </style>
    
@endpush