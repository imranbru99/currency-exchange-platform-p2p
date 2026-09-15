 @php
     $policy = getContent('policy.content',true);

 @endphp
 <!--=======Privacy-Section Starts Here=======-->
    <section class="privacy-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="privacy-content">
                        <div class="main-item">
                            <div class="privacy-thumb">
                            <img src="{{asset('assets/images/frontend/policy/'.$policy->data_values->image)}}" alt="privacy">
                            </div>
                        <h4 class="title">{{__($policy->data_values->title)}}</h4>
                        </div>
                        <div class="item">
                            <?= __($policy->data_values->description) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=======Privacy-Section Ends Here=======-->
