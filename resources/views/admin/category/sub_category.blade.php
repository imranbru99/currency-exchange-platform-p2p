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
                                <th>@lang('Category')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($subCategories as $data)
                            <tr>
                                <td data-label="@lang('Category')">
                                    <span class="font-weight-bold">
                                        {{ substr(__($data->category->name), 0, 20) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Name')">
                                     <span class="font-weight-bold">
                                        {{ substr(__($data->name), 0, 20) }}
                                    </span>
                                </td>
                                <td data-label="@lang('Status')">
                                    @if($data->status == 1)
                                        <span class="badge badge--success">@lang('Enable')</span>
                                    @else
                                        <span class="badge badge--danger">@lang('Disable')</span>
                                    @endif
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="javascript:void(0)"
                                    data-id='{{ $data->id }}'
                                    data-name='{{ $data->name }}'
                                    data-status='{{ $data->status }}'
                                    data-category='{{ $data->category_id }}'
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
                    {{ paginateLinks($subCategories) }}
                </div>
            </div>
        </div>

    </div>

{{-- ADD METHOD MODAL --}}
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add New Sub Category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.add.sub.category') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label for="category">@lang('Category')</label>
                            <select id="category" name="category" class="form-control select2-basic" required="">
                                <option value="">---@lang('Select Category')---</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ __($category->name) }}</option>
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
                <h5 class="modal-title">@lang('Update Sub Category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.update.sub.category') }}" method="POST">
                @csrf

                <input type="hidden" name="id" required="">

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label for="edit_category">@lang('Category')</label>
                            <select id="edit_category" name="category" class="form-control select2-basic" required="">
                                <option value="">---@lang('Select Category')---</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="edit_name">@lang('Name')</label>
                                <input type="text" name="name" class="form-control" id="edit_name" required
                                oninput="carRemaining('edit_nameSpan', this.value, 191)"
                                >
                                <span id="edit_nameSpan" class="remaining">
                                    <span class="nameChar">191</span> @lang('characters remaining')
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
            let modal = $('#addModal');
            modal.modal('show');
        });

        $('.editBtn').on('click', (e)=> {
            let $this = $(e.currentTarget);
            let modal = $('#editModal');
            modal.find('input[name=id]').val($this.data('id'));
            modal.find('input[name=name]').val($this.data('name'));
            modal.find('input[name=icon]').val($this.data('icon'));
            modal.find('select[name=category]').val($this.data('category')).select2();
            modal.find('textarea[name=des]').val($this.data('des'));

            let nameLength = parseInt($this.data('name').length);
            modal.find('.nameChar').text(191-nameLength);

            if($this.data('status') == 1){
                $('#edit_status').parent('div').removeClass('off');
                $('#edit_status').prop('checked', true);
            }else{
                $('#edit_status').parent('div').addClass('off');
                $('#edit_status').prop('checked', false);
            }

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
