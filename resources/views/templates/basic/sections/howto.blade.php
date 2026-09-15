    @php
        $content = getContent('howto.content',true);
        $elements = getContent('howto.element',false)->sort();
    @endphp
    <!--=======How-Section Starts Here=======-->
    <section class="how-section padding-top padding-bottom bg-overlay bg_fixed bg_img"
data-background="{{asset('assets/images/frontend/howto/'.@$content->data_values->background_image)}}">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                @foreach($elements as $element)
                    <div class="col-md-6 col-lg-4 col-sm-10">
                        <div class="how-item">
                            <div class="how-thumb">
                            @php
                                echo @$element->data_values->how_icon;
                            @endphp
                            </div>
                            <div class="how-content">
                            <h5 class="title">{{__($element->data_values->title)}}</h5>
                            </div>
                        </div>
                    </div>
               @endforeach
                
            </div>
        </div>
    </section>
    <!--=======How-Section Ends Here=======-->