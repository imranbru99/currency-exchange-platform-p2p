@extends($activeTemplate.'layouts.exchange')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card section-bg">
                    <div class="card-header">
                        <h5 class="title text-white text-center m-0">@lang('Payment confirmation Page')</h5>
                    </div>
                    <div class="card-body section-bg">
                        <p>@lang('If you send the payment for your exchange, You will get your complete exchange.')</p>
                        <p>@lang('If you do not send the payment for completing exchange, Your exchange must not be completed. keep remind')</p>

                        <h3>{{ $exchange->payment_from_getway->name }} {{ getAmount($exchange->get_amount) }}

                            {{ $exchange->payment_from_getway->cur_sym }} To {{ $exchange->payment_to_getway->name }}
                            {{ getAmount($exchange->send_amount) }} {{ $exchange->payment_to_getway->cur_sym }}
                        </h3>
                  <div class="row justify-content-center">
                        <p class="my-4 text-center"> @php echo $currency->receving_details @endphp  <a onclick="myFunction()" href="#" class="w3-right w3-btn"><span class="w3-hide-small" style="color:red"> <i class="fa-solid fa-copy"></i> </span></a></p>
                      
                        <input type="text" value="{{ $currency->account_details }}"  id="myInput" hidden>
                     </div>
                  </div>


                                                    <form action="" method="POST" enctype="multipart/form-data">
                                                        @csrf

                                                        @foreach (json_decode($currency->user_proof) as $proof)
                                                          @if ($proof->type == 'file')


                                                                <div class="image-show">
                                                                    <img src="" alt="" id="image" class="img-fluid w-100" >
                                                                </div>

                                                            <div class="custom-file mb-3">

                                                                <div>
                                                                <input type="{{ $proof->type }}" class="custom-file-input" id="customFile" name="{{ str_replace(' ', '_', strtolower($proof->field_name)) }}" placeholder="{{ $proof->field_name }}" {{ $proof->validation }}>
                                                                    <label class="custom-file-label" for="customFile">@lang('Choose file')</label>
                                                                </div>

                                                            </div>

                                                            @continue

                                                          @endif
                                                            <div class="form-group mt-4">
                                                                <label for="">{{ trans(strtoupper($proof->field_name)) }}</label>
                                                                <input type="{{ $proof->type }}" name="{{ str_replace(' ', '_', strtolower($proof->field_name)) }}" class="form-control"  {{ $proof->validation }}>
                                                            </div>
                                                        @endforeach




                                                        <div class="form-group m-0">
                                                            <input type="submit" value="Exchange Request" class="bg_theme">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>


@endsection




@push('script')
                            <script>
                                'use strict';
                                    $(".custom-file-input").on("change", function() {
                                    var fileName = $(this).val().split("\\").pop();
                                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                    });

                                     function showImagePreview(input) {
                                            if (input.files && input.files[0]) {
                                                var reader = new FileReader();

                                                reader.onload = function (e) {
                                                    $('#image').attr('src', e.target.result);
                                                }

                                                reader.readAsDataURL(input.files[0]);
                                            }
                                        }

                                    $("#customFile").on('change' , function(){
                                    showImagePreview(this);
                                    });



                                    function myFunction() {
  // Get the text field
  var copyText = document.getElementById("myInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

   // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);

  // Alert the copied text
  alert("Copied: " + copyText.value);
}
                        </script>
@endpush
