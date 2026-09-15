 @php
     $missions = getContent('mission.element',false);
    
 @endphp
 <!--=======Mission-Vission-Section Ends Here=======-->
    <section class="overview-section">
        @foreach($missions as $mission)
            <div class="overview-item section-bg">
                <div class="container mw-lg-100 p-0">
                <div class="row m-0 {{$loop->iteration % 2 == 0 ? 'flex-row-reverse':'' }}">
                        <div class="col-lg-6 p-lg-0">
                            <div class="overview-contnent padding-bottom padding-top">
                                <div class="content">
                                    <div class="section-header left-style margin-olpo text-left">
                                    <h3 class="title">{{__($mission->data_values->heading)}}</h3>
                                        <p>
                                            {{__($mission->data_values->sub_heading)}}
                                        </p>
                                    </div>
                                    <?= $mission->data_values->description ?>
                                </div>
                            </div>
                        </div>
                    <div class="col-lg-6 p-lg-0 bg_img" data-background="{{asset('assets/images/frontend/mission/'.$mission->data_values->image)}}"></div>
                    </div>
                </div>
            </div>
        @endforeach

    </section>
    <!--=======Mission-Vission-Section Ends Here=======-->