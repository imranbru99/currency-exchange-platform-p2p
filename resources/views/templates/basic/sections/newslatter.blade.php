@php
    $newsletter = getContent('newslatter.content',true);
@endphp
    <!--=======Newslater-Section Starts Here=======-->
    <section class="newsletter-section padding-top padding-bottom bg_img bg_fixed bg_overlay" data-background="{{asset('assets/images/frontend/newslatter/'.$newsletter->data_values->image_property)}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-header margin-olpo text-white">
                    <h3 class="title text-white">{{__($newsletter->data_values->heading)}}</h3>
                    <p>{{__($newsletter->data_values->sub_heading)}}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7">
                <form class="newslater-form" action="" method="POST">
                    @csrf
                        <input type="email" placeholder="@lang('Enter Your Email....')" name="email" required id="email">
                        <button type="submit" id="subscribe" class="h5 text-white">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--=======Newslater-Section Ends Here=======-->


    @push('style')
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <style>
            .newsletter-section{
                background:#13114a;
            }
        </style>
        
    @endpush


    @push('script')
        <script>
            'use strict';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(function(){
                $('#subscribe').on('click',function(e){
                    e.preventDefault();
                    var email = $('#email').val();
                    $.ajax({
                        method:'POST',
                        url:"{{route('subscribe')}}",
                        data:{email:email},
                        success:function(response){
                           
                            if(response.fails){
                                iziToast.error({
                                message: response.errorMsg.email,
                                position: "topRight"
                            });
                            }

                            if (response.success) {
                                iziToast.success({
                                message: response.successMsg,
                                position: "topRight"
                            });
                            }
                            
                            if (response.error) {
                                iziToast.error({
                                message: response.errorMsg,
                                position: "topRight"
                            });
                            }
                            
                            
                        }
                    });
                })
            })
        
        
        </script>        
    @endpush