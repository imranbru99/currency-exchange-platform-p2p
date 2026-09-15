@php
    $get = getContent('about.content',true);
@endphp

    <!--=======About-Section Starts Here=======-->
    <section class="about-section padding-top padding-bottom section-bg">
        <div class="container">
            <div class="row flex-wrap-reverse">
                <div class="col-lg-6">
                    <div class="section-header left-style margin-olpo text-left">
                        <span class="cate">@lang('about')</span>
                        <h3 class="title">{{trans($get->data_values->heading)}}</h3>
                        <p>
                            {{trans($get->data_values->sub_heading)}}
                        </p>
                    </div>
                    <div class="about-content">
                       <?=  trans($get->data_values->description) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-thumb">
                    <img src="{{getImage('assets/images/frontend/about/'.$get->data_values->about_image,'600x400')}}" alt="@lang('about')">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=======About-Section Ends Here=======-->