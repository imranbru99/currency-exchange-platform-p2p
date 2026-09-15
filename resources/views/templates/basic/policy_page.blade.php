@extends($activeTemplate.'layouts.frontend')

@section('content')

    <!-- account section start -->
    <section>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-12">

            <div class="account-wrapper shadow-none p-0 border-0">

            	@php echo $pageContent->data_values->details; @endphp

            </div><!-- account-wrapper end -->
          </div>
        </div>
      </div>
    </section>
    <!-- account section end -->

@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.main-wrapper').addClass('d-flex flex-wrap justify-content-center align-items-center h-100');

        })(jQuery);
    </script>
@endpush
