@extends('admin.layouts.app')
@section('panel')

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-xl-5">

            <div class="card">
                <div class="card-header bg--primary">
                    <h3 class="title text-white">@lang('Current Setting')</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-4">
                        <tr>
                            <td col="level">@lang('Level')</td>
                            <td col="comission">@lang('Comission')</td>
                        </tr>
                        @foreach ($refferal as $ref)
                            <tr>
                                <td data-label="@lang('level')">@lang('Level#') {{ $ref->level }}</td>
                                <td data-label="@lang('comission')">{{ $ref->percent }} %</td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="row">
                        <div class="col-md-6">
                            <input type="number" name="level" id="levelGenerate"
                                placeholder="@lang('HOW MANY LEVEL')" class="form-control input-lg">
                        </div>
                        <div class="col-md-6">

                            <button type="button" id="generate"
                                class="btn btn-success btn-block btn-md">@lang('GENERATE')</button>
                        </div>
                    </div>

                    <form action="" id="form_generate" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="text-success"> @lang('Level & Commission :') <small>@lang('Old Levels will
                                    Remove After Generate')</small> </label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="description">
                                        <div class="row">
                                            <div class="col-md-12" id="planDescriptionContainer">

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </form>
                </div>
            </div>

        @endsection


        @push('style')
            <style>
                #form_generate{
                    display: none
                }
                .card {
                    box-shadow: none;
                }

                .description {
                    width: 100%;
                    border: 1px solid #ddd;
                    padding: 10px;
                    border-radius: 5px
                }

            </style>
        @endpush

        @push('script')
            <script>
                'use strict';
                
                var max = 1;
                $(document).ready(function() {
                    $("#generate").on('click', function() {

                        var da = $('#levelGenerate').val();
                        var a = 0;
                        var val = 1;
                        var htmlData = '';
                        if (da !== '' && da > 0) {
                            if(da > 200){
                                return false;
                            }
                            $('#form_generate').css('display', 'block');

                            for (a; a < parseInt(da); a++) {

                                
                                htmlData += '<div class="input-group" style="margin-top: 5px">\n' +
                                    '<input name="level[]" class="form-control margin-top-10" type="number" readonly value="' +
                                    val++ + '" required placeholder="Level">\n' +
                                    '<input name="percent[]" class="form-control margin-top-10" type="text" required placeholder="Commission Percentage %">\n' +
                                    '<span class="input-group-btn">\n' +
                                    '<button class="btn btn-danger margin-top-10 ml-3 delete_desc" type="button"><i class=\'fa fa-times\'></i></button></span>\n' +
                                    '</div>'
                            }
                            $('#planDescriptionContainer').html(htmlData);

                        } else {
                            alert('Level Field Is Required')
                        }

                    });

                    $(document).on('click', '.delete_desc', function() {
                        $(this).closest('.input-group').remove();
                    });
                });

            </script>
        @endpush
