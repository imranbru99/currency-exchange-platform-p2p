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
                                <th>@lang('Url')</th>
                                <th>@lang('Impression')</th>
                                <th>@lang('Clicked')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($ads as $data)
                            <tr>
                                <td data-label="@lang('Url')">
                                    <span class="font-weight-bold">
                                        {{ shortDescription(__($data->url), 50) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Impression')">
                                    {{ $data->impression }}
                                </td>

                                <td data-label="@lang('Clicked')">
                                    {{ $data->click }}
                                </td>
                                <td data-label="@lang('Status')">
                                    @if($data->status == 1)
                                        <span class="badge badge--success">@lang('Enable')</span>
                                    @else
                                        <span class="badge badge--warning">@lang('Disable')</span>
                                    @endif
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="javascript:void(0)"
                                    data-id='{{ $data->id }}'
                                    data-url='{{ $data->url }}'
                                    data-image='{{ getImage(imagePath()["ad"]["path"]."/".$data->image)}}'
                                    data-status='{{ $data->status }}'
                                    class="icon-btn editBtn" data-toggle="tooltip" title="" data-original-title="@lang('Edit')">
                                        <i class="las la-edit text--shadow"></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                    data-id='{{ $data->id }}'
                                    data-name='{{ $data->name }}'
                                    data-icon='{{ $data->icon }}'
                                    data-status='{{ $data->status }}'
                                    class="icon-btn deleteBtn bg-danger ml-1" data-toggle="tooltip" title="" data-original-title="@lang('Delete')">
                                        <i class="las la-trash text--shadow"></i>
                                    </a>
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
                    {{ paginateLinks($ads) }}
                </div>
            </div>
        </div>

    </div>

{{-- ADD METHOD MODAL --}}
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add New Advertisement')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.ad.create') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="profilePicPreview" id="display_image">
                                                    <span class="size_mention"></span>
                                                    <button type="button" id="image_remove_id" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" required class="profilePicUpload" id="profilePicUpload1" accept=".png, .jpg, .jpeg, .gif" name="image">
                                        <label for="profilePicUpload1" id='image_btn' class="bg-primary">@lang('Select Ad Image') </label>
                                        @lang('Supproted image .jpeg, .png, .jpg, .gif, 300x300')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="url">@lang('Url')</label>
                                <input type="text" name="url" class="form-control" id="url" required
                                oninput="carRemaining('urlSpan', this.value, 250)"
                                >
                                <span id="urlSpan" class="remaining">
                                    250 @lang('characters remaining')
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="status">@lang('Status')</label>
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" id="status" data-on="@lang('Enable')" data-off="@lang('Disable')" name="status">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT METHOD MODAL --}}
<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Update Advertisement')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.ad.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" required="">

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="profilePicPreview" id="display_image">
                                                    <span class="size_mention"></span>
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" id="profilePicUpload" accept=".png, .jpg, .jpeg, .gif" name="image">
                                        <label for="profilePicUpload" id='image_btn' class="bg-primary">@lang('Select Ad Image') </label>
                                        @lang('Supproted image .jpeg, .png, .jpg, .gif, 300x300')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="edit_url">@lang('Url')</label>
                                <input type="text" name="url" class="form-control" id="edit_url"
                                oninput="carRemaining('edit_urlSpan', this.value, 250)">
                                <span id="edit_urlSpan" class="remaining">
                                    <span class="char">250</span> @lang('characters remaining')
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="edit_status">@lang('Status')</label>
                              <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" id="edit_status" data-on="@lang('Enable')" data-off="@lang('Disable')" name="status">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT METHOD MODAL --}}
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation')!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.ad.delete') }}" method="POST">
                @csrf
                <input type="hidden" name="id" required="">

                <div class="modal-body">
                    <p class="font-weight-bold">@lang('Are you sure to delete this Advertisement')?</p>
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


@push('breadcrumb-plugins')
    <a href="javascript:void(0)" class="btn btn-sm btn--primary box--shadow1 text-white text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/common/custom.js') }}"></script>
@endpush

@push('script')
<script>
    (function ($) {

        "use strict";

        $('#display_image').hide();

        $('#image_btn').on('click', function() {
            var classNmae = $('#display_image').attr('class');
            if(classNmae != 'profilePicPreview has-image'){
                $('#display_image').hide();
            }else{
                $('#display_image').show();
            }
        });

        $('#image_remove_id').on('click', function(){
            $('.profilePicPreview').hide();
        });

        $('.addBtn').on('click', (e)=> {
            var modal = $('#addModal');
            modal.modal('show');
        });

        $('.editBtn').on('click', (e)=> {
            var $this = $(e.currentTarget);
            var modal = $('#editModal');
            modal.find('input[name=id]').val($this.data('id'));
            modal.find('input[name=url]').val($this.data('url'));
            modal.find('.profilePicPreview').attr('style',`background-image:url(${$this.data('image')})`);

            if($this.data('status') == 1){
                $('#edit_status').parent('div').removeClass('off');
                $('#edit_status').prop('checked', true);
            }else{
                 $('#edit_status').parent('div').addClass('off');
                 $('#edit_status').prop('checked', false);
            }

            let length = parseInt($this.data('url').length);
            modal.find('.char').text(250-length);

            modal.modal('show');
        });

        $('.deleteBtn').on('click', (e)=> {
            var $this = $(e.currentTarget);
            var modal = $('#deleteModal');
            modal.find('input[name=id]').val($this.data('id'));
            modal.modal('show');
        });

    })(jQuery);

</script>
@endpush

@push('style')
<style>
    .remaining{
        font-weight: bold;
        font-size: 14px;
        display: block;
        text-align: end;
    }
</style>
@endpush
