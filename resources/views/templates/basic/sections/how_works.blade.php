@php
    $content = getContent('how_works.content',true);
    $elements = getContent('how_works.element',false)->sort();
@endphp

<!--=======How-Join Starts Here=======-->
<section class="join-affiliate padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-header">
                <h2 class="title">{{trans($content->data_values->heading)}}</h3>
                        <p>
                            {{ trans($content->data_values->sub_heading)}}
                        </p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb--40">
            @foreach($elements as $element)
            <div class="col-lg-3 col-sm-6">
                <div class="join-item">
                    <div class="join-thumb">
                    <img src="{{asset('assets/images/frontend/how_works/'.$element->data_values->image)}}" alt="join">
                    </div>
                    <div class="join-content">
                    <h5 class="title">{{ trans($element->data_values->title)}}</h5>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
<!--=======How-Join Ends Here=======-->