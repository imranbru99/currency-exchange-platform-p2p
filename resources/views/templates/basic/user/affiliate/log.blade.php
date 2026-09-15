@extends($activeTemplate.'layouts.master')
@section('content')


    <div class="dashboard-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                <div class="col-md-12 col-lg-12">

                    <div class="table-responsive">
                        <table class="transaction-table">
                            <thead class="t-header">
                                <tr>

                                    <th scope="col">@lang('Trx')</th>
                                    <th scope="col">@lang('Reffer User')</th>
                                    <th scope="col">@lang('Level')</th>
                                    <th scope="col">@lang('Amount')</th>
                                    <th scope="col">@lang('Main Amount')</th>
                                    <th scope="col">@lang('Description')</th>
                                    <th scope="col">@lang('Date')</th>
                                </tr>
                            </thead>
                            <tbody class="t-body">
                                @forelse($commission as $data)
                                    <tr>
                                        <td data-input="@lang('Trx')">
                                            {{ $data->trx }}
                                        </td>
                                        <td data-input="@lang('Reffer User')">{{ $data->reffer->username }}</td>
                                        <td data-input="@lang('Level')">{{ __($data->level) }}</td>
                                        <td data-input="@lang('Amount')">{{ $data->amount }}</td>
                                        <td data-input="@lang('Main Amount')" class="amount">{{ $data->main_amo }}</td>
                                        <td data-input="@lang('Description')" class="amount">
                                            <div class="min--width">
                                                {{ __($data->title) }}
                                            </div>
                                        </td>
                                        <td data-input="@lang('Date')" class="nowrap">
                                            {{ $data->created_at->format('d-m-y') }}
                                        </td>

                                    </tr>
                                @empty

                                    <tr>
                                        <td colspan="100%" class="text-center">{{ $empty_message }}</td>
                                    </tr>

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        {{ $commission->links('admin.partials.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@push('style')

    <style>
        .min--width{
            min-width: 170px;
        }
        .modal-header {
            background: seagreen;
        }

        .modal-header .close {
            padding: 1rem 1rem;
            margin: -1rem 0rem;
            width: 31px;
        }

        .modal-body {
            background: #07071b;
        }

        .nowrap {
            white-space: nowrap;
        }

        td a i {
            color: seagreen
        }

    </style>
@endpush
