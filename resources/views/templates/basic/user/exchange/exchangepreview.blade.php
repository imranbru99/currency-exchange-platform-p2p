@extends($activeTemplate.'layouts.exchange')
@section('content')


    <div class="container padding-top padding-bottom">
        <div class="row">
                            <div class="col-md-12 mt-3">
                                        <div class="card section-bg">
                                                  <div class="card-header text-center">
                                                      <h5 class="text-white m-0">{{ $userSendData->name . ' TO ' . $userReceiveData->name }}
                                                      </h5>
                                                  </div>

                                                  <div class="card-body section-bg">
                                                      <h3>@lang('Please provide your correct account where we will provide your demanded currency')</h3>

                                                      <table class="table table-boardered">
                                                          <tr>
                                                              <td>@lang('Exchange ID') </td>
                                                              <td>{{$data->exchange_id}}</td>
                                                          </tr>
                                                          <tr>
                                                              <td>@lang('Amount send ')</td>
                                                          <td>{{ getAmount($data->get_amount)}} {{$userSendData->cur_sym}}</td>
                                                          </tr>
                                                          <tr>
                                                              <td>@lang('Total Amount receive') </td>
                                                              <td>{{ getAmount($data->send_amount) }} {{$userReceiveData->cur_sym}}</td>
                                                          </tr>
                                                          <tr>
                                                              <td>@lang('Total Transaction Fee')</td>
                                                          <td>{{ getAmount($data->charge)}} {{$userSendData->cur_sym}}</td>
                                                          </tr>


                                                      </table>
                                                  </div>
                                        </div>


                                <div class="card shadow mt-5 section-bg">
                                <div class="card-body section-bg">
                                    <form action="" method="POST" id="walletForm" name="walletform">
                                            @csrf
                                        @foreach(json_decode($userReceiveData->user_input) as $key => $input)

                                            @if($input->type == 'text')
                                                <div class="form-group">
                                                    <label for="">{{$input->field_name}}</label>
                                                <input type="text" name="{{str_replace(' ', '_', trim(strtolower($input->field_name)))}}" class="form-control input" id="input-{{$loop->iteration}}" placeholder="{{$input->field_name}}" {{$input->validation}}>
                                                </div>
                                            @endif

                                            @if($input->type == 'email')
                                                <div class="form-group">
                                                    <label for="">{{$input->field_name}}</label>
                                                <input type="email" name="{{str_replace(' ', '_', trim(strtolower($input->field_name)))}}" class="form-control input" id="input-{{$loop->iteration}}" placeholder="{{$input->field_name}}" {{$input->validation}}>
                                                </div>
                                            @endif


                                        @endforeach
                                            <div class="form-group">
                                                <input type="submit" id="form_submit" value="Confirm Exchange">
                                            </div>
                                    </form>
                                </div>
                            </div>
            </div>

            
        </div> 
    </div>

    {{-- confirm modal --}}
        <div class="modal fade" tabindex="-1" role="dialog" id="confirmModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirm Exchange')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-danger py-4">@lang('Are you sure your all information is correct ?') </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                <button type="button" id="submit_form_jq" class="btn btn-primary">@lang('Confirm Exchange')</button>
            </div>
            </div>
        </div>
        </div>

@endsection




@push('script')

    <script>
        'use strict';
        $(function() {
            
             $('#form_submit').on('click',function(e){        
            e.preventDefault();
            $('#confirmModal').modal('show');
        });

        $('#submit_form_jq').on('click',function(){
            $('#walletForm').submit();
        });
        })
       
    </script>
@endpush