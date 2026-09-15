@extends($activeTemplate.'layouts.exchange')
@section('content')


    <div class="dashboard-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                <div class="col-md-12 col-lg-12">
                    <h3 class="text-center mb-3">@lang($pageTitle)</h3>
                    <div class="table-responsive">
                        <table class="transaction-table">
                        <thead class="t-header">
                            <tr>
                                <th>@lang('Exchanger')</th>
                                <th>@lang('From')</th>
                                <th>@lang('Send Amount')</th>
                                <th>@lang('To')</th>
                                <th>@lang('Get Amount')</th>
                                <th>@lang('Date & Time')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                <tbody class="t-body">
                    @forelse($exchanges as $exchange)
                    <tr>
                        <td data-input="@lang('Exchanger')">
                            <div class="exchanger"> 
                                <div class="content">
                                <span>{{@$exchange->user->username}}</span>
                                </div>
                            </div>
                        </td>
                        <td data-input="@lang('From')">{{$exchange->payment_from_getway->name}}</td>
                        <td data-input="@lang('Amount')" class="amount">{{$exchange->get_amount}} {{$exchange->payment_from_getway->cur_sym}}</td>
                        <td data-input="@lang('To')">{{$exchange->payment_to_getway->name}}</td>
                        <td data-input="@lang('Amount')" class="amount">{{$exchange->send_amount}} {{$exchange->payment_to_getway->cur_sym}}</td>
                        <td data-input="@lang('Time')" class="nowrap">
                            {{$exchange->created_at->format('d-m-y & h:i:A')}}
                        </td>
                        <td>
                        <a href="{{route('user.exchange.details',$exchange->id)}}" class="details" data-from="{{$exchange->payment_from_getway->name}}" data-to="{{$exchange->payment_to_getway->name}}" data-reason="{{$exchange->cancle_reason}}"><i class="fas fa-desktop"></i></a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7">{{$empty_message}}</td>    
                        </tr>
                    @endforelse
                </tbody>
            </table>
                    </div>
                <div class="card-footer py-4">
                    {{ $exchanges->links('admin.partials.paginate') }}
                </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@push('style')
 
    <style>

       
        .nowrap {
            white-space: nowrap;
        }

        td a i{
            color:seagreen
        }
    </style>
@endpush
