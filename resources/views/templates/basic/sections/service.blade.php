@php
    $content = getContent('service.content',true);
    $elements = getContent('service.element',false);
@endphp


    <!--=======Service-Section Starts Here=======-->
    <section class="service-section padding-bottom padding-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-header">
                       
                    <h3 class="title">{{__($content->data_values->heading)}}</h3>
                        <p>
                            {{__($content->data_values->sub_heading)}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="service-slider">
                <div class="swiper-wrapper mb-30-none">
                    @foreach($elements as $element)
                        <div class="swiper-slide">
                        <div class="service-item">
                            <div class="service-thumb">
                            @php
                                echo $element->data_values->service_icon;
                            @endphp
                            </div>
                            <div class="service-content">
                            <h5 class="title">{{__($element->data_values->title)}}</h5>
                                <p>
                                    {{__($element->data_values->description)}}
                                    
                                </p>
                           
                            </div>
                        </div>
                    </div>
                    @endforeach
        
                </div>
            </div>
            <div class="common-pagination"></div>
        </div>
    </section>
    <!--=======Service-Section Ends Here=======-->