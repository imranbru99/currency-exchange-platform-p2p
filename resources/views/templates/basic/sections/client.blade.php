    @php
        $content= getContent('client.content',true);
        $client= getContent('client.element',false);

       
    @endphp
    <!--=======Client-Section Starts Here=======-->
    <section class="client-section padding-bottom padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="section-header left-style">
                        
                    <h3 class="title">{{__($content->data_values->heading)}}</h3>
                        <p>
                            {{__($content->data_values->sub_heading)}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="client-slider">
                <div class="swiper-wrapper">
                 @foreach ($client as $cli )
                      <div class="swiper-slide">
                        <div class="client-item">
                            <div class="client-thumb">
                                
                                <div class="content">
                                <h6 class="title">{{$cli->data_values->name}}</h6>
                                <span>{{$cli->data_values->designation}}</span>
                                </div>
                            </div>
                            <div class="client-content">
                                <blockquote>
                                   {{__($cli->data_values->description)}}
                                </blockquote>
                            </div>
                        </div>
                    </div> 
                 @endforeach
                  
                </div>
            </div>
            <div class="common-pagination"></div>
        </div>
    </section>
    <!--=======Client-Section Ends Here=======-->