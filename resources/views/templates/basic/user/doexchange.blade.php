@extends($activeTemplate.'layouts.exchange')
@section('content')
 <div class="bgImgCenter" style="background-color:fuchsia;">
  <div class="d-flex justify-content-center">
      <div class="col-lg-8">
          <div class="currency-converter">
              <form class="exchange-form" method="POST" action="{{ route('user.exchange') }} ">
                  @csrf
                  <div class="form-group">
                      <label for="send"><strong>যে মাধ্যমে আমাদেরকে পেমেন্ট করবেন সেটা সেলেক্ট করুন</strong></label>
                      <input type="text" name="send_amount" id="send_val" placeholder="@lang('কত পাঠাবেন লিখুন')" required
                          onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                          
                      <select class="select-bar" name="send" id="send">
                          <option value="">@lang('Select Currency')</option>
                          @foreach ($currencys_sell as $currency)
                              <option value="{{ $currency->id }}"
                                  data-min_max="{{ filterCollection($currency,'rate','sell_at','buy_at','fixed_charge','percent_charge','reserve','min_exchange','max_exchange','cur_sym','payment_type_sell') }}">
                                  {{ $currency->name }} {{ $currency->cur_sym }}
                              </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group receiveData">
                      <label for="receive"><strong>যে মাধ্যমে আপনি নিতে চাচ্ছেন সেটা নিচে সেলেক্ট করুন </strong></label>
                      <input type="text" name="receive_amount" id="receive_val" min="0"
                          placeholder="@lang('আপনি পাবেন')" readonly>
                      <select class="select-bar" name="receive" id="receive">
                          <option value="" class="wrap">@lang('Select Currency')</option>
                          @foreach ($currencys_buy as $currency)
                              <option value="{{ $currency->id }}"
                                  data-min_max="{{ filterCollection($currency,'cur_sym','rate','sell_at','buy_at','fixed_charge','percent_charge','reserve','min_exchange','max_exchange','payment_type_sell') }}">
                                  {{ $currency->name }} {{ $currency->cur_sym }}
                              </option>
                          @endforeach
                      </select>
                      <label for="receive"><strong>উপরের সেলেক্ট ও সেন্ড পরিমাণ দেওয়া হলে নিচের এক্সচেন্জ বাটনটি ক্লিক করুন </strong></label>

                  </div>
                  <div class="form-group submit">

                      <input type="submit" value="@lang('Exchange')">
                  </div>
              </form>
          </div>
      </div>
    </div>
</div>
 </section>
    <!--=======Banner-Section Ends Here=======-->



   @php
$currencys = App\Models\Currency::where('available_for_sell', 1)
    ->where('available_for_buy', 1)
    ->where('show_rate', 1)
    ->latest()
    ->take(15)
    ->get();
@endphp
  
  <section>
    {{ ' ' }}
    {{ ' ' }}
    {{ ' ' }}
    <div class="container-fluid">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Currency</th>
                    <th scope="col">Buy Rate</th>
                  <th scope="col">Minimum Exchange</th>
                    <th scope="col">Sell Rate</th>
                </tr>
            </thead>
            @foreach ($currencys as $key => $currency)
                <tbody>
                    <tr>
                        <td>{{ $currency->name }}</td>
                        <td>{{ getAmount($currency->buy_at) }} TK</td>
                        <td> {{getAmount( $currency->min_exchange) }} {{$currency->cur_sym}} </td>
                        <td>{{ getAmount($currency->sell_at) }} TK</td>
                    </tr>
                </tbody>
            @endforeach
        </table>
    </div>
</section>
  
  
  @php
      $pending_exchange = App\Models\Exchange::with('payment_from_getway', 'user')->take(5)->where('status', 0)->latest()->get();
      $accpted_exchange = App\Models\Exchange::with('payment_from_getway', 'user')->take(5)->where('status', 1)->latest()->get();

@endphp
<!--=======Transaction-Section Starts Here=======-->
<section class="transaction-section padding-top padding-bottom">
    <div class="container-fluid">
           <div class="row justify-content-center">
                 <h2>Pending Exchange </h2>
             </div>
       <table class="transaction-table section-bg">
            <thead class="t-header">
                <tr>
                    <th scope="col">@lang('Ex. ID')</th>
                    <th scope="col">@lang('Status')</th>
                    <th scope="col">@lang('Send From')</th>
                    <th scope="col">@lang('Send Amount')</th>
                    <th scope="col">@lang('Receive In')</th>
                    <th scope="col">@lang('Receive Amount')</th>
                    <th scope="col">@lang('Time')</th>
                </tr>
            </thead>
            <tbody class="t-body">
                @forelse($pending_exchange as $exchange)
                    <tr>
                        <td data-input="@lang('Ex. ID')">{{ __($exchange->exchange_id) }}</td>
                        <td data-input="@lang('Exchanger')">
                            <span
                                class="text--small badge font-weight-normal
                            @if ($exchange->status == 0) badge bg-danger @endif ">

                                @if ($exchange->status == 0)
                                    @lang('PENDING')
                                @endif
                           



                            </span>

                        </td>
                        <td data-input="@lang('From')">{{ __($exchange->payment_from_getway->name) }}</td>
                        <td data-input="@lang('Amount')" class="amount">{{ $exchange->get_amount }}
                            {{ $exchange->payment_from_getway->cur_sym }}</td>
                        <td data-input="@lang('To')">{{ __($exchange->payment_to_getway->name) }}</td>
                        <td data-input="@lang('Amount')" class="amount">{{ $exchange->send_amount }}
                            {{ $exchange->payment_to_getway->cur_sym }}</td>
                        <td data-input="@lang('Time')" class="nowrap">
                            {{ $exchange->created_at->format('d-m-Y h:i A') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="100%">@lang('There is no pending Exchange')</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      
           <div class="row justify-content-center">
                 <h2>Completed Exchange </h2>
             </div>
      
        <table class="transaction-table section-bg">
            <thead class="t-header">
                <tr>
                    <th scope="col">@lang('Ex. ID')</th>
                    <th scope="col">@lang('Status')</th>
                    <th scope="col">@lang('Send From')</th>
                    <th scope="col">@lang('Send Amount')</th>
                    <th scope="col">@lang('Receive In')</th>
                    <th scope="col">@lang('Receive Amount')</th>
                    <th scope="col">@lang('Time')</th>
                </tr>
            </thead>
            <tbody class="t-body">
                @forelse($accpted_exchange as $exchange)
                    <tr>
                        <td data-input="@lang('Ex. ID')">{{ __($exchange->exchange_id) }}</td>
                        <td data-input="@lang('Exchanger')">
                            <span
                                class="text--small badge font-weight-normal
                            @if ($exchange->status == 0) badge--danger @endif
                            @if ($exchange->status == 1) badge bg-success @endif ">

                                @if ($exchange->status == 0)
                                    @lang('pending')
                                @endif
                                @if ($exchange->status == 1)
                                    @lang('Completed')
                                @endif



                            </span>

                        </td>
                        <td data-input="@lang('From')">{{ __($exchange->payment_from_getway->name) }}</td>
                        <td data-input="@lang('Amount')" class="amount">{{ $exchange->get_amount }}
                            {{ $exchange->payment_from_getway->cur_sym }}</td>
                        <td data-input="@lang('To')">{{ __($exchange->payment_to_getway->name) }}</td>
                        <td data-input="@lang('Amount')" class="amount">{{ $exchange->send_amount }}
                            {{ $exchange->payment_to_getway->cur_sym }}</td>
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

@endsection


@push('style')
    <style>
        .nowrap {
            white-space: nowrap;
        }

        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #39ba71;
            background-color: #0e0d35;
            border: 1px solid #ffffff;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #3fcc71;
            border-color: #ffffff;
        }

    </style>
@endpush
@push('script')
    <script src="{{ asset($activeTemplateTrue . 'js/homesection.js') }}"></script>
@endpush
