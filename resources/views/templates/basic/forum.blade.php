@extends($activeTemplate.'layouts.frontend')
@section('content')

<div class="forum-block">
    <div class="forum-block__header">
        <h4 class="forum-block__title">{{ __($forum->name) }}</h4>
    </div>
<div class="forum-block__body">

    @forelse($forum->category()->latest()->get() as $cat)
    <div class="single-thread">
        <div class="single-thread__left">
        <h5 class="single-thread__title">
            <a href="{{ route('category.post', ['slug'=>slug($cat->name), 'id'=>$cat->id]) }}">
                {{ __($cat->name) }}
            </a>
        </h5>
        <p class="mt-2">
            {{ __($cat->description) }}
        </p>
        <div class="d-flex flex-wrap fs--12px mt-2">
            <strong>@lang('Sub Forum'): </strong> &nbsp;
            <ul class="sub-forum-list d-flex flex-wrap align-items-center">
                <li>
                    @php
                        $subCatId = [];
                    @endphp

                    @foreach($cat->subCategory as $subCat)
                        @php
                            $subCatId[] = $subCat->id;
                        @endphp
                        <a href="{{ route('sub.category.post', ['slug'=>slug($subCat->name), 'id'=>$subCat->id]) }}">
                            {{ $subCat->name }}
                        </a>
                        {{ $loop->last ? '. ' : ', ' }}
                    @endforeach
                </li>
            </ul>
        </div>
        </div>
        <div class="single-thread__right">
        <div class="top">
            <ul class="top__list">
          
              
            </ul>
        </div>

        @php
        $latestTitle = null;
        $latestId = null;
        $latestUser = null;

        $latestTopic = $cat->topics()->whereHas('subCategory', function($subCat){
            $subCat->where('status', 1)->whereHas('category', function($cat){
                $cat->where('status', 1);
            });
        })->latest()->first();

        if($latestTopic){
            $latestTitle = $latestTopic->post_title;
            $latestId = $latestTopic->id;
            $latestUser = $latestTopic->user;
        }
        @endphp
        <div class="bottom">
            <span class="fs--14px mb-2">@lang('Latest Topic')</span>
            <div class="latest-topic">
            <div class="latest-topic__thumb">
            @if($latestUser)
                <a href="{{ route('user', ['slug'=>$latestUser->slug]) }}">
                    <img src="{{ $latestUser->photo }}" alt="@lang('image')">
                </a>
            @endif
            </div>
            <div class="latest-topic__content">
                <h6 class="latest-topic__title">
                <a href="{{ $latestId ? route('post.details', ['slug'=>slug($latestTitle), 'id'=>$latestId]) : '#0' }}">
                    {{ __($latestTitle) }}
                </a>
                </h6>
            </div>
            </div>
        </div>
        </div>
    </div>

    @empty
    <h6 class="text-center single-">@lang('Data Not Found')!</h6>
    @endforelse

</div>
</div>

@endsection
