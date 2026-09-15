@extends($activeTemplate.'layouts.exchange')
@section('content')
@php
    $socials = getContent('social_icon.element',false);
@endphp
    <!--=======Blog-Section Starts Here=======-->
    <section class="blog-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <article>
                        <div class="post-item post-classic post-details">
                            <div class="post-thumb c-thumb w-100">
                                <img src="{{getImage('assets/images/frontend/blog/'.$blog->data_values->blog_image,'600x400')}}" alt="blog">
                            </div>
                            <div class="post-content">
                                <div class="blog-header">
                                    <h4 class="title">
                                       {{$blog->data_values->title}}
                                    </h4>
                                </div>
                                <div class="meta-post">
                                    <div class="date">
                                        <a href="javascript:void(0)">
                                            <i class="far fa-calendar-alt"></i>
                                            {{$blog->created_at->format('d M Y')}}
                                        </a>
                                    </div>
                                    <div class="comment">
                                        <a href="javascript:void(0)">
                                            <i class="far fa-user"></i>
                                            @lang('Created By Admin')
                                        </a>
                                    </div>

                                    <div class="comment">
                                        <a href="javascript:void(0)">
                                            <i class="far fa-user"></i>
                                            @lang('Total View :'.' '. $blog->clicks)
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    
                                    <?= $blog->data_values->description_nic ?>
                                    
                                    
                                    <div class="tag-options">
                                        <div class="tags">
                                            <span><i class="fas fa-tag"></i></span>
                                            <a href="#0">@lang('Created By Admin')</a>
                                        </div>
                                        <div class="share">
                                            <span><i class="fas fa-share-alt"></i></span>
                                    @foreach($socials as $social)
                                        @if($social->data_values->title == 'facebook')
                                            <a href="{{$social->data_values->url.'sharer/sharer.php?u='.urlencode(url()->current())}}" class="{{$social->data_values->title}}">
                                            @php
                                                echo $social->data_values->social_icon;
                                            @endphp  
                                        </a>
                                        @elseif($social->data_values->title == 'twitter')
                                            <a href="{{$social->data_values->url.'intent/tweet?text=blog;url='.urlencode(url()->current())}}" class="{{$social->data_values->title}}">
                                            @php
                                                echo $social->data_values->social_icon;
                                            @endphp 

                                        @elseif($social->data_values->title == 'linkdin')
                                                <a href="{{$social->data_values->url.'shareArticle?mini=true&amp;url='.urlencode(url()->current())}}" class="{{$social->data_values->title}}">
                                            @php
                                                echo $social->data_values->social_icon;
                                            @endphp 
                                        @endif
                                    @endforeach
                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
           
        </div>
    </section>
    <!--=======Blog-Section Ends Here=======-->


   
@endsection


@push('fb-comment')
    @php echo loadFbComment() @endphp
@endpush