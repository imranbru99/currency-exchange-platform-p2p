@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="pm-page-head">
    <span class="pm-kicker">@lang('Updates')</span>
    <h1>{{ __($pageTitle) }}</h1>
    <p>@lang('Official news, tutorials and exchange notices.')</p>
    <form class="pm-track-form mt-3" method="GET" action="{{ route('blog.search') }}">
        <input type="text" name="search" value="{{ request('search') }}" class="form--control" placeholder="@lang('Search news')">
        <button type="submit" class="btn btn--gradient">@lang('Search')</button>
    </form>
</div>

<div class="row g-4">
    @forelse($blogSearch as $blog)
        <div class="col-md-6">
            <article class="pm-card h-100 p-3">
                <a href="{{ route('blog.details', ['id'=>$blog->id, 'slug'=>slug($blog->data_values->title)]) }}">
                    <img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->blog_image,'600x400') }}" alt="blog">
                </a>
                <h3 class="mt-3">
                    <a href="{{ route('blog.details', ['id'=>$blog->id, 'slug'=>slug($blog->data_values->title)]) }}">
                        {{ $blog->data_values->title }}
                    </a>
                </h3>
                <p class="pm-muted">{{ $blog->created_at->format('M d, Y') }}</p>
                <p>{!! shortDescription($blog->data_values->description_nic, 150) !!}</p>
            </article>
        </div>
    @empty
        <div class="col-12">
            <div class="pm-card text-center">
                <h3>@lang('No articles found')</h3>
                <a class="btn btn--gradient mt-3" href="{{ route('blog') }}">@lang('Back to news')</a>
            </div>
        </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $blogSearch->withQueryString()->links() }}
</div>
@endsection
