@extends($activeTemplate.'layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-xl-9 mt-xl-0 mt-5">
        @if(Auth::user()->ts)
            <div class="card">
                <div class="forum-block__header">
                    <h5 class="forum-block__title">@lang('Two Factor Authenticator')</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mx-auto text-center">

                        <p class="fs--14px mt-2 mb-3">@lang('Use Google Authentication App to scan the QR code') <a class="text--base" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('App Link')</a></p>

                        <a href="#0" class="btn btn-block btn-lg bg-primary w-100" data-bs-toggle="modal" data-bs-target="#disableModal">
                            @lang('Disable Two Factor Authenticator')
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="card">
                <div class="forum-block__header">
                    <h5 class="forum-block__title">@lang('Two Factor Authenticator')</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-4 text-center">
                            <div class="form-group mx-auto text-center">
                                <img class="w-100" src="{{$qrCodeUrl}}">
                            </div>
                            <p class="fs--14px mt-2">@lang('Use Google Authentication App to scan the QR code') <a class="text--base" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('App Link')</a></p>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="key" value="{{$secret}}" class="form--control form-control-lg" id="referralURL" readonly>
                                    <span class="input-group-text copytext bg--base text-white border-0" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                                </div>
                            </div>
                            <p>@lang('If you have any problem with scanning the QR code enter this code manually into the APP.')</p>
                            
                            <div class="form-group mx-auto text-center mt-3">
                                <form action="{{route('user.twofactor.enable')}}" method="POST" class="qr-code-apply-form">
                                    @csrf
                                    <input type="hidden" name="key" value="{{$secret}}">
                                    <input type="text" class="form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                                    <button type="submit" class="btn btn-md bg-primary">@lang('Verify')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">@lang('Verify Your Otp Disable')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('user.twofactor.disable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-md bg-primary">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
</div>
@endsection

@push('script')
    <script>
        (function($){
            "use strict";

            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush


