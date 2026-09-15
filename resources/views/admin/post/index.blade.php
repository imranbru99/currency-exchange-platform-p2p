@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Topic')</th>
                                <th>@lang('Post By')</th>
                                <th>@lang('Reactions')</th>
                                <th>@lang('View')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($posts as $data)
                            <tr>
                                <td data-label="@lang('Topic')">
                                    <span class="font-weight-bold" data-toggle="tooltip" data-original-title="@lang('Post Title')">
                                        {{ substr(__($data->post_title), 0, 20) }}
                                    </span>
                                    <br/>
                                    <span class="font-weight-bold" data-toggle="tooltip" data-original-title="@lang('Description')">
                                        {{ shortDescription(__($data->description), 35) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Post By')">
                                    <span class="font-weight-bold">{{$data->user->fullname}}</span>
                                        <br>
                                    <span class="small">
                                    <a href="{{ route('admin.users.detail', $data->user_id) }}"><span>@</span>{{ $data->user->username }}</a>
                                    </span>
                                </td>
                                <td data-label="@lang('Reactions')">
                                   <span class="font-weight-bold" data-toggle="tooltip" data-original-title="@lang('Up Vote')">@lang('Up Vote') {{$data->up_vote}}</span>
                                   <br/>
                                   <span class="font-weight-bold" data-toggle="tooltip" data-original-title="@lang('Down Vote')">
                                   @lang('Down Vote') {{$data->down_vote}}</span>
                                </td>
                                <td data-label="@lang('View')">
                                   {{ $data->view }} @lang('Times')
                                </td>
                                <td data-label="@lang('Status')">
                                   @if($data->status == 1)
                                        <span class="badge badge--success">@lang('Approved')</span>
                                   @elseif($data->status == 2)
                                        <span class="badge badge--warning">@lang('Pending')</span>
                                   @endif
                                </td>
                                <td data-label="@lang('Action')">

                                    <div class="dropdown">
                                      <button class="btn dropdown-toggle" type="button" id="dropdownMenu2"
                                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="menu-icon la la-expand"></i>
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                      
                                      @if($data->status == 2)
                                          <a href="javascript:void(0)" class="icon-btn approveBtn mr-1"
                                           data-id='{{ $data->id }}' data-toggle="tooltip">
                                  <i class="las la-eye text--shadow"></i> Aprove Post</a>
                                          <a class="dropdown-item"
                                             href="{{ route('admin.post.reject', $data->id) }}"><i
                                                  class="fas fa-trash mr-2"></i>Delete Post</a> 
                                          @endif		
                                          <a class="dropdown-item" href="{{ route('admin.post.details', $data->id) }}"
                          data-id='{{ $data->id }}'
                          data-name='{{ $data->name }}'
                          data-icon='{{ $data->icon }}'
                          data-status='{{ $data->status }}'
                          class="icon-btn editBtn" data-toggle="tooltip">
                              <i class="las la-desktop text--shadow"></i>Details
                          </a>		
                                        
                                         <a class="dropdown-item"
                                             href="{{ route('admin.post.reject', $data->id) }}"><i
                                                  class="fas fa-trash mr-2"></i>Delete Post</a> 
                                                  
                                      </div>
                                  </div>
                              </td>

                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang('Data Not Found')!</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($posts) }}
                </div>
            </div>
        </div>

    </div>

{{-- APPROVED METHOD MODAL --}}
<div id="approvedModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Approve Confirmation')!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.post.approve') }}" method="POST">
                @csrf

                <div class="modal-body">
                    <input type="hidden" name="id" required="">
                    <p class="font-weight-bold">@lang('Are you sure to approve this post')?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Confirm')</button>
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

        $('.approveBtn').on('click', (e)=> {
            let $this = $(e.currentTarget);
            let modal = $('#approvedModal');
            modal.find('input[name=id]').val($this.data('id'));
            modal.modal('show');
        });

    })(jQuery);

</script>
@endpush
