@extends($activeTemplate . 'layouts.exchange')
@section('content')
    <section class="transaction-section padding-top padding-bottom">


        <div class="row justify-content-center">
            <h2>All Completed Exchange </h2>
        </div>

        <table class="transaction-table section-bg">
            <thead class="t-header">
                <tr>
                    <th scope="col">@lang('Ex. ID')</th>
                    <th scope="col">@lang('Send Amount')</th>
                    <th scope="col">@lang('Receive Amount')</th>
                    <th scope="col">@lang('Time')</th>
                </tr>
            </thead>
            <tbody class="t-body">
                @forelse($exchanges as $exchange)
                    <tr>
                        <td data-input="@lang('Ex. ID')"><a href="{{ route('exchangeDetail', $exchange->exchange_id) }}"
                                class="btn-warning">{{ __($exchange->exchange_id) }}</a></td>
                        <td data-input="@lang('Amount')" class="amount">{{ $exchange->get_amount }} </td>
                        <td data-input="@lang('Amount')" class="amount">{{ $exchange->send_amount }}</td>
                        <td data-input="@lang('Time')" class="nowrap">
                            {{ $exchange->created_at->format('d-m-Y h:i A') }}
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

    </section>
@endsection


@push('script')
    <script src="{{ asset($activeTemplateTrue . 'js/homesection.js') }}"></script>
@endpush
