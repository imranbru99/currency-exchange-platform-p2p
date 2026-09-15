@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table id="example" class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>@lang('Comment By')</th>
                                <th>@lang('Comment')</th>
                                <th>@lang('Post')</th>
                                <th>@lang('Post By')</th>
                                <th>@lang('Delete')</th>
                              <th>@lang('Create')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($post as $key => $data)
                            <tr>
                               
                                <td style="width: 5%;">{{ ($key+1) }}</td>
                                <td data-label="@lang('Comment By')">
                                   <a href="{{ route('admin.users.detail', $data->user->id) }}">  {{$data->user->fullname}}</a>
                                </td>
                               
                                <td data-label="@lang('Comment')">
                                  <button type="button" class="btn btn-sm btn-info infoBtn" data-toggle="modal"  data-target="#exampleModal" data-info="{{$data->comment}}" >
                                 <i class="fas fa-eye mr-2"></i>View
                                </button>
                              </td>
                              <td data-label="@lang('Post')">
                                  <button type="button" class="btn btn-sm btn-info infoBtn" data-toggle="modal"  data-target="#exampleModal" data-info="Title:{{$data->post->post_title}},<br>Description: {{$data->post->description}}" >
                                 <i class="fas fa-eye mr-2"></i>View
                                </button>
                              </td>
                              <td data-label="@lang('Post By')">
                                   <a href="{{ route('admin.users.detail', $data->post->user->id) }}">  {{$data->post->user->fullname}}</a>
                                </td>
                              <td data-label="@lang('Action')">
                                <a  href="{{ route('admin.post.delete', $data->id) }}"><i
                                                  class="fas fa-trash mr-2"></i>Delete</a> 
                          </td>
                              
                              <td data-label="@lang('Comment')">
                                    {{$data->created_at->format('d-m-Y, h:i:s A')}}
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
            </div>
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
