@extends($activeTemplate.'layouts.master')

@php
    $currencys_sell = App\Models\Currency::where('available_for_sell', 1)->latest()->get();
    $currencys_buy = App\Models\Currency::where('available_for_buy', 1)->latest()->get();
@endphp

@section('content')

<div class="container-fluid">
  @include($activeTemplate.'partials.calculator', [
      'currencys_sell' => $currencys_sell,
      'currencys_buy' => $currencys_buy,
      'calculatorTitle' => __('Your exchange desk'),
      'calculatorLead' => __('Create a new order with a live quote, then track it from this dashboard.'),
  ])

  <div class="alert alert-warning pm-warning">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    @lang('Tether USDT (TRC20) purchases include a $0.80 network fee per transaction. Minimum purchase is $1.')
  </div>

  <div class="row gy-4">
    <div class="col-lg-3 col-sm-6">
      <div class="d-widget">
        <a href="{{ route('user.exchange.pending') }}" class="d-widget__btn" title="@lang('View All')"><i class="las la-arrow-right"></i></a>
        <div class="d-widget__icon"><i class="fas fa-chart-line"></i></div>
        <div class="d-widget__content">
          <h3 class="amount">{{ $pending_exchange_count }}</h3>
          <p class="caption">@lang('Pending Exchange')</p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="d-widget">
        <a href="{{ route('user.exchange.approved') }}" class="d-widget__btn" title="@lang('View All')"><i class="las la-arrow-right"></i></a>
        <div class="d-widget__icon"><i class="fa fa-check"></i></div>
        <div class="d-widget__content">
          <h3 class="amount">{{ $accpted_exchange_count }}</h3>
          <p class="caption">@lang('Approved Exchange')</p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="d-widget">
        <a href="{{ route('user.exchange.refunded') }}" class="d-widget__btn" title="@lang('View All')"><i class="las la-arrow-right"></i></a>
        <div class="d-widget__icon"><i class="las la-undo-alt"></i></div>
        <div class="d-widget__content">
          <h3 class="amount">{{ $refunded_exchange_count ?? 0 }}</h3>
          <p class="caption">@lang('Refunded')</p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="d-widget">
        <a href="{{ route('user.affiliate') }}" class="d-widget__btn" title="@lang('Affiliate')"><i class="las la-arrow-right"></i></a>
        <div class="d-widget__icon"><i class="las la-coins"></i></div>
        <div class="d-widget__content">
          <h3 class="amount">{{ getAmount($refferal_bonus ?? 0) }}</h3>
          <p class="caption">@lang('Referral bonus')</p>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-sm-6">
      <div class="d-widget">
        <a href="{{ route('user.post.all') }}" class="d-widget__btn" title="@lang('View All')"><i class="las la-arrow-right"></i></a>
        <div class="d-widget__icon"><i class="las la-blog"></i></div>
        <div class="d-widget__content">
          <h3 class="amount">{{ $countPost }}</h3>
          <p class="caption">@lang('Total Post')</p>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-sm-6">
      <div class="d-widget">
        <a href="{{ route('ticket') }}" class="d-widget__btn" title="@lang('View All')"><i class="las la-arrow-right"></i></a>
        <div class="d-widget__icon"><i class="las la-ticket-alt"></i></div>
        <div class="d-widget__content">
          <h3 class="amount">{{ $countTicket }}</h3>
          <p class="caption">@lang('Total Ticket')</p>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-sm-12">
      <div class="d-widget">
        <a href="{{ route('user.notifications') }}" class="d-widget__btn" title="@lang('View All')"><i class="las la-arrow-right"></i></a>
        <div class="d-widget__icon"><i class="las la-bell"></i></div>
        <div class="d-widget__content">
          <h3 class="amount">@lang('Alerts')</h3>
          <p class="caption">@lang('Exchange and ticket notifications')</p>
        </div>
      </div>
    </div>
  </div>

  <div class="custom--card mt-5">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h6 class="mb-0">@lang('Recent exchanges')</h6>
      <a href="{{ route('user.exchange.history') }}" class="btn btn--base btn-sm">@lang('View all')</a>
    </div>
    <div class="card-body">
      <div class="table-responsive--md">
        <table class="table custom--table pm-table">
          <thead>
            <tr>
              <th>@lang('ID')</th>
              <th>@lang('Pair')</th>
              <th>@lang('Send')</th>
              <th>@lang('Receive')</th>
              <th>@lang('Status')</th>
              <th>@lang('Action')</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recent_exchanges ?? [] as $exchange)
              <tr>
                <td>{{ $exchange->exchange_id }}</td>
                <td>{{ optional($exchange->payment_from_getway)->cur_sym }} → {{ optional($exchange->payment_to_getway)->cur_sym }}</td>
                <td>{{ getAmount($exchange->get_amount) }}</td>
                <td>{{ getAmount($exchange->send_amount) }}</td>
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
                <td>
                  <a href="{{ route('user.exchange.details', $exchange->id) }}" class="btn btn--base btn-sm">@lang('Details')</a>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center">@lang('No exchanges yet')</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="custom--card mt-5">
    <div class="card-header">
      <h6>@lang('My Latest Forum Post')</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive--md">
        <table class="table custom--table">
          <thead>
            <tr>
              <th>@lang('Forum Post Title')</th>
              <th>@lang('Date')</th>
              <th>@lang('Positive Vote')</th>
              <th>@lang('Negative Vote')</th>
              <th>@lang('Status')</th>
              <th>@lang('Action')</th>
            </tr>
          </thead>
          <tbody>
          @forelse($posts as $post)
            <tr>
              <td data-label="@lang('Forum Post Title')">{{ shortDescription(__($post->post_title), 25) }}</td>
              <td data-label="@lang('Date')">{{ showDateTime($post->created_at, 'd-m-Y') }}</td>
              <td data-label="@lang('Positive Vote')"><i class="las la-arrow-up text--success"></i> {{ $post->up_vote }}</td>
              <td data-label="@lang('Negative Vote')"><i class="las la-arrow-down text--danger"></i> {{ $post->down_vote }}</td>
              <td data-label="@lang('Status')">
                @if($post->status == 1)
                  <span class="badge badge--success">@lang('Approved')</span>
                @elseif($post->status == 2)
                  <span class="badge badge--warning">@lang('Pending')</span>
                @endif
              </td>
              <td data-label="Action">
                <a href="{{ route('user.post.update.form', $post->id) }}" class="icon-btn bg--success" title="@lang('Edit')"><i class="las la-edit"></i></a>
                <a href="#0" class="icon-btn bg--danger deleteBtn" data-id="{{ $post->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal" title="@lang('Delete')"><i class="las la-trash-alt"></i></a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="100%" class="text-center">@lang('Data Not Found')!</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">@lang('Confirmation')!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('user.post.delete') }}" method="post">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="id" required="" id="deleteId">
          <p>@lang('Are you sure to delete this post')?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-md bg--danger text-white" data-bs-dismiss="modal">@lang('Close')</button>
          <input type="submit" class="btn btn-md bg-primary" value="@lang('Confirm')">
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('script')
  <script>
      (function ($) {
          "use strict";
          $('.deleteBtn').on('click', function () {
              $('#deleteId').val($(this).data('id'));
          });
      })(jQuery);
  </script>
  <script src="{{ asset($activeTemplateTrue . 'js/homesection.js') }}"></script>
@endpush
