@if(\App\Models\Extension::where('act', 'custom-captcha')->where('status', 1)->first())
        <div class="form-group col-md-6">
            <label for="pass01">@lang('Your Captcha')</label>
                @php echo  getCustomCaptcha() @endphp
        </div>
        <div class="form-group col-md-6">
             <label for="pass01">@lang('Enter Captcha')</label>
            <input type="text" name="captcha" class="form-control" placeholder="@lang('Enter Code')" class="form-control" autocomplete="off">
        </div>
   
@endif
