@extends($activeTemplate.'layouts.exchange')
@section('content')


    <div class="dashboard-section padding-top padding-bottom">
        <div class="container-fluid">
            <div class="row justify-content-center mb-30-none">
                <div class="col-md-12 col-lg-12">
                    <h3 class="text-center mb-3">@lang($pageTitle)</h3>
                    <div class="table-responsive">
                        <table class="transaction-table section-bg">
                            <thead class="t-header">
                                <tr>
                                    <th scope="col">@lang('Serial')</th>
                                    <th>@lang('Sending From')</th>
                                    <th>@lang('Send Amount')</th>
                                    <th>@lang('Receive In')</th>
                                    <th>@lang('Get Amount')</th>
									 <th>@lang('Status')</th>
                                    <th>@lang('Date & Time')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody class="t-body">
                                @forelse ($exchanges as $exchange)
                                    <tr>
                                        <td data-label="@lang('serial')">{{ $loop->iteration }}</td>
                                        <td data-input="@lang('From')">{{ $exchange->payment_from_getway->name }}</td>
                                        <td data-input="@lang('Amount')" class="amount">{{ $exchange->get_amount }}
                                            {{ $exchange->payment_from_getway->cur_sym }}</td>
                                        <td data-input="@Lang('Receive In')">{{ $exchange->payment_to_getway->name }}</td>
                                        <td data-input="@lang('Amount')" class="amount">{{ $exchange->send_amount }}
                                            {{ $exchange->payment_to_getway->cur_sym }}</td>
                                            <td data-label="@lang('Status')">
                                                <span class="float-right text--small badge font-weight-normal
                                                @if ($exchange->status == 0)
                                                        badge-danger
                                                    @endif

                                                    @if ($exchange->status == 1)
                                                        badge-success
                                                    @endif


                                                    @if ($exchange->status == 2)
                                                        badge-danger
                                                    @endif


                                                    @if ($exchange->status == 3)
                                                        badge-warning
                                                    @endif ">
                                                    @if ($exchange->status == 0)
                                                        @lang('PENDING')
                                                    @endif

                                                    @if ($exchange->status == 1)
                                                        @lang('Completed')
                                                    @endif


                                                    @if ($exchange->status == 2)
                                                        @lang('CANCELED')
                                                    @endif


                                                    @if ($exchange->status == 3)
                                                        @lang('REFUNDED')
                                                    @endif
                                                </td>

                                        <td data-input="@lang('Time')" class="nowrap">
                                            {{ $exchange->created_at->format('d-m-y & h:i:A') }}
                                        </td>
                                        <td>
                                            <a href="{{route('user.exchange.details',$exchange->id)}}"><i class="fas fa-desktop"></i></a>
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
                <div class="modal-body p-5 section-bg">
                    <h5 class="mb-4">@lang('Cancle Reason :')</h5>
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

        td a i {
            color: seagreen
        }

    </style>
@endpush


@push('script')
    <script>
        'use strict';
        $(function() {

            $('.details').on('click', function() {
                var modal = $('#detailsModal');
                var icon = `<i class="fas fa-exchange-alt"></i>`;

                var title = $(this).data('from') + ' ' + icon + ' ' + $(this).data('to')

                modal.find('.modal-title').html(title);
                modal.find('.cancle-reason').text($(this).data('reason'));

                modal.modal('show');
            });
        })

    </script>
@endpush
