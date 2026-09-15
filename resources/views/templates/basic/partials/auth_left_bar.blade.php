{{-- @php
$currencys = App\Models\Currency::where('available_for_sell', 1)
    ->where('available_for_buy', 1)
    ->where('show_rate', 1)
    ->latest()
    ->take(15)
    ->get();
$reserve = getContent('reserve.content', true);
@endphp




<aside class="xxxl-2 col-lg-3 d-lg-block d-none">


  @guest
    <div class="rounded-3 bg--gradient p-4 text-center mb-4">
        <h3 class="fw-normal text-white">@lang('Exchange from 100% Safety')</h3>
        <p class="text-white fs--14px mt-3">You will get 100% Guarantee for your deal with 100% Safety</p>
        <a href="{{ route('tryexchange') }}" class="btn btn--base mt-4">@lang('Exchange Now')</a>
    </div>
@endguest



  <div class="sidebar-widget mt-4">
    <div class="sidebar-widget__header">
      <h5 class="sidebar-widget__title">@lang('Exchange Buy and Sell Rate')</h5>
    </div>
    <div class="sidebar-widget__body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Currency</th>
                    <th scope="col">Buy Rate</th>
                    <th scope="col">Sell Rate</th>
                </tr>
            </thead>
            @foreach ($currencys as $currency)
                <tbody>
                    <tr>
                        <td>{{ $currency->name }}</td>
                        <td>{{ getAmount($currency->buy_at) }}</td>
                        <td>{{ getAmount($currency->sell_at) }}</td>
                    </tr>
                </tbody>
            @endforeach
        </table>
    </div>
  </div><!-- sidebar-widget end -->

  <div class="sidebar-widget mt-4">
    <div class="sidebar-widget__header">
      <h5 class="sidebar-widget__title">@lang('Completed Exchange')</h5>
    </div>
<table class="transaction-table section-bg">
   <thead class="t-header">
       <tr>
          
           <th scope="col">@lang('Status')</th>
           <th scope="col">@lang('Date')</th>
       </tr>
   </thead>

        @php
      $accpted_exchange = App\Models\Exchange::with('payment_from_getway', 'user')->take(5)->where('status', 1)->latest()->get();

      @endphp
   <tbody class="t-body">
       @forelse($accpted_exchange as $exchange)
           <tr>
               
               <td data-input="@lang('Exchanger')">
                   <span
                       class="text--small badge font-weight-normal
                   @if ($exchange->status == 0) badge--danger @endif
                   @if ($exchange->status == 1) badge bg-success @endif ">
                       @if ($exchange->status == 1)
                           @lang('Completed')
                       @endif
                   </span>
               </td>
             
               <td data-input="@lang('Time')" class="nowrap">
                   {{ $exchange->created_at->format('d-m-y') }}
               </td>
           </tr>
       @empty
           <tr>
               <td class="text-center" colspan="100%">@lang('No Data Found')</td>
           </tr>
       @endforelse
   </tbody>
</table>
  </div><!-- sidebar-widget end -->

  
</aside> --}}
