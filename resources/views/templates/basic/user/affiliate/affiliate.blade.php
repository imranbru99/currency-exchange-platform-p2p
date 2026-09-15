@extends($activeTemplate.'layouts.master')
@section('content')

    <div class="container padding-top padding-bottom">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card section-bg">
                    <div class="card-header py-2 text-center">
                        <h4 class="m-0 text-white">@lang('Send Refferal Link')</h4>
                    </div>

                    <div class="card-body section-bg">
                        <form action="" method="POST" class="mb--16">
                            @csrf
                            <div class="input-group copy">

                                <input type="text" class="form-control rounded-custom" name="reffer_link" id="validationCustomUsername"
                                    placeholder="@lang('Username')" aria-describedby="inputGroupPrepend" required
                                    value="{{ route('user.refer.register', auth()->user()->username) }}" readonly>

                                <div class="input-group-append">
                                    <button class="input-group-text border-0 text-white" id="inputGroupPrepend">@lang('Copy Link')</button>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <label for="">@lang('Email to send Reffer Link')</label>
                                <input type="email" class="rounded" name="email" placeholder="@lang('Email')" required>
                            </div>


                            <div class="form-group text-right">
                                <input type="submit" class="rounded" value="send Email">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('style')
    <style>
        .mb--16 {
            margin-bottom: -16px;
        }
      .rounded-custom {
          border-radius: 4px 0 0 4px !important;
          -webkit-border-radius: 4px 0 0 4px !important;
          -moz-border-radius: 4px 0 0 4px !important;
      }
        .form-group input,
        .input-group input {
            color: #232323;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            height: 60px;
            padding: 0 25px;
            font-size: 20px;
            background: #fff;
            border: 1px solid #e5e5e5;
        }

        .form-group input:focus,
        .input-group input:focus {
            box-shadow: none;
        }
        .card-header {
            padding: 23px;
        }
        input[type=submit] {
            background: #5350ff;
            height: 50px;
            text-transform: uppercase;
            width: unset;
            padding: 0 25px;
            font-size: 16px;
            color: #fff;
        }

        #inputGroupPrepend {
            background: #5350ff;
            height: 100%;
        }

        svg {
            display: block;
            background-color: #13114a !important;
        }

    </style>
@endpush


@push('script')

    <script>
    
        'use strict';
        
        var copyButton = document.querySelector('.copy button');
        var copyInput = document.querySelector('.copy input');
        copyButton.addEventListener('click', function(e) {
            e.preventDefault();
            var text = copyInput.select();
            document.execCommand('copy');
        });
        copyInput.addEventListener('click', function() {
            this.select();
        });

    </script>
@endpush
