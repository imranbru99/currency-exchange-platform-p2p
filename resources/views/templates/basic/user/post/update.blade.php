@extends($activeTemplate.'layouts.master')


@section('content')
<div class="container">
  <div class="row justify-content-center">

        <div class="col-xl-9 mt-xl-0 mt-5">
          <div class="custom--card">
            <div class="forum-block__header">
              <h6 class="forum-block__title">{{ __($pageTitle) }}</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('user.post.update') }}">
                  <div class="row">
                    @csrf

                    <input type="hidden" name="id" value="{{ $post->id }}">

                    <div class="form-group col-lg-12">
                      <label for="sub_category">@lang('Public Community')</label>
                      <select id="sub_category" name="sub_category" class="form--control select2-basic" required="">
                        <option>---@lang('Select Category')---</option>
                        @foreach($subCategories as $subCat)
                            <option value="{{ $subCat->id }}" {{ $subCat->id == $post->sub_category_id ? 'selected' : '' }}>
                              {{ __($subCat->name) }}
                          </option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group col-lg-12">
                      <label for="title">@lang('Post Title')</label>
                      <input type="text" name="title" id="title" class="form--control" required=""
                      oninput="carRemaining('titleSpan', this.value, 191)" value="{{ $post->post_title }}">
                        <span id="titleSpan" class="remaining">
                            <span class="charTitle">191</span> @lang('characters remaining')
                        </span>
                    </div>
                      <div class="form-group col-lg-12">
                      <label for="des">@lang('Description')</label>
                      <textarea name="des" id="des" class="form--control" required="" oninput="carRemaining('desSpan', this.value, 64000)">{{ $post->description }}</textarea>
                      <span id="desSpan" class="remaining">
                          <span class="charDes">64000</span> @lang('characters remaining')
                      </span>
                  </div>
<div class="form-group col-lg-12">
                    <label for="tags">@lang('Tags')</label>
                    <select class="js-example-tokenizer form--control select2-basic tags" name="tags[]" multiple="multiple"></select>
</div>
                  <div class="form-group col-lg-12">
                      <label for="des">@lang('Description')</label>
                      <textarea name="des" id="des" class="form--control" required="" oninput="carRemaining('desSpan', this.value, 64000)">{{ $post->description }}</textarea>
                      <span id="desSpan" class="remaining">
                          <span class="charDes">64000</span> @lang('characters remaining')
                      </span>
                  </div>

                    <div class="form-group col-lg-12 text-center">
                        <button type="submit" class="btn bg-primary text-white">@lang('Update Topic')</button>
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

    let titleLength = parseInt({{ strlen($post->post_title) }});
    $('.charTitle').text(191-titleLength);

    let desLength = parseInt({{ strlen($post->description) }});
    $('.charDes').text(64000-desLength);

    let select = $('.tags');
    let tags = @json(json_decode($post->tags, true));
    let $newTag = '';

    for(let i = 0; i < tags.length; i++) {
        select.append(
            $(`<option selected>`).val(tags[i]).text(tags[i])
        )
    }

    // select.append($newTag);

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


