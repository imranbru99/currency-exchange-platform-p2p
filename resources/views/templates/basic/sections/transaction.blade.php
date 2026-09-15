@php
    $content = getContent('transaction.content',true);

@endphp   
<!--=======Transaction-Section Starts Here=======-->
    <section class="transaction-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-header">
                       
                    <h3 class="title">{{__($content->data_values->heading)}}</h3>
                        <p>
                            {{__($content->data_values->sub_heading)}}
                        </p>
                    </div>
                </div>
            </div>

            <table class="transaction-table section-bg">
                <thead class="t-header">
                    <tr>
                        <th scope="col">@lang('Exchanger')</th>
                        <th scope="col">@lang('Send From')</th>
                        <th scope="col">@lang('Send Amount')</th>
                        <th scope="col">@lang('Get To')</th>
                        <th scope="col">@lang('Get Amount')</th>
                        <th scope="col">@lang('Date')</th>
                    </tr>
                </thead>
                <tbody class="t-body">
                    @forelse($accpted_exchange as $exchange)
                    <tr>
                        <td data-input="@lang('Exchanger')">
                            <div class="exchanger"> 
                                <div class="content">
                                <span>{{@$exchange->user->username}}</span>
                                </div>
                            </div>
                        </td>
                        <td data-input="@lang('From')">{{__($exchange->payment_from_getway->name)}}</td>
                        <td data-input="@lang('Amount')" class="amount">{{$exchange->get_amount}} {{$exchange->payment_from_getway->cur_sym}}</td>
                        <td data-input="@lang('To')">{{__($exchange->payment_to_getway->name)}}</td>
                        <td data-input="@lang('Amount')" class="amount">{{$exchange->send_amount}} {{$exchange->payment_to_getway->cur_sym}}</td>
                        <td data-input="@lang('Time')" class="nowrap">
                            {{$exchange->created_at->format('d-m-y')}}
                        </td>
                    </tr>
                    @empty
                     <tr>
                         <td class="text-center" colspan="100%">@lang('No Data Found')</td>
                     </tr>
                    @endforelse
                </tbody>
            </table>
            
        </div>
    </section>
    <!--=======Transaction-Section Ends Here=======-->

    @push('style')
        <style>
            .nowrap {
                white-space: nowrap;
            }
        </style>
    @endpush