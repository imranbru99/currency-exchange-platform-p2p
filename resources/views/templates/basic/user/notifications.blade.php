@extends($activeTemplate.'layouts.master')
@section('content')
<div class="container py-5">
    <div class="pm-page-head">
        <span class="pm-kicker">@lang('Activity')</span>
        <h1>@lang('Notifications')</h1>
        <p>@lang('Latest updates from your exchanges and support tickets.')</p>
    </div>

    <div class="pm-card mb-4">
        <h3 class="mb-3">@lang('Exchange updates')</h3>
        <div class="table-responsive">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th>@lang('ID')</th>
                        <th>@lang('Pair')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Time')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exchanges as $exchange)
                        <tr>
                            <td>
                                <a href="{{ route('user.exchange.details', $exchange) }}">{{ $exchange->exchange_id }}</a>
                            </td>
                            <td>
                                {{ optional($exchange->payment_from_getway)->cur_sym }}
                                →
                                {{ optional($exchange->payment_to_getway)->cur_sym }}
                            </td>
                            <td>
                                @if($exchange->status == 0)
                                    <span class="pm-badge pm-badge-warn">@lang('Pending')</span>
                                @elseif($exchange->status == 1)
                                    <span class="pm-badge pm-badge-success">@lang('Completed')</span>
                                @elseif($exchange->status == 2)
                                    <span class="pm-badge pm-badge-danger">@lang('Cancelled')</span>
                                @else
                                    <span class="pm-badge pm-badge-info">@lang('Refunded')</span>
                                @endif
                            </td>
                            <td>{{ $exchange->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">@lang('No exchange activity yet')</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $exchanges->links() }}</div>
    </div>

    <div class="pm-card">
        <h3 class="mb-3">@lang('Recent tickets')</h3>
        <ul class="pm-simple-list">
            @forelse($tickets as $ticket)
                <li>
                    <a href="{{ route('ticket.view', $ticket->ticket) }}">#{{ $ticket->ticket }} — {{ $ticket->subject }}</a>
                    <span class="pm-muted">{{ $ticket->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li>@lang('No support tickets')</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
