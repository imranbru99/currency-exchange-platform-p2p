@extends('admin.layouts.app')
@section('panel')

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body p-0">

                    <div class="table-responsive--md table-responsive">
                        <table class=" table table--light style--two" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Serial')</th>
                                    <th scope="col">@lang('Username')</th>
                                    <th scope="col">@lang('Delete')</th>
                                    <th scope="col">@lang('Receive Amount')</th>
                                    <th scope="col">@lang('Send To')</th>
                                    <th scope="col">@lang('Send Time')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($exchanges as $exchange)
                                    <tr class="filt">
                                        <td data-label="@lang('serial')">{{ $loop->iteration }}</td>
                                        <td data-label="@lang('username')"><a href="{{ route('admin.users.detail', $exchange->user->id) }}">{{ @$exchange->user->username ?? 'N/A' }} </a></td>
                                        <td>
                                            <a href="{{ route('admin.exchange.delete', [$exchange->id]) }}"
                                                    class="icon-btn editmodal" title="" data-original-title="Edit">
                                                    <i class="las la-trash"></i>
                                            </a>
                                         </td>
                                        <td data-label="@lang('Receive Amount')">{{ $exchange->get_amount }} {{$exchange->payment_from_getway->cur_sym}}</td>
                                        <td data-label="@lang('Send To')">{{ @$exchange->payment_to_getway->name }} </td>
                                        <td data-label="@lang('Send Amount')">{{$exchange->created_at->format('d-m-Y h:i A')}}</td>
                                       <td data-label="@lang('Status')">
                                            <span class="text--small badge font-weight-normal
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
                                            </span>

                                        </td>
                                        <td data-label="@lang('Action')">

                                            <a href="{{ route('admin.exchange.details', $exchange->id) }}"
                                                class="icon-btn editmodal" title="" data-original-title="@lang('Edit')">
                                                <i class="las la-pen text--shadow"></i>
                                            </a>



                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                    <td colspan="100%" class="text-muted text-center">{{trans($empty_message)}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>


                    </div>
                </div>

                <div class="card-footer py-4">
                    {{ $exchanges->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="modalDelete">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Success Story')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="font-weight-bold">@lang('Are you Sure to delete ?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <a class="btn btn--danger text-light">@lang('Delete')</a>
                </div>
            </div>
        </div>
    </div>


@endsection


@push('breadcrumb-plugins')
    <div class="d-flex flex-row-reverse bd-highlight ">
        <div class="p-2 bd-highlight">
            <form action="{{ route('admin.exchange.search') }}" method="GET" class="form-inline float-sm-right bg--white">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Exchange by gateway Name')"
                        value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endpush

@push('script')

    <script>
        $(function(){
            'use strict';

            $('.delete').on('click', function() {
                $('#modalDelete').find('a').attr('href', $(this).data('src'));
                $('#modalDelete').modal('show');
            });
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable .filt").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

        })

    </script>

@endpush
