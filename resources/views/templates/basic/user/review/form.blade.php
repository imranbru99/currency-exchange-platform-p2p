@extends($activeTemplate.'layouts.master')


@section('content')
<div class="container">
      <div class="row justify-content-center">
      <div class="col-xl-9 mt-xl-0 mt-5">
        <div class="custom--card">
          <div class="forum-block__header justify-content-between d-flex align-items-center">
            <h6 class="forum-block__title">{{ __($pageTitle) }}</h6>
           
          </div>
          <div class="card-body">
              <form method="post" action="{{ route('user.review.create') }}">
                <div class="row">
                  @csrf

                  <div class="row">
                    <label for="tags">@lang('Tags')</label>
                    <select class="js-example-tokenizer form--control select2-basic" name="tags[]" multiple="multiple" >
                      <option selected="selected">
                        Review
                        </option>
                    </select>
                  </div>

                  <div class="form-group col-lg-12">
                    <label for="sub_category">@lang('')</label>
                    <select id="sub_category" name="sub_category" class="form--control select2-basic" required="" >
                      <option value="" readonly>---@lang('Select Category')---</option>
                      @foreach($subCategories as $subCat)
                          <option value="{{ $subCat->id }}" selected readonly>{{ __($subCat->name) }}</option>
                      @endforeach
                    </select>
                  </div>

                  
                    
                  <div class="form-group col-lg-12">
                    <label for="title">@lang('Review Title')</label>
                    <input type="text" name="title" id="title" class="form--control" required=""
                    oninput="carRemaining('titleSpan', this.value, 191)" placeholder="One of The Best Exchange website in Bangladesh">
                      <span id="titleSpan" class="remaining">
                          191 @lang('characters remaining')
                      </span>
                  </div>
                  
                      <div class="form-group col-lg-12">
                    <label for="des">@lang('Description')</label>
                    <textarea name="des" id="des" class="form--control" required="" placeholder="I have order 2 minutes ago, Just Received the payment. What's the best exchange Website dtk is!" oninput="carRemaining('desSpan', this.value, 64000)"></textarea>
                      <span id="desSpan" class="remaining">
                          64000 @lang('characters remaining')
                      </span>
                  </div>
              
              

                  <div class="form-group col-lg-12 text-center">
                      <button type="submit" class="btn bg-primary text-white w-100">@lang('Publish Review')</button>
                  </div>

                </div>
              </form>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection

@push('script-lib')
    <script src="{{asset('assets/admin/js/vendor/select2.min.js')}}"></script>
    <script src="{{ asset('assets/common/custom.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{asset('assets/admin/css/vendor/select2.min.css')}}">
@endpush

@push('script')

<script>

  (function ($) {
    "use strict";

    $('.select2-basic').select2();

    $(".js-example-tokenizer").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    })

  })(jQuery);

</script>

@endpush

@push('style')
<style>
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 50px;
}
.select2-container--default .select2-selection--single {
    height: 50px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 14px;
}

</style>
@endpush


