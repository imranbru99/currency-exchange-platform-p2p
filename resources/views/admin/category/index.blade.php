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
                                <th>@lang('Forum')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Icon')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $data)
                            <tr>
                                <td data-label="@lang('Name')">
                                    <span class="font-weight-bold">
                                        {{ substr(__(@$data->forum->name), 0, 50) }}
                                    </span>
                                </td>
                                <td data-label="@lang('Name')">
                                    <span class="font-weight-bold">
                                        {{ substr(__($data->name), 0, 50) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Icon')">
                                    @php echo $data->icon; @endphp
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
                                    data-name='{{ $data->name }}'
                                    data-icon='{{ $data->icon }}'
                                    data-status='{{ $data->status }}'
                                    data-forum='{{ $data->forum_id }}'
                                    data-des='{{ $data->description }}'
                                    class="icon-btn editBtn" data-toggle="tooltip" title="" data-original-title="@lang('Edit')">
                                        <i class="las la-edit text--shadow"></i>
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
                    {{ paginateLinks($categories) }}
                </div>
            </div>
        </div>

    </div>

{{-- ADD METHOD MODAL --}}
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add New Category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.category.add') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label for="forum">@lang('Forum')</label>
                            <select id="forum" name="forum" class="form-control select2-basic" required="">
                                <option value="">---@lang('Select Forum')---</option>
                                @foreach($forums as $forum)
                                    <option value="{{ $forum->id }}">{{ __($forum->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <input type="text" name="name" class="form-control" id="name" required
                                oninput="carRemaining('nameSpan', this.value, 191)"
                                >
                                <span id="nameSpan" class="remaining">
                                    191 @lang('characters remaining')
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="icon">@lang('Icon')</label>
                                 <div class="input-group has_append">
                                    <input type="text" class="form-control icon" id="icon" name="icon" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home" role="iconpicker"></button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="des">@lang('Description')</label>
                                <textarea class="form-control" name="des" id="des" oninput="carRemaining('desSpan', this.value, 60000)"></textarea>
                                <span id="desSpan" class="remaining">
                                    60000 @lang('characters remaining')
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
                <h5 class="modal-title">@lang('Update Category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.category.update') }}" method="POST">
                @csrf

                <input type="hidden" name="id" required="">

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label for="edit_forum">@lang('Forum')</label>
                            <select id="edit_forum" name="forum" class="form-control select2-basic" required="">
                                <option value="">---@lang('Select Forum')---</option>
                                @foreach($forums as $forum)
                                    <option value="{{ $forum->id }}">{{ __($forum->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="edit_name">@lang('Name')</label>
                                <input type="text" name="name" class="form-control" id="edit_name" required
                                oninput="carRemaining('edit_nameSpan', this.value, 191)">
                                <span id="edit_nameSpan" class="remaining">
                                    <span class="char">191</span> @lang('characters remaining')
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="edit_icon">@lang('Icon')</label>
                                 <div class="input-group has_append">
                                    <input type="text" class="form-control icon" name="icon" id="edit_icon" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home" role="iconpicker"></button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="edit_des">@lang('Description')</label>
                                <textarea class="form-control" name="des" id="edit_des" oninput="carRemaining('edit_desSpan', this.value, 60000)"></textarea>
                                <span id="edit_desSpan" class="remaining">
                                    <span class="desChar">60000</span> @lang('characters remaining')
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

@endsection


@push('breadcrumb-plugins')
    <a href="javascript:void(0)" class="btn btn-sm btn--primary box--shadow1 text-white text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/common/custom.js') }}"></script>
@endpush

@push('script')
<script>
    (function ($) {

        "use strict";

        $('.modal').on('shown.bs.modal', function(){
            $(document).off('focusin.modal');
        });

        $('.iconPicker').iconpicker({
            align: 'center', // Only in div tag
            arrowClass: 'btn-danger',
            arrowPrevIconClass: 'fas fa-angle-left',
            arrowNextIconClass: 'fas fa-angle-right',
            cols: 10,
            footer: true,
            header: true,
            icon: 'fas fa-bomb',
            iconset: 'fontawesome5',
            labelHeader: '{0} of {1} pages',
            labelFooter: '{0} - {1} of {2} icons',
            placement: 'bottom', // Only in button tag
            rows: 5,
            search: false,
            searchText: 'Search icon',
            selectedClass: 'btn-success',
            unselectedClass: ''
        }).on('change', function (e) {
            $(this).parent().siblings('.icon').val(`<i class="${e.icon}"></i>`);
        });

        $('.addBtn').on('click', (e)=> {
            var modal = $('#addModal');
            modal.modal('show');
        });

        $('.editBtn').on('click', (e)=> {
            var $this = $(e.currentTarget);
            var modal = $('#editModal');
            modal.find('input[name=id]').val($this.data('id'));
            modal.find('input[name=name]').val($this.data('name'));
            modal.find('input[name=icon]').val($this.data('icon'));
            modal.find('select[name=forum]').val($this.data('forum')).select2();
            modal.find('textarea[name=des]').val($this.data('des'));

            if($this.data('status') == 1){
                $('#edit_status').parent('div').removeClass('off');
                $('#edit_status').prop('checked', true);
            }else{
                $('#edit_status').parent('div').addClass('off');
                $('#edit_status').prop('checked', false);
            }

            let length = parseInt($this.data('name').length);
            modal.find('.char').text(191-length);

            let desLength = parseInt($this.data('des').length);
            modal.find('.desChar').text(60000-desLength);

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
