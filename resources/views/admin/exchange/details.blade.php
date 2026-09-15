@extends('admin.layouts.app')
@section('panel')

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header bg--primary">
                    <h3 class="text-light">@lang('Transaction Details') </h3>
                </div>
                <div class="card-body">
                    
                    <div class="exchange-card mb-5">
                        <div class="right">

                            <fieldset>
                                <legend><h5 class="text-white">@lang('Received Details')</h5></legend>
                                <ul class="exchange-info-list">
                                    <li>
                                         <span class="caption">@lang('Exchange ID')</span>
                                         <span class="value">{{ $exchange->exchange_id }}</span>
                                        
                                    </li>
                                    <li>
                                            <span class="caption">@lang('Status')</span>
                                            <span class="value text--small badge font-weight-normal 
                                            @if ($exchange->status == 0) badge--danger @endif
                                            @if ($exchange->status == 1) badge--success @endif
                                            @if ($exchange->status == 2) badge--danger @endif
                                            @if ($exchange->status == 3) badge--danger @endif ">

                                            @if ($exchange->status == 0) 
                                                @lang('pending')
                                            @endif
                                            @if ($exchange->status == 1) 
                                                @lang('Approved')
                                            @endif
                                            @if ($exchange->status == 2) 
                                                @lang('cancle')
                                            @endif
                                            @if ($exchange->status == 3) 
                                                @lang('refunded')
                                            @endif

                                            </span>
                                    </li>
                                    
                                    <li>
                                        <span class="caption">@lang('User Name')</span>
                                        <span class="value"><a href="{{ route('admin.users.detail', $exchange->user->id) }}">{{ @$exchange->user->username }} </a> </span>
                                    </li>
                                    <li>
                                        <span class="caption">@lang('Received Gateway Name')</span>
                                        <span class="value">{{ @$exchange->payment_from_getway->name }}</span>
                                    </li>
                                    <li>
                                        <span class="caption">@lang('Received Currency')</span>
                                        <span class="value">{{@$exchange->payment_from_getway->cur_sym}}</span>
                                    </li>
                                    <li>
                                       <span class="caption">@lang('Received Amount')</span>
                                       <span class="value">{{ $exchange->get_amount }} {{ @$exchange->payment_from_getway->cur_sym  }}</span>
                                    </li>

                                    <li>
                                       <span class="caption">@lang('Total Charge')</span>
                                       <span class="value">{{ $exchange->charge }} {{ @$exchange->payment_from_getway->cur_sym  }}</span>
                                    </li>

                                    <li>
                                       <span class="caption">@lang('Buy rate')</span>
                                       <span class="value">{{ $exchange->buy_rate }} {{ $general->cur_sym  }}</span>
                                    </li>

                                    <li>
                                       <span class="caption">@lang('Transaction Time')</span>
                                       <span class="value">{{ $exchange->created_at->format('d M Y h:i:s') }} </span>
                                    </li>
                                </ul>
                            </fieldset>


                            <fieldset class="mt-3">
                                <legend><h5 class="text-white">@lang('Sending Details')</h5></legend>
                                <ul class="exchange-info-list">
                                    <li>
                                        <span class="caption"> @if($exchange->email == null)  @lang('Customer Wallet') @else @lang('Customer Email') @endif</span>
                                        <span class="value">{{ $exchange->email ?? $exchange->wallet_id }}</span>
                                    </li>
                                    <li>
                                        <span class="caption">@lang('Send Gateway Name')</span>
                                        <span class="value">{{ @$exchange->payment_to_getway->name  }}</span>
                                    </li>
                                    <li>
                                        <span class="caption">@lang('Send Amount')</span>
                                        <span class="value">{{ $exchange->send_amount }} {{ @$exchange->payment_to_getway->cur_sym  }}</span>
                                    </li>

                                   


                                    <li>
                                         <span class="caption">{{ @$exchange->payment_to_getway->name}} @lang('Transaction No.')</span>
                                        <span class="value">{{ $exchange->admin_trnx_no }}</span>
                                    </li>
                                    
                                </ul>
                            </fieldset>
                        </div>
                        {{-- End of Right section --}}

                <div class="left">

                    <fieldset>
                        <legend><h5 class="text-white">{{ @$exchange->payment_from_getway->name }} @lang('Transaction Proof Details.')</h5></legend>

                        <ul class="exchange-info-list">
                                    @if($exchange->user_proof != null)
                            @foreach (json_decode($exchange->user_proof) as $key=>$proof )
                           
                            @if(strpos($key, 'img_') !== false)
                              
                                <li class="d-block">
                                    <span class="caption d-block">{{strtoupper(str_replace('_',' ',substr($key,4)))}}</span>
                                    <span class="value d-block text-center image-click">
                                        <img src="{{asset(imagePath()['exchange']['path'].'/'.$proof)}}" alt="@lang('image')" width="200" class="">
                                    </span>
                                </li>
                             @continue
                            @endif
                            
                                <li class="">
                                    <span class="caption">{{strtoupper(str_replace('_',' ', $key))}}</span>
                                    <span class="value">{{$proof}}</span>
                                </li>
                           
                            @endforeach

                            @else

                                <li>
                                    <span class="caption">{{strtoupper(__('Autometic Payment Status'))}}</span>
                                    <span class="value badge  {{$exchange->autometic_payment_status == 1? ' badge--success' : 'badge--danger'}}">{{$exchange->autometic_payment_status == 1 ?  __('Autometic Payment Completed') : __('Not Completed')}}</span>
                                </li>

                            @endif




                             @if($exchange->status == 2)
                                    <li>
                                        <span class="caption">{{strtoupper(__('Reason Of Cancle: '))}}</span>
                                        <span class="value">{{$exchange->cancle_reason}}</span>
                                    </li>
                                    
                            @endif


                            @if($exchange->status == 3)
                                    <li>
                                        <span class="caption mb-2">{{strtoupper(__('Reason Of Refund: '))}}</span>
                                        <span class="value text-justify">{{$exchange->refund_reason}}</span>
                                    </li>

                            @endif

                            
                             @if($exchange->status == 0)

                                    <li>
                                        <span class="caption mb-2">@lang('Please send') {{ $exchange->send_amount }} {{ @$exchange->payment_to_getway->cur_sym }}  @lang('To') {{ @$exchange->payment_to_getway->name }} </span>
                                        <span class="value text-justify font-weight-bold">@lang('Wallet') : {{ $exchange->email ?? $exchange->wallet_id  }}</span>
                                    </li>

                            @endif

                                

                             @if($exchange->status == 1)

                                <li>

                                   
                                    <span class="bg--success text-center p-2 w-100">@lang('This Transaction is Successfully Paid')</span>
                                   <button type="submit" class="btn btn--danger">@lang('Cancle Transaction')</button>

                                </li>
                            @endif



                            @if($exchange->status == 2)
                        
                               <li class="">

                                   
                                    <span class="bg--danger text-center p-2 w-100">@lang('The Transaction is Cancled')</span>
                                    <button class="btn btn--primary form-control approve">@lang('Approve Transaction')</button>


                                </li>
                            @endif


                            @if($exchange->status == 3)
                                <li class="">
                                    
                                    <span class="bg--danger p-2">@lang('The Transaction Refunded with amount') {{number_format($exchange->refund_amount,2)}} {{ @$exchange->payment_from_getway->cur_sym }} @lang('by') {{@$exchange->payment_from_getway->name}}</span>
                                        <button class="btn btn--primary form-control approve">@lang('Approve Transaction')</button>     
                                </li>


                            @endif


                            @if($exchange->status == 0)
                                
                                <li>
                                    <span>
                                        <button class="btn btn--danger form-control cancle">@lang('Cancle Transaction')</button>
                                    </span>
                                    <span>
                                        <button class="btn btn--primary form-control approve">@lang('Approve Transaction')</button>
                                    </span>
                                    <span>
                                        <button class="btn btn--warning form-control refund">@lang('Refund Transaction')</button>
                                    </span>
                                </li>

                            @endif

                        </ul>


                            </fieldset>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    
    <!-- Cancle Modal -->
    <div class="modal fade" id="cancleModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg--primary">
                    <h5 class="modal-title text-light">@lang('Cancle Transaction')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                    <form action="{{route('admin.exchange.cancle',$exchange->id)}}" method="POST">
                         <div class="modal-body">
                            @csrf
                            <label for="">@lang('Reason of Cancalation')</label>
                              <input type="text" name="reasonOf_Cancle" id="" class="form-control" value="Not Completed" placeholder="@lang('Reason of Cancle')" aria-describedby="helpId">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                                <button type="submit" class="btn btn--danger">@lang('Cancle Transaction')</button>
                            </div>
                        </form>
            </div>
        </div>
    </div>


    
    <!-- Approved Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Approve Transaction')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            <form action="{{route('admin.exchange.approved', $exchange->id)}}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">@lang('Transaction Number')</label>
                            <input type="text" name="transaction" id="" class="form-control" value="Completed" placeholder="@lang('Transaction Number')" aria-describedby="helpId">
                            
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Approved Transaction')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


     <!-- refund Modal -->
    <div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Approve Transaction')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                    <form action="{{route('admin.exchange.refund', $exchange->id)}}" method="POST">
                    <div class="modal-body">
                        @csrf

                         <div class="form-group">
                            <label for="">@lang('Reason of Refund')</label>
                            
                      <input type="text" name="reasonOf_refund" id="" class="form-control" value="Not Available this Currency" placeholder="@lang('Reason of Refund')" aria-describedby="helpId">

                            
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Refund Transaction')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


        <div class="modal fade" id="imageShow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg--primary">
                    <h4 class="text-white">@lang('Transaction Image Proof')</h4>
                </div>
                <div class="modal-body">
                    
                    <img alt="@lang('Proof Image')" id="image">
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
            </div>
            </div>
        </div>
        </div>
@endsection


@push('style')
            <style>
                        .bolder span:first-child {
                            font-weight: 900;
                        }

                        .text-design{
                            font-weight: bolder;
                            font-size: 20px;
                        }

                        fieldset {
                            background-color: #ffffff;
                            padding: 15px;
                            border-radius: 5px;
                            box-shadow: 0 0 5px rgba(0,0,0,0.25);
                        }

                        legend {
                            background-color: #7367f0;
                            color: white;
                            padding: 5px 10px;
                            border-radius: 5px;
                        }

                        input {
                            margin: 5px;
                        }

                        .exchange-card {
                            padding: 30px;
                            background-color: #ffffff;
                            display: -ms-flexbox;
                            display: flex;
                            -ms-flex-wrap: wrap;
                            flex-wrap: wrap;
                            border-radius: 5px;
                        }

                        .exchange-card .left {
                            width: 40%;
                        }

                        .exchange-card .left .thumb {
                            background-color: #ffffff;
                            border-radius: 5px;
                            box-shadow: 0 0 5px 0 rgba(0,0,0, 0.15);
                            margin: 20px 0
                        }

                        .exchange-card .left img {
                            max-height: 350px;
                        }
                        .exchange-card .right {
                            width: 60%;
                            padding-right: 50px;
                        }
                        .exchange-info-list {

                        }
                        .exchange-info-list li {
                            display: -ms-flexbox;
                            display: flex;
                            -ms-flex-wrap: wrap;
                            flex-wrap: wrap;
                            justify-content: space-between
                        }
                        .exchange-info-list .caption {
                            font-weight: 600;
                        }
                        .exchange-info-list li {
                            padding: 15px 0;
                            border-bottom: 1px dashed #e5e5e5;
                        }
                        .exchange-info-list li:first-child {
                            padding-top: 0;
                        }
                        .exchange-info-list li:last-child {
                            padding-bottom: 0;
                            border-bottom: none;
                        }

                        .caption{
                            font-weight: bolder !important;
                        }
    </style>
@endpush


@push('script')
    <script>
        
        $(function(){
            'use strict';
            
            $('.cancle').on('click',function(){
                var modal = $('#cancleModal');
                modal.modal('show')
            });

             $('.approve').on('click',function(){
                var modal = $('#approveModal');
                modal.modal('show');
            });

            $('.refund').on('click',function(){
                var modal = $('#refundModal');
                modal.modal('show');
            });


            $('.image-click').on('click',function(){
                var modal = $('#imageShow');

                var link = $(this).find('img').attr('src');

                $('#image').attr('src',link);

                modal.modal('show');
            })
        });
    
    
    </script> 
@endpush

@push('breadcrumb-plugins')

    <div class="d-flex flex-row-reverse">

        <div class="ml-5 mt-1">
            <a href="{{ route('admin.exchange.all') }}" class="btn btn-sm btn--primary box--shadow1 text--small"
                id="addCategory"><i class="las la-long-arrow-alt-left"></i> @lang('Back')</a>
        </div>

    </div>






@endpush