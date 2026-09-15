@php
   
    $content = getContent('faq.content',true);
    $elements = getContent('faq.element',false);
@endphp


    <!--=======Faq-Section Starts Here=======-->
    <section class="faq-section padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 d-lg-block d-none rtl">
                <img src="{{getImage('assets/images/frontend/faq/'.$content->data_values->faq_image,'1920x400')}}" alt="@lang('faq')">
                </div>
                <div class="col-lg-7">
                    <div class="section-header left-style">
                       
                    <h3 class="title">{{__($content->data_values->heading)}}</h3>
                        <p>{{__($content->data_values->sub_heading)}}</p>
                    </div>
                    <div class="faq-wrapper mb--20">
                    @foreach($elements as $element)
                    <div class="faq-item {{$loop->iteration == 1 ? 'active open' : ''}}">
                            <div class="faq-title">
                            <h5 class="title">{{__($element->data_values->question)}}</h5>
                                <span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                
                                    @php
                                        echo __($element->data_values->answer)
                                    @endphp
                                
                                
                            </div>
                        </div>
                    @endforeach                       
                     
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=======Faq-Section Ends Here=======-->