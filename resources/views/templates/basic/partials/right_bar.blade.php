@php
  $register = getContent('register.content', true);
  $forums = App\Models\Forum:: get();
@endphp

<aside class="xxxl-2 col-lg-3 d-lg-block d-none">

@guest
    <div class="rounded-3 bg--gradient p-4 text-center mb-4">
        <h3 class="fw-normal text-white">@lang('JOIN OUR COMMUNITY')</h3>
        <p class="text-white fs--14px mt-3">{{ __(@$register->data_values->text) }}</p>
        <a href="{{ route('user.register') }}" class="btn btn--base mt-4">@lang('Registration Now')</a>
        <a href="{{ route('faq') }}" class="btn btn--base mt-2">@lang('Read FAQ')</a>
        <a href="{{ route('how') }}" class="btn btn--base mt-2">@lang('How it works')</a>
    </div>
@endguest

<div class="rounded-3 bg--info p-4 text-center mb-4">
  <p class="text-white fs--14px mt-3">	
    
    ***আমাদের ওয়েবসাইটে কোন ধরণের সমস্যা নাই  অর্ডার করতে পারেন নিশ্চিন্তে।। মনে রাখবেন অর্ডার সম্পুর্ণ  হতে ৫ মিনিট সময় লাগে ভবিষ্যাৎেও  পাবেন ৫ মিনিটের মধ্যে  ইনশাআল্লাহ কোন টেকনিক্যাল কারণে লেট হলে আন্তরিকাবে দুঃখীত  তবে আপনার এক্সচেন্জ এর পেমেন্ট সর্বোচ্চ ৫ ঘন্টার মধ্যে পাবেন ইনশাআল্লাহ ১০০% নিশ্চিত থাকুন। দয়াকরে আমাদের জন্য দোআ করবেন
  
  </p></div>

  <div class="sidebar-widget">
    <div class="sidebar-widget__header">
      <h5 class="sidebar-widget__title">@lang('Statistics')</h5>
    </div>
    <div class="sidebar-widget__body">
      <ul class="statistics-list">
        <li class="single-stat">
            <h3 class="single-stat__number">{{ $forum }}</h3>
            <span class="single-stat__caption fs--14px">@lang('Forum')</span>
        </li>
        <li class="single-stat">
          <h3 class="single-stat__number">{{ $category }}</h3>
          <span class="single-stat__caption fs--14px">@lang('Category')</span>
        </li>
        <li class="single-stat">
          <h3 class="single-stat__number">{{ $subCategory }}</h3>
          <span class="single-stat__caption fs--14px">@lang('Sub Category')</span>
        </li>
        <li class="single-stat">
            <h3 class="single-stat__number">{{ $post }}</h3>
            <span class="single-stat__caption fs--14px">@lang('Topic')</span>
        </li>
      </ul>
    </div>
  </div><!-- sidebar-widget end -->

  <div class="rounded-3 bg--gradient p-4 text-center mb-4">
    <p class="text-white fs--14px mt-3">	</p>
  </div>
  

  <div class="sidebar-widget">
    <div class="sidebar-widget__header">
      <h5 class="sidebar-widget__title">@lang('Forum')</h5>
    </div>
    <div class="sidebar-widget__body">
      <ul class="category-list">
        @foreach($forums as $forum)
          <li>
            <a href="{{ route('forum', ['slug'=>slug($forum->name), 'id'=>$forum->id]) }}">
              @php echo $forum->icon; @endphp
              {{ __($forum->name) }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </div><!-- sidebar-widget end -->
 

  <div class="sidebar-widget mt-4">
    <div class="sidebar-widget__header">
      <h5 class="sidebar-widget__title">@lang('Hot Topics')</h5>
    </div>
    <div class="sidebar-widget__body">
      <ul class="topic-list">
      @foreach($hots as $hot)
        <li class="single-topic">
          <div class="single-topic__thumb">
                <img src="{{ $hot->post->user->photo }}" alt="@lang('image')">
            </a>
          </div>
          <div class="single-topic__content">
            <h6 class="single-topic__title">
                <a href="{{ route('post.details', ['slug'=>slug($hot->post->post_title), 'id'=>$hot->post_id]) }}">
                    {{ __($hot->post->post_title) }}
                </a>
            </h6>
            <span class="fs--12px"><i class="las la-calendar fs--14px"></i> {{ showDateTime($hot->post->cretaed_at, 'd/m/Y') }}</span>
          </div>
        </li>
      @endforeach

      </ul>
    </div>
  </div><!-- sidebar-widget end -->
</aside>
