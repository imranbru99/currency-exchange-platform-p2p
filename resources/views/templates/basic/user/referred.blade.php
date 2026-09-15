
@extends($activeTemplate .'layouts.master')
@section('content')
<section>
    <div class="container-fluid">
                <div class="d-flex justify-content-center">
                   <div class="col-md-12">
                      <div class="form-group">
                              <label>@lang('Your Referral Link')</label>
                              <div class="input-group">
                                  <input type="text" value="{{ route('user.refer.register',$user->username) }}"
                                  class="form-control form-control-lg" id="referralURL"
                                  readonly>
                                      <div class="input-group-append copytextDiv">
                                          <span class="input-group-text copytext" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                                      </div>
                              </div>
                      </div>
                </div>
              </div>
     <div class="row"> 
    <div class="d-flex justify-content-center">
            <div class="col-md-9 mb-30">
                <div class="card table-card">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm">
                          <div class="d-flex justify-content-center">
                             <strong> Your All Referral Details is provided below</strong>
                            </div>
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                  <th>@lang('Sr.')</th>
                                    <th>@lang('Full Name')</th>
                                    <th>@lang('User Name')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Mobile')</th>
                                    <th>@lang('Date & Time')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($refUsers) >0)
                                    @forelse($refUsers as $k=>$log)
                                    <tr>
                                      <td data-label="@lang('Full Name')">{{ $k+1 }}</td>
                                        <td data-label="@lang('Full Name')">{{ __($log->fullname) }}</td>
                                        <td data-label="@lang('User Name')">{{ __($log->username) }}</td>
                                        <td data-label="@lang('Email')">{{ $log->email }}</td>
                                        <td data-label="@lang('Phone')">{{ $log->mobile }}</td>
                                        <td data-label="@lang('Plan')">{{ $log->created_at->format('d-m-y & h:i:s:A')  }}</td>
                                    </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="100%" class="text-center"> @lang('No results found')!</td>
                                            </tr>
                                        @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{$refUsers->links($activeTemplate.'paginate')}}
            </div>
        </div>
</section>
@endsection
@push('style')
<style type="text/css">
    .copytextDiv{
        border:1px solid #0000007a;
        cursor: pointer;
    }
    #referralURL{
        border-right: 1px solid #0000007a;
    }
    .bg-success-custom{
        background-color: #28a7456e!important;
    }
    .brd-success-custom{
        border: 1px dashed #28a745;   
    }
</style>
@endpush
@push('script')
<script type="text/javascript">
    (function ($) {
        "use strict";
        $('#copyBoard').click(function(){
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
        });
    })(jQuery);
</script>
@endpush