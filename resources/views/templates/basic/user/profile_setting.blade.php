@extends($activeTemplate.'layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
                <div class="col-xl-9 mt-xl-0 mt-5">
                    <div class="card">
                        <div class="row justify-content-center">
                            
                        <div class="row">
                           @if ($user->status == 0) 
                           <p class="text-success"> @lang('Verification Uncomplete')</p>
                           <a href="verifyingdata" class="btn btn-xs btn-info pull-right">Your Verification Completed</a>
                           @elseif ($user->status == 1) 
                           <H2 class="text-danger">@lang('You are Non Verified')</H2>
                            @endif
                        </div>
                        <br>
                    </div>
                           <div class="forum-block__header">
                            <div class="forum-block__title">
                                <h5 class="text-white">@lang('Profile')</h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <form class="register prevent-double-click" action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col-sm-12">
                                    <label for="des">@lang('About')</label>
                                    <textarea name="about" id="about" class="form--control" required="" oninput="carRemaining('aboutSpan', this.value, 60000)">{{ $user->about }}</textarea>
                                    <span id="aboutSpan" class="remaining">
                                        <span class="charDes">
                                            <span class="aboutLength">
                                                60000
                                            </span>
                                        </span>
                                        @lang('characters remaining')
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="InputFirstname" class="col-form-label">@lang('First Name'):</label>
                                        <input type="text" class="form--control" id="InputFirstname" name="firstname" placeholder="@lang('Full Name')" value="{{$user->firstname}}" minlength="3">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="lastname" class="col-form-label">@lang('Last Name'):</label>
                                        <input type="text" class="form--control" id="lastname" name="lastname" placeholder="@lang('Father Name')" value="{{$user->lastname}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="email" class="col-form-label">@lang('E-mail Address'):</label>
                                        <input class="form--control" id="email" placeholder="@lang('E-mail Address')" value="{{$user->email}}" readonly>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="phone" class="col-form-label">@lang('Mobile Number')</label>
                                        <input class="form--control" id="phone" value="{{$user->mobile}}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="address" class="col-form-label">@lang('Permanent Address'):</label>
                                        <input type="text" class="form--control" id="address" name="address" placeholder="@lang('Village, Post, Upojila, Zela')" value="{{@$user->address->address}}" required="">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="state" class="col-form-label">@lang('Present Address '):</label>
                                        <input type="text" class="form--control" id="state" name="state" placeholder="@lang('Village, Post, Upojila, Zela')" value="{{@$user->address->state}}" required="">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="zip" class="col-form-label">@lang('Permanent Address Zip Code'):</label>
                                        <input type="text" class="form--control" id="zip" name="zip" placeholder="@lang('Permanent Address Zip Code')" value="{{@$user->address->zip}}" required="">
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="city" class="col-form-label">@lang('NID Number'):</label>
                                        <input type="text" class="form--control" id="city" name="city" placeholder="@lang('NID Number')" value="{{@$user->address->city}}" required="">
                                    </div>

                            </div>


                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label">@lang('Country'):</label>
                                        <input class="form--control" value="{{@$user->address->country}}" disabled>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="division" class="col-form-label">@lang('Division'):</label>
                                        <input type="text" class="form--control" id="division" name="division" placeholder="@lang('Division')" value="{{@$user->address->division}}" required="">
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label d-block">@lang('NID Front Side'):</label>
                                        <input type="file" name="nid_front" accept="image/*" class="form--control">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label d-block">@lang('NID Back Side'):</label>
                                        <input type="file" name="nid_back" accept="image/*" class="form--control">
                                    </div>
                                </div>
                              
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="mother" class="col-form-label">@lang('Mother Name'):</label>
                                        <input type="text" class="form--control" id="mother" name="mother" placeholder="@lang('Mother Name')" value="{{@$user->address->mother}}" required="">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label d-block">@lang('Provide your self image'):</label>
                                        <input type="file" name="image" accept="image/*" class="form--control" value="{{@$user->image}}"> 
                                    </div>
                                    <div class="row">
                                        <div class="row justify-content-center">
                                            Own Selfee
                                                    <div class="profile-thumb">
                                                        <img src="{{ $user->photo }}" alt="image">
                                                    </div>
                                        </div>
                                    </div>
                                    <div class="profile-details-wrapper">
                                        <div class="row justify-content-center">
                                            NID Front
                                            <div class="profile-thumb">
                                                <img src="{{ getImage(imagePath()['nid_front']['path'].'/'.$user->nid_front,imagePath()['nid_front']['size'])}}" alt="@lang('Nid front Image')" class="b-radius--10 w-100">
                                              </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            NID Back
                                            <div class="profile-thumb">
                                                <img src="{{ getImage(imagePath()['nid_back']['path'].'/'.$user->nid_back,imagePath()['nid_back']['size'])}}" alt="@lang('Nid back Image')" class="b-radius--10 w-100">
                                              </div>
                                        </div>
                                    </div>
                               
                                </div>

                                <div class="form-group row pt-5">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-block bg-primary text-white w-100">@lang('Update Profile')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    </div>
</div>
@endsection
@push('style-lib')
    <link href="{{ asset($activeTemplateTrue.'css/bootstrap-fileinput.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/common/custom.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" href="{{asset('assets/admin/build/css/intlTelInput.css')}}">
    <style>
        .intl-tel-input {
            position: relative;
            display: inline-block;
            width: 100%;!important;
        }
    </style>
@endpush

@push('script')
<script>
  (function ($) {
    "use strict";

    let aboutLength = parseInt({{ strlen($user->about) }});
    $('.aboutLength').text(60000-aboutLength);

  })(jQuery);
</script>
@endpush
