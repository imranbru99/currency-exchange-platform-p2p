@extends($activeTemplate.'layouts.frontend')
@section('content')

<div class="row align-items-center mb-4">
  <div class="col-lg-6">
    <h3>{{ __($pageTitle) }}</h3>
  </div>
  <div class="col-lg-6 text-end">
    <a href="{{ route('user.post.form') }}" class="btn btn--gradient">@lang('Create Post')</a>
  </div>
</div>

@forelse($posts as $post)
  <div class="single-post">
    <span class="forum-badge">
        {{ __($post->subCategory->name) }}
    </span>
    <div class="single-post__thumb">
    <a href="{{ route('user', ['slug'=>$post->user->slug]) }}">
      <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. @$post->user->image,imagePath()['profile']['user']['size']) }}" alt="@lang('image')">
    </a>
    </div>
    <div class="single-post__content">
      <h3 class="single-post__title">
          <a href="{{ route('post.details', ['slug'=>slug($post->post_title), 'id'=>$post->id]) }}">
            {{ __($post->post_title) }}
        </a>
    </h3>
      <ul class="single-post__meta d-flex align-items-center mt-1">
        <li>
            @lang('Post By')
            <i class="las la-user"></i>
            <a href="{{ route('user', ['slug'=>$post->user->slug]) }}">
                {{ __($post->user->fullname) }}
            </a>
        </li>
        <li><i class="las la-clock"></i> {{ $post->created_at->diffforhumans() }}</li>
      </ul>
    </div>
    <div class="single-post__footer">
      <p class="mt-3">{{ shortDescription(__($post->description), 400) }}</p>

      <div class="single-post__action-list d-flex flex-wrap align-items-center mt-3">
        <ul class="left">
          <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Up Vote')">
            <a href="{{ route('post.details', ['slug'=>slug($post->post_title), 'id'=>$post->id]) }}" class="text--success c-none">
              <i class="las la-arrow-up text--success"></i>
              {{ $post->up_vote }}
            </a>
          </li>
          <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Down Vote')">
            <a href="{{ route('post.details', ['slug'=>slug($post->post_title), 'id'=>$post->id]) }}" class="c-none">
              <i class="las la-arrow-down"></i>
              {{ $post->down_vote }}
            </a>
          </li>
        </ul>
        <ul class="right">
          <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Total Views')">
            <a href="{{ route('post.details', ['slug'=>slug($post->post_title), 'id'=>$post->id]) }}" class="c-none">
            <i class="las la-eye"></i>
              {{ $post->view }} @lang('Views')
          </a>
        </li>
          <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Total Comments')">
            <a href="{{ route('post.details', ['slug'=>slug($post->post_title), 'id'=>$post->id]) }}">
            <i class="las la-comments"></i>
              {{ $post->comment }} @lang('Comments')
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div><!-- single-post end -->
@empty
  <div class="single-post text-center d-block">
    @lang('Data Not Found')!
  </div>
@endforelse

<div class="mt-5">
  <ul class="pagination pagination-md justify-content-end">
    {{ paginateLinks($posts) }}
  </ul>
</div>

@if(request()->title)
    @php
        $url = url()->current() . '?' . http_build_query(['title' =>slug(request()->title)]);
    @endphp

    @push('script')
    <script>
        window.history.pushState('', '', '{{ $url }}');
    </script>
    @endpush
@endif

@endsection

