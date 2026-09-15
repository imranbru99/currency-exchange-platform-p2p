@extends($activeTemplate.'layouts.master')

@section('content')

<div class="container">
  <div class="row justify-content-center">  
          <div class="col-xl-9 mt-xl-0 mt-5">
              <div class="custom--card">
                <div class="card-header justify-content-between d-flex">
                  <h5>@lang('Tickets')</h5>
                  <a href="{{route('ticket.open') }}" class="btn btn-primary btn-sm">
                  @lang('New Ticket')
                  </a>
                </div>
                <div class="card-body">
                  <div class="table-responsive--md">
                    <table class="table custom--table">
                      <thead>
                        <tr>
                          <th>@lang('Subject')</th>
                          <th>@lang('Status')</th>
                          <th>@lang('Priority')</th>
                          <th>@lang('Last Reply')</th>
                          <th>@lang('View')</th>
                        </tr>
                      </thead>
                      <tbody>

                      @foreach($supports as $key => $support)
                        <tr>
                          <td data-label="@lang('Subject')">
                              [@lang('Ticket')#{{ $support->ticket }}] {{ substr(__($support->subject), 0, 12) }} 
                          </td>
                          <td data-label="@lang('Status')">
                              @if($support->status == 0)
                                  <span class="badge badge--success">@lang('Open')</span>
                              @elseif($support->status == 1)
                                  <span class="badge badge--primary">@lang('Answered')</span>
                              @elseif($support->status == 2)
                                  <span class="badge badge--warning">@lang('Customer Reply')</span>
                              @elseif($support->status == 3)
                                  <span class="badge badge--danger">@lang('Closed')</span>
                              @endif
                          </td>
                          <td data-label="@lang('Priority')">
                              @if($support->priority == 1)
                                  <span class="badge badge--dark">@lang('Low')</span>
                              @elseif($support->priority == 2)
                                  <span class="badge badge--success">@lang('Medium')</span>
                              @elseif($support->priority == 3)
                                  <span class="badge badge--primary">@lang('High')</span>
                              @endif
                          </td>
                          <td data-label="@lang('Last Reply')">
                            {{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }}
                          </td>
                          <td data-label="@lang('View')">
                            <a href="{{ route('ticket.view', $support->ticket) }}" class="icon-btn bg--success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('View')"><i class="las la-desktop"></i></a>
                          </td>
                        </tr>
                      @endforeach

                      </tbody>
                    </table>
                    {{$supports->links()}}
                  </div>
                </div>
              </div>
          </div>
    </div>
  </div>
@endsection
