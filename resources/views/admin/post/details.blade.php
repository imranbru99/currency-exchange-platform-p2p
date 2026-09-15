@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body">

                   <div class="row form-group">
                        <div class="col-lg-12 form-group">
                            <h6 class="d-inline">@lang('Category'): </h6>
                            <span>{{ __($post->subCategory->category->forum->name) }}</span>
                        </div>
                        <div class="col-lg-12 form-group">
                            <h6 class="d-inline">@lang('Category'): </h6>
                            <span>{{ __($post->subCategory->category->name) }}</span>
                        </div>
                        <div class="col-lg-12 form-group">
                            <h6 class="d-inline">@lang('Sub Category'): </h6>
                            <span>{{ __($post->subCategory->name) }}</span>
                        </div>
                        <div class="col-lg-12 form-group">
                            <h6 class="d-inline">@lang('Post By'): </h6>
                            <span>{{ __($post->user->fullname) }}</span>
                        </div>
                        <div class="col-lg-12 form-group">
                            <h6 class="d-inline">@lang('Created At'): </h6>
                            <span>{{ showDateTime($post->create_at) }}</span>
                        </div>
                        <div class="col-lg-12 form-group">
                            <h6 class="d-inline">@lang('Topic Title'): </h6>
                            <span>{{ __($post->post_title) }}</span>
                        </div>
                        <div class="col-lg-12 form-group">
                            <h6 class="d-inline">@lang('Description'): </h6>
                            <span>{{ __($post->description) }}</span>
                        </div>
                        <div class="col-lg-12 form-group">
                            <h6 class="d-inline">@lang('Views'): </h6>
                            <span>{{ $post->view }} @lang('Times')</span>
                        </div>
                        <div class="col-lg-12 form-group">
                            <h6 class="d-inline">@lang('Reactions'): </h6>
                            <span>@lang('Up Vote') {{ $post->up_vote }}</span>
                            <span>@lang('Down Vote') {{ $post->down_vote }}</span>
                        </div>
                        <div class="col-lg-12 form-group">
                            <h6 class="d-inline">@lang('Comments'): </h6>
                            <span>{{ $post->comment }}</span>
                        </div>
                   </div>

                </div>
            </div>
        </div>

    </div>

@endsection
