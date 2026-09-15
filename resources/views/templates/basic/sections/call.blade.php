@php
    $call = getContent('call.content',true);    
@endphp
<!--=======Call-Section Starts Here=======-->
<section class="call-action padding-top padding-bottom bg-overlay bg_fixed bg_img"
data-background="{{getImage('assets/images/frontend/call/'.$call->data_values->image,'1920x400')}}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-header mb-0 text-white">
                <h2 class="title text-white">{{__($call->data_values->heading)}}</h3>
                        <p>
                            {{__($call->data_values->sub_heading)}}
                        </p>
                    <a href="{{$call->data_values->button_url}}" class="custom-button mt-30" data-text="{{$call->data_values->button_text}}">
                            @php
                                $a =  str_split($call->data_values->button_text);
                            @endphp

                            @foreach($a as $b)
                                <span>{{$b}}</span>
                            @endforeach
                        </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=======Call-Section Ends Here=======-->