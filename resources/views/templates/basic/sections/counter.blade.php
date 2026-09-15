@php
    $content =  getContent('counter.content',true);
    $elements = getContent('counter.element');

@endphp


    <!--=======Counter-Section Starts Here=======-->
    <div class="counter-section padding-top padding-bottom bg-overlay bg_fixed bg_img"
data-background="{{getImage('assets/images/frontend/counter/'.$content->data_values->background_image,'1920x400')}}">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                @foreach($elements as $element )
                <div class="col-lg-3 col-sm-6">
                    <div class="counter-item">
                        <div class="counter-header">
                        <h4 class="title odometer" data-odometer-final="{{$element->data_values->counter_digit}}">0</h4>
                            <h4 class="title">@lang('k')</h4>
                        </div>
                        <div class="counter-content">
                            <h6 class="subtitle">{{__($element->data_values->title)}}</h6>
                        </div>
                        <div class="icon">
                            @php
                                echo $element->data_values->counter_icon;
                            @endphp
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!--=======Counter-Section Ends Here=======-->
