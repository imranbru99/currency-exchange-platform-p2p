<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  @include($activeTemplate.'partials.theme_boot')

  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-229612508-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-229612508-1');
</script>


    {{-- old start  --}}

      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      @include('partials.seo')
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/bootstrap-fileinput.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/all.min.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/animate.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/odometer.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/nice-select.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/swiper.min.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/magnific-popup.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/flaticon.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/main.css') }}">
      <link href="{{ asset($activeTemplateTrue . 'gold/css/color.php') }}?color={{ $general->base_color }}"
          rel="stylesheet" />
       
      @stack('style-lib')
  
      @stack('style')
  
  
  
      {{-- old end  --}}

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  @include('partials.seo')

  <title>{{ $general->sitename(__($pageTitle)) }}</title>

  <!-- bootstrap 5  -->
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/lib/bootstrap.min.css') }}">
  <!-- fontawesome 5  -->
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/all.min.css') }}">
  <!-- lineawesome font -->
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/line-awesome.min.css') }}">
  <!-- main css -->
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/main.css') }}">

  <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/color.php?color='.$general->base_color.'&secondColor='.$general->secondary_color) }}">
  <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/premium.css') }}">

  @stack('style-lib')

  @stack('style')

  </head>

  <body>
 @include($activeTemplate. 'partials.auth_header')
   @include($activeTemplate. 'partials.others')


    @stack('fbComment')

    <!-- scroll-to-top start -->
    <div class="scroll-to-top">
      <span class="scroll-icon">
        <i class="las la-arrow-up"></i>
      </span>
    </div>
    <!-- scroll-to-top end -->

    <div class="preloader-holder">
      <div class="preloader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>


@yield('content')



  @include($activeTemplate. 'partials.footer')
  
    
{{-- old start  --}}
    <script src="{{ asset($activeTemplateTrue . 'gold/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'gold/js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'gold/js/plugins.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'gold/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'gold/js/bootstrap-fileinput.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'gold/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'gold/js/swiper.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'gold/js/wow.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'gold/js/odometer.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'gold/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'gold/js/nice-select.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'gold/js/main.js') }}"></script>
      {{-- old end  --}}
    <!-- jQuery library -->
  <script src="{{ asset($activeTemplateTrue. 'js/lib/jquery-3.6.0.min.js') }}"></script>
  <!-- bootstrap js -->
  <script src="{{ asset($activeTemplateTrue. 'js/lib/bootstrap.bundle.min.js') }}"></script>

  @stack('script-lib')

  <!-- main js -->
  <script src="{{ asset($activeTemplateTrue. 'js/app.js') }}"></script>
  <script src="{{ asset($activeTemplateTrue. 'js/premium.js') }}"></script>

  @stack('script')

  @include('partials.plugins')

  @include('partials.notify')

  <script>

        (function ($) {
            "use strict";

            $(".langSel").on("change", function() {
                window.location.href = "{{route('home')}}/change/"+$(this).val() ;
            });

            let navLink = $('#navLink ul a');
            let currentRoute = '{{ url()->current() }}'

            $.each(navLink, function(index, value) {
                if(value.href == currentRoute){
                  let li = value.closest('li');
                  $(li).addClass('active');
                }
            });


        })(jQuery);

    </script>

  </body>
</html>
