@extends('admin.layouts.app')

@section('panel')
<div class="row">

    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th scope="col">@lang('Serial')</th>
                                <th>@lang('Detail')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Trx')</th>
                                <th scope="col">@lang('Delete')</th>
                                <th>@lang('Transacted')</th>
                                <th>@lang('Amount')</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                            <tr>
                                <td data-label="@lang('serial')">{{ $loop->iteration }}</td>
                                <td data-label="@lang('Detail')">
                                    <button type="button" class="btn btn-sm btn-info infoBtn" data-toggle="modal"  data-target="#exampleModal" data-info="{{$trx->details}}" >
                                        <i class="fas fa-eye mr-2"></i>View
                                       </button>
                                </td>
                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{ $trx->user->fullname }}</span>
                                    <br>
                                    <span class="small"> <a href="{{ route('admin.users.detail', $trx->user_id) }}"><span>@</span>{{ $trx->user->username }}</a> </span>
                                </td>

                                <td data-label="@lang('Trx')">
                                    <strong>{{ $trx->trx }}</strong>
                                </td>
                                <td>
                                    <a href="{{ route('admin.report.transaction.delete', $trx->id) }}"
                                            class="icon-btn editmodal" title="" data-original-title="Edit">
                                            <i class="las la-trash"></i>
                                        </a>
                                </td>
                                <td data-label="@lang('Transacted')">
                                    {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                </td>

                                <td data-label="@lang('Amount')" class="budget">
                                    <span class="font-weight-bold @if($trx->trx_type == '+')text-success @else text-danger @endif">
                                        {{ $trx->trx_type }} {{showAmount($trx->amount)}} {{ $trx->cur_sym }}
                                    </span>
                                </td>


                           </tr>
                           @empty
                           <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table><!-- table end -->
            </div>
        </div>
        <div class="card-footer py-4">
            {{ paginateLinks($transactions) }}
        </div>
    </div><!-- card end -->
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Comment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <p id="DetailsMicroJobDes"> </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>




  @endsection


@push('breadcrumb-plugins')
@if(request()->routeIs('admin.users.transactions'))
<form action="" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
@else
<form action="{{ route('admin.report.transaction.search') }}" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
@endif
@endpush






  @push('script')
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
      <script>

          $(document).ready(function() {
              $('#example').DataTable();
          } );
      </script>
      <script type="text/javascript">
          $(document).on('click','.infoBtn',function(){
              $('#DetailsMicroJobDes').html($(this).data('info'));
          });
      </script>
  @endpush
