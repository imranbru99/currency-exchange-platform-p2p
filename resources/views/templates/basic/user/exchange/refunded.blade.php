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
                        <th scope="col">@lang('Exchanger')</th>
                        <th scope="col">@lang('From')</th>
                        <th scope="col">@lang('Send Amount')</th>
                        <th scope="col">@lang('To')</th>
                        <th scope="col">@lang('Get Amount')</th>
                        <th>@lang('Date & Time')</th>
                        <th scope="col">@lang('Action')</th>
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
                        <a href="javascript:void(0)" class="details" data-from="{{$exchange->payment_from_getway->name}}" data-to="{{$exchange->payment_to_getway->name}}" data-reason="{{$exchange->refund_reason}}"><i class="fas fa-desktop"></i></a>
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



<div class="modal fade" tabindex="-1" role="dialog" id="detailsModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-5">
        <h5 class="mb-4">@lang('Refund Reason :')</h5>
        <p class="cancle-reason"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('Close')</button>
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


@push('script')
    <script>
         'use strict';
        $(function(){
           
            
            $('.details').on('click',function(){
                var modal = $('#detailsModal');
                var icon = `<i class="fas fa-exchange-alt"></i>`;

                var title =  $(this).data('from')+ ' ' +icon+ ' ' + $(this).data('to')

                modal.find('.modal-title').html(title);
                modal.find('.cancle-reason').text($(this).data('reason'));

                modal.modal('show');
            });
        })
    
    </script>    
@endpush