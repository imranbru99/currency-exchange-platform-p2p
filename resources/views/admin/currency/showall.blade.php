@extends('admin.layouts.app')
@section('panel')

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body p-0">

                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two" id="myTable">
                            <thead>
                                <tr>

                                    <th scope="col">@lang('SL')</th>
                                    <th scope="col">@lang('Currency Name')</th>
                                    <th scope="col">@lang('Buy At')</th>
                                    <th scope="col">@lang('Sell At')</th>
                                    <th scope="col">@lang('Reserve Amount')</th>
                                    <th scope="col">@lang('Delete')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($currencys as $key => $currency)
                                    <tr class="filt">

                                        <td data-label="@lang('Seria')l">{{ $loop->iteration }}</td>
                                        <td data-label="@lang('Name')">
                                            {{ strtoupper($currency->name) }}
                                        </td>
                                        <td data-label="@lang('buy_at')">{{ getAmount($currency->buy_at) }} {{ $general->cur_text }}</td>
                                        <td data-label="@lang('sell_at')">{{ getAmount($currency->sell_at) }} {{ $general->cur_text }}</td>
                                        <td data-label="@lang('reserve')">{{ getAmount($currency->reserve) }} {{ $currency->cur_sym }}</td>
                                       <td>
                                        <a href="{{ route('admin.currency.delete', [$currency->id]) }}"
                                                class="icon-btn editmodal" title="" data-original-title="Edit">
                                                <i class="las la-trash"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.currency.edit', [$currency->id, Str::slug($currency->name)]) }}"
                                                class="icon-btn editmodal" title="" data-original-title="Edit">
                                                <i class="las la-edit text--shadow"></i>
                                            </a>
                                        </td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-muted text-center">{{ __($empty_message) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>


                    </div>
                </div>

                <div class="card-footer py-4">
                    {{ $currencys->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>







@endsection


@push('breadcrumb-plugins')

    <div class="d-flex flex-row-reverse">
        <div class="ml-5">
            <a href="{{ route('admin.currency.create') }}" class="btn btn--primary box--shadow1"
                id="addCategory"><i class="fa fa-fw fa-plus"></i> @lang('Add Currency')</a>
        </div>

        <div>
            <form action="{{ route('admin.currency.search') }}" method="GET" class="form-inline float-sm-right bg--white">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Currency Name')"
                        value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>


        </div>
    </div>
@endpush
