@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 mb-30">
                    <div class="card b-radius--10 overflow-hidden box--shadow1">
                            <div class="card-body p-0">
                                        <div class="p-3 bg--white">
                                                    <div class="">
                                                        <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$user->image,imagePath()['profile']['user']['size'])}}" alt="@lang('Profile Image')" class="b-radius--10 w-100">
                                                    </div>
                                                    <div class="mt-15">
                                                        <h4 class="">{{$user->fullname}}</h4>
                                                        <span class="text--small">@lang('Joined At') <strong>{{showDateTime($user->created_at,'d M, Y h:i A')}}</strong></span> <br>
                                                        <span class="text--small">@lang('Last Login') <strong>{{showDateTime($user->last_seen,'d M, Y h:i A')}}</strong></span>
                                                    </div>
                                        </div>
                            </div>
                    </div>
                    <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                        <div class="card-body">
                            <h5 class="mb-20 text-muted">@lang('User information')</h5>
                            <ul class="list-group">

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Username')
                                    <span class="small">
                                    <a href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                    </span>
                                </li>


                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Status')
                                    @if($user->status == 1)
                                        <span class="badge badge-pill bg--success">@lang('Active')</span>
                                    @elseif($user->status == 0)
                                        <span class="badge badge-pill bg--danger">@lang('Banned')</span>
                                    @endif
                                </li>
                                 <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Balance')
                            <span class="font-weight-bold">{{getAmount($user->balance)}}  {{$general->cur_text}}</span>
                        </li>
                               <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Currency')
                            <span class="font-weight-bold">{{$user->currency}}  </span>
                        </li>
                        @if( $reff != null )
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Referred By')
                            <span class="font-weight-bold"><a href="{{ route('admin.users.detail', $reff->id) }}"> {{ $reff->username }}</a></span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Total Referral')
                            <span class="font-weight-bold">
                               <a href="#"> {{ $totalReferral }} User</a>
                            </span>
                        </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                        <div class="card-body">
                            <h5 class="mb-20 text-muted">@lang('User action')</h5>
                            <a href="{{ route('admin.users.login.history.single', $user->id) }}"
                            class="btn btn--primary btn--shadow btn-block btn-lg">
                                @lang('Login Logs')
                            </a>
                            <a href="{{route('admin.users.email.single',$user->id)}}"
                            class="btn btn--info btn--shadow btn-block btn-lg">
                                @lang('Send Email')
                            </a>
                            <a href="{{route('admin.users.login',$user->id)}}" target="_blank" class="btn btn--dark btn--shadow btn-block btn-lg">
                                @lang('Login as User')
                            </a>
                            <a href="{{route('admin.users.email.log',$user->id)}}" class="btn btn--warning btn--shadow btn-block btn-lg">
                                @lang('Email Log')
                            </a>
                        </div>
                    </div>
        </div>
        <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
            <div class="row mb-none-30">
                <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--12 b-radius--10 box-shadow has--link">
                        <a href="{{route('admin.users.tickets',$user->id)}}" class="item--link"></a>
                        <div class="icon">
                            <i class="la la-ticket-alt"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{$countTicket}}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('Total Ticket')</span>
                            </div>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->
                <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--17 b-radius--10 box-shadow has--link">
                        <a href="{{ route('admin.users.post.all', $user->id) }}" class="item--link"></a>
                        <div class="icon">
                            <i class="la la-blog"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{ $countPost }}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('Total Topic')</span>
                            </div>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->
                <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--deep-purple b-radius--10 box-shadow has--link">
                        <a href="{{route('admin.users.deposits',$user->id)}}" class="item--link"></a>
                        <div class="icon">
                            <i class="la la-blog"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{number_format($totalDeposit,2)}}</span>
                                <span class="currency-sign"> {{__($general->cur_sym)}}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('Total Deposit')</span>
                            </div>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->
                <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
                            <div class="dashboard-w1 bg--indigo b-radius--10 box-shadow has--link">
                                <a href="{{route('admin.users.withdrawals',$user->id)}}" class="item--link"></a>
                                <div class="icon">
                                    <i class="fa fa-wallet"></i>
                                </div>
                                <div class="details">
                                    <div class="numbers">
                                        <span class="amount">{{number_format($totalWithdraw,2)}}</span>
                                        <span class="currency-sign">{{__($general->cur_sym)}}</span>
                                    </div>
                                    <div class="desciption">
                                        <span>@lang('Total Withdraw')</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- dashboard-w1 end -->
                        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
                            <div class="dashboard-w1 bg--12 b-radius--10 box-shadow has--link">
                                <a href="{{route('admin.users.transactions',$user->id)}}" class="item--link"></a>
                                <div class="icon">
                                    <i class="la la-exchange-alt"></i>
                                </div>
                                <div class="details">
                                    <div class="numbers">
                                        <span class="amount">{{$totalTransaction}}</span>
                                    </div>
                                    <div class="desciption">
                                        <span>@lang('Total Transaction')</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- dashboard-w1 end -->
                        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
                            <div class="dashboard-w1 bg--gradi-11 b-radius--10 box-shadow has--link">
                                <a href="{{route('admin.reffer.user',$user->id)}}" class="item--link"></a>
                                <div class="icon">
                                    <i class="la la-exchange-alt"></i>
                                </div>
                                <div class="details">
                                    <div class="numbers">
                                        <span class="amount">{{$refferal}}</span>
                                    </div>
                                    <div class="desciption">
                                        <span>@lang('Total Refferal')</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- dashboard-w1 end -->
                    </div>

                    
                    <div class="card mt-50">
                        <div class="card-body">
                             <h5 class="card-title mb-50 border-bottom pb-2">{{$user->fullname}} @lang('Information')</h5>
                                 <form action="{{route('admin.users.update',[$user->id])}}" method="POST"
                                                     enctype="multipart/form-data">
                                                   @csrf
                                <div class="form-group col-sm-12">
                                    <label for="des">@lang('About')</label>
                                    <textarea name="about" id="about" class="form--control" oninput="carRemaining('aboutSpan', this.value, 60000)">{{ $user->about }}</textarea>
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
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="form-control-label font-weight-bold">@lang('First Name')<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="firstname" value="{{$user->firstname}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="lastname" class="col-form-label">@lang('Father Name'):</label>
                                        <input type="text" " id="lastname" name="lastname" placeholder="@lang('Father Name')" value="{{$user->lastname}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="email" class="col-form-label">@lang('E-mail Address'):</label>
                                        <input  id="email" placeholder="@lang('E-mail Address')" value="{{$user->email}}" readonly>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="phone" class="col-form-label">@lang('Mobile Number')</label>
                                        <input  id="phone" value="{{$user->mobile}}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="address" class="col-form-label">@lang('Permanent Address'):</label>
                                        <input type="text"  id="address" name="address" placeholder="@lang('Village, Post, Upojila, Zela')" value="{{@$user->address->address}}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="state" class="col-form-label">@lang('Present Address '):</label>
                                        <input type="text"  id="state" name="state" placeholder="@lang('Village, Post, Upojila, Zela')" value="{{@$user->address->state}}">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="zip" class="col-form-label">@lang('Permanent Address Zip Code'):</label>
                                        <input type="text"  id="zip" name="zip" placeholder="@lang('Permanent Address Zip Code')" value="{{@$user->address->zip}}">
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="city" class="col-form-label">@lang('NID Number'):</label>
                                        <input type="text"  id="city" name="city" placeholder="@lang('NID Number')" value="{{@$user->address->city}}">
                                    </div>

                            </div>


                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label">@lang('Country'):</label>
                                        <input  value="{{@$user->address->country}}" disabled>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="division" class="col-form-label">@lang('Division'):</label>
                                        <input type="text"  id="division" name="division" placeholder="@lang('Division')" value="{{@$user->address->division}}">
                                    </div>
                                </div>
                               
                              
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="mother" class="col-form-label">@lang('Mother Name'):</label>
                                        <input type="text"  id="mother" name="mother" placeholder="@lang('Mother Name')" value="{{@$user->address->mother}}">
                                    </div>
                                </div>



                              <div class="row">
                                    <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                        <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                        <input type="checkbox" data-onstyle="-success" data-offstyle="-danger"
                                            data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Banned')" data-width="100%"
                                            name="status"
                                            @if($user->status) checked @endif>
                                    </div>

                                    <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                        <label class="form-control-label font-weight-bold">@lang('Email Verification') </label>
                                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                            data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev"
                                            @if($user->ev) checked @endif>

                                    </div>

                                    <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                        <label class="form-control-label font-weight-bold">@lang('SMS Verification') </label>
                                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                            data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv"
                                            @if($user->sv) checked @endif>

                                    </div>
                                    <div class="form-group  col-md-6  col-sm-3 col-12">
                                        <label class="form-control-label font-weight-bold">@lang('2FA Status') </label>
                                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                            data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Deactive')" name="ts"
                                            @if($user->ts) checked @endif>
                                    </div>

                                    <div class="form-group  col-md-6  col-sm-3 col-12">
                                        <label class="form-control-label font-weight-bold">@lang('2FA Verification') </label>
                                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                            data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="tv"
                                            @if($user->tv) checked @endif>
                                    </div>
                        </div>


                            <div class="row mt-4">
                                        <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                                        </button>
                                                    </div>
                                        </div>

                            </div>
                    </form>


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
        </div>
    </div>

@endsection

@push('script')
    <script>
        "use strict";
        $("select[name=country]").val("{{ @$user->address->country }}");
    </script>
@endpush
