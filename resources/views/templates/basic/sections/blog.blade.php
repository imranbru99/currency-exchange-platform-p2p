@php

    $blog = getContent('blog.content',true);

    $blogs = getContent('blog.element',false);
@endphp

    <!--=======BLog-Section Starts Here=======-->
    <section class="blog-section padding-bottom padding-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-header">
                       
                    <h3 class="title">{{trans($blog->data_values->heading)}}</h3>
                        <p>
                            {{trans($blog->data_values->sub_heading)}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-30-none">
         
                @foreach($blogs as $blog)
                        <div class="col-md-6 col-xl-4 col-sm-10">
                            <div class="post-item">
                                <div class="post-thumb c-thumb">
                                    <a href="{{route('blog.details',['id'=>$blog->id,'slug'=>slug($blog->data_values->title)])}}">
                                        <img src="{{getImage('assets/images/frontend/blog/'.$blog->data_values->blog_image,'400x400')}}" alt="@lang('blog')">
                                    </a>
                                </div>
                                <div class="post-content">
                                    <div class="blog-header">
                                        <h6 class="title">
                                            <a href="{{route('blog.details',['id'=>$blog->id,'slug'=>slug($blog->data_values->title)])}}">
                                                {{__($blog->data_values->title)}}
                                            </a>
                                        </h6>
                                    </div>
                                    <div class="meta-post">
                                        <div class="date">
                                            <a href="#0">
                                                <i class="far fa-calendar-alt"></i>
                                                {{$blog->created_at->format('M d, Y')}}
                                            </a>
                                        </div>
                                        <div class="comment">
                                            <a href="#0">
                                                <i class="far fa-user"></i>
                                                @lang('Created By Admin')
                                            </a>
                                        </div>
                                    </div>
                                    <div class="entry-content">
                                      {{__(shortDescription($blog->data_values->short_details,100))}}
                                    </div>
                                </div>
                            </div>
                        </div>
            
                    @if(request()->is('/'))
                        @if($loop->iteration >= 3 )
                            @break
                        @endif
                    @endif

                @endforeach
            </div>
        </div>
        
    </section>
    <!--=======BLog-Section Ends Here=======-->

    @push('style')
        <style>
            .nowrap{
                white-space: nowrap;
            }
        </style>
    @endpush