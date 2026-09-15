@php
$affiliate = getContent('affiliation.content',true);


$refferals = App\Models\Refferal::get(['level','percent']);

@endphp
<!--=======Service-Section Starts Here=======-->
<section class="affiliate-section padding-bottom padding-top">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-8">
                <div class="section-header">
                    <span class="cate">@lang('affiliate programe')</span>
                    <h2 class="title">{{ __($affiliate->data_values->heading) }}</h2>
                    <p>
                        {{ trans($affiliate->data_values->sub_heading) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
       
            @foreach ($refferals as $refferal)
                <div class="col-lg-6 col-md-10">
                    <div class="affiliate-item">
                        <div class="affiliate-thumb">
                            <span class="cate">@lang('LEVEL') {{$refferal->level}}</span>
                            <h6 class="title text-white">{{$refferal->percent}}%</h6>
                        </div>
                        <div class="affiliate-content">
                           {{trans($affiliate->data_values->description)}}
                        </div>
                    </div>
                </div>
            @endforeach
       



        </div>
    </div>
</section>
<!--=======Service-Section Ends Here=======-->

