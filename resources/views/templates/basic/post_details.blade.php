@extends($activeTemplate.'layouts.frontend')
@section('content')

<div class="post-details">
  <span class="post-details__badge">{{ __($post->subCategory->name) }}</span>
  <h3 class="post-details__title">{{ __($post->post_title) }}</h3>
  <div class="d-flex flex-wrap justify-content-between">
    <ul class="post-details__tags mt-2">
      @foreach(json_decode($post->tags, true) as $tag)
     <li>
         <span>{{ __($tag) }}</span>
     </li>
      @endforeach
    </ul>
    <ul class="post-details__social d-flex flex-wrap align-items-center mt-2">
      <li class="caption">@lang('Share')</li>
      <li>
        <a href="https://www.facebook.com/sharer/sharer.php?{{ url()->current() }}" target="_blank">
          <i class="lab la-facebook-f"></i>
        </a>
      </li>
      <li>
        <a href="https://twitter.com/home?{{ url()->current() }}" target="_blank">
          <i class="lab la-twitter"></i>
        </a>
      </li>
      <li>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}" target="_blank">
          <i class="lab la-linkedin-in"></i>
        </a>
      </li>
    </ul>

  </div>
  <div class="single-post__action-list d-flex flex-wrap align-items-center mt-3">

      <ul class="left">
        <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('Positive Vote')">
          <a href="{{ Auth::user() ? 'javascript:void(0)' : route('user.login') }}" class="text--success reactBtn" data-value="1" data-id="{{ $post->id }}">
            <i class="las la-arrow-up text--success"></i>
            <span class="upVote">{{ $post->up_vote }}</span>
          </a>
        </li>

        <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('Negative Vote')">
          <a href="{{ Auth::user() ? 'javascript:void(0)' : route('user.login') }}" class="reactBtn" data-value="0" data-id="{{ $post->id }}">
            <i class="las la-arrow-down"></i>
            <span class="downVote">{{ $post->down_vote }}</span>
          </a>
        </li>
      </ul>


    <ul class="right">
      <li data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="@lang('Total Views')">
        <a href="javascript:void(0)" class="c-none"><i class="las la-eye"></i>
          {{ $post->view }} @lang('Views')
        </a>
      </li>
      <li data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="@lang('Total Comments')">
        <a href="javascript:void(0)">
          <i class="las la-comments"></i>
        <span class="commentArea">{{ $post->comment }}</span> @lang('Comments')
      </a>
      </li>
    </ul>
  </div>

  <div class="post-author mt-5">
    <div class="post-author__thumb">
        <a href="{{ route('user', ['slug'=>$post->user->slug]) }}">
            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. @$post->user->image,imagePath()['profile']['user']['size']) }}" alt="@lang('image')">
        </a>
    </div>
    <div class="post-author__content">
      <h6 class="post-author__name">
        <a href="{{ route('user', ['slug'=>$post->user->slug]) }}">
          {{ __($post->user->fullname) }}
        </a>
        </h6>
      <ul class="post-author__meta d-flex align-items-center fs--14px">
        <li>@lang('Post By') <i class="las la-user"></i> {{ __($post->user->fullname) }}</li>
        <li><i class="las la-clock"></i> {{ $post->created_at->diffforhumans() }}</li>
      </ul>
      <p class="mt-3">{{ __($post->description) }}</p>
    </div>
  </div>
</div><!-- post-details end -->

<div class="comment-wrapper mt-4">
  @if($user)
    <div class="comment-wrapper__thumb">
      <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. @$user->image,imagePath()['profile']['user']['size']) }}" alt="@lang('image')">
    </div>
  @endif


  @auth
    <div class="comment-wrapper__content">
        <form method="post" class="commentForm" action="{{ route('user.comment') }}">
        @csrf
            <input type="hidden" name="id" required="" value="{{ $post->id }}">
            <textarea class="form--control" required="" name="comment" oninput="carRemaining('commentSpan', this.value, 60000)"></textarea>
            <span id="commentSpan" class="remaining">
                60000 @lang('characters remaining')
            </span>
            <input type="submit" class="btn btn--gradient mt-3" value="@lang('Post Your Comment')">
        </form>
    </div>
  @else
    <div class="comment-wrapper__content ps-0 text-center">
        <a href="{{ route('user.login') }}" class="btn btn--gradient mt-3">@lang('Login To Post Your Comment')</a>
    </div>
  @endif

</div>

<div class="comment-area mt-5">
  <h3 class="mb-3"><span class="totalComment">{{ $post->comment }}</span> @lang('comments')</h3>

  @php
    $lastId = 0;
  @endphp

<div id="commentArea">
  @foreach($comments as $comment)
    @if($loop->first)
      @php
        $lastId = $comment->id;
      @endphp
    @endif
      <div class="single-comment">
        <div class="single-comment__thumb">
            <a href="{{ route('user', ['slug'=>$comment->user->slug]) }}">
                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. @$comment->user->image,imagePath()['profile']['user']['size']) }}" alt="image">
            </a>
        </div>
        <div class="single-comment__content">
         <h6>
             <a href="{{ route('user', ['slug'=>$comment->user->slug]) }}">
                 {{ __($comment->user->fullname) }}
             </a>
        </h6>
          <span class="fs--14px">{{ $comment->created_at->diffforhumans() }}</span>
        </div>
        <p class="mt-2 w-100">{{ __($comment->comment) }}</p>
      </div><!-- single-comment end -->
  @endforeach
  </div>

  @if($post->comment > 5)
    <div class="loadMore btn btn--base text-center mt-4" data-id="{{ $lastId }}" style='cursor: pointer;'>
      @lang('Load More')...
    </div>
  @endif

</div>

@endsection

@push('script-lib')
<script src="{{ asset('assets/common/custom.js') }}"></script>
@endpush


@auth

  @push('script')

    <script>
      (function ($) {
        "use strict";
        let btn = $('.reactBtn');
        btn.on('click', function(){
          let value = $(this).data('value');
          let postId = $(this).data('id');
             $.ajax({
                  url:"{{ route('user.reaction') }}",
                  method:'post',
                  data: {
                    '_token': '{{ csrf_token() }}',
                    'value': value,
                    'id': postId,
                  },
                  success:function(response){
                      if(response.success){
                        $('.upVote').text(response.up);
                        $('.downVote').text(response.down);
                        notify('success', response.message);
                      }else{
                          notify('error', response.message);
                          $.each(response.error, function(key, value) {
                              notify('error', value);
                          });
                      }
                  },
                  error:function(error){
                      console.log(error)
                  }
              });
        });
</script>
@endpush
@push('script')
<script>
        let commentForm = $('.commentForm');
        commentForm.on('submit', function(e){
          e.preventDefault();
          let data = commentForm.serialize();
             $.ajax({
                  url:"{{ route('user.comment') }}",
                  method:'post',
                  data: data,
                  success:function(response){
                      if(response.success){
                        commentForm.find('textarea[name=comment]').val('');
                        $('.commentArea').text(response.count);
                        $('.totalComment').text(response.count);
                        $('#commentSpan').text("60000 characters remaining");
                        let route = `{{ url('user') }}/${response.username}/${response.userId}`;
                        let newComment = $('#commentArea');
                        newComment.prepend(` 
                        <div class="single-comment">
                            <div class="single-comment__thumb">
                                <a href="${route}">
                                    <img src="${response.image}" alt="image">
                                </a>
                            </div>
                            <div class="single-comment__content">
                            <h6>
                                <a href="${route}">
                                    ${response.user}
                                </a>
                            </h6>
                            <span class="fs--14px">${response.created}</span>
                            </div>
                            <p class="mt-2 w-100">${response.comment}</p>
                        </div>
                        `);
                        notify('success', response.message);
                      }else{
                          $.each(response.error, function(key, value) {
                              notify('error', value);
                          });
                      }

                  },
                  error:function(error){
                      console.log(error)
                  }
              });
        });

        })(jQuery);
    </script>

@endpush

@endif


@push('script')
<script>
(function ($) {

  "use strict";

  let moreBtn = $('.loadMore');

  moreBtn.on('click', function(e){

    let lastId = $(this).data('id');

       $.ajax({
            url:"{{ route('more.comment') }}",
            method:'post',
            data: {
              '_token': '{{ csrf_token() }}',
              'id': lastId,
              'postId': '{{ $post->id }}',
            },
            success:function(response){

                if(response.success){

                  if(response.message == 400){
                    $('.loadMore').hide();
                  }

                  let more = $('#commentArea');

                  $.each(response.array, function(index, value){

                    if(index == 0){
                      $('.loadMore').data('id', value.id);
                    }

                    let route = `{{ url('user') }}/${value.user.username}/${value.user.id}`;

                    more.append(
                      <div class="single-comment">
                        <div class="single-comment__thumb">
                        <a href='${route}'>
                          <img src="${value.user.photo}" alt="image">
                        </a>
                        </div>
                        <div class="single-comment__content">
                          <h6>
                            <a href='${route}'>
                                ${value.user.firstname} ${value.user.lastname}
                            </a>
                          </h6>
                          <span class="fs--14px">${timeSince(value.created_at)}</span>
                        </div>
                        <p class="mt-2 w-100">${value.comment}</p>
                      </div>
                    `);

                  });


                }else{
                    $.each(response.error, function(key, value) {
                        notify('error', value);
                    });
                }

            },
            error:function(error){
                console.log(error)
            }
        });

  });

})(jQuery);
</script>
@endpush


@push('share')
<meta name="description" content="{{ $post->description }}">
<meta name="keywords" content="{{ implode(',', json_decode($post->tags, true)) }}">
<meta name="apple-mobile-web-app-title" content="{{ $post->post_title }}">
<meta itemprop="name" content="{{ $post->post_title }}">
<meta itemprop="description" content="{{ $post->description }}">
<meta property="og:title" content="{{ $post->post_title }}">
<meta property="og:description" content="{{ $post->description }}">
@endpush
