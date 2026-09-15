
@extends($activeTemplate .'layouts.master')
@section('content')
<section>
    <div class="container">
        <div class="row mb-6-8">
            <div class="col-md-12 mb-3">
                <div class="card table-card">
                    <div class="card-body p-0">
                        
                        <div class="table-responsive--sm">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                  <th scope="col">@lang('Sr.')</th>
                                    <th scope="col">@lang('Transaction ID')</th>
                                    <th scope="col">@lang('Details')</th>
                                    <th scope="col">@lang('Date & Time')</th>

                                </tr>
                                </thead>
                                <tbody>
                                @if(count($logs) >0)
                                    @foreach($logs as $k=>$data)
                                        <tr>
                                          <td data-label="@lang('Transaction Id')">{{$k+1}}</td>
                                            <td data-label="@lang('Transaction Id')">{{$data->trx}}</td>
                                            <td data-label="@lang('Details')">{{__($data->details)}}</td>
                                            <td data-label="@lang('Date')">{{$data->created_at->format('d-m-y & h:i:A')}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="100%" class="text-center"> @lang('No results found')!</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                 {{$logs->links($activeTemplate.'paginate')}}
            </div>
        </div>
    </div>
    </section>
@endsection
