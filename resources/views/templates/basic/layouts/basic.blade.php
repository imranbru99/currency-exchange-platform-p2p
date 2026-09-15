<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  @include($activeTemplate.'partials.theme_boot')

  {{-- old start  --}}
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-229612508-1"></script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-229612508-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-229612508-1');
</script>

      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/all.min.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/animate.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/odometer.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/nice-select.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/swiper.min.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/magnific-popup.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/flaticon.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'gold/css/main.css') }}">
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
<div class="main-wrapper">
    
  @yield('content')

  </div>

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
  <!-- main js -->
  <script src="{{ asset($activeTemplateTrue. 'js/app.js') }}"></script>
  <script src="{{ asset($activeTemplateTrue. 'js/premium.js') }}"></script>  
  <script src="{{ asset($activeTemplateTrue . 'gold/js/main.js') }}"></script>
  @stack('script-lib')
  @stack('script')
  @include('partials.plugins')
  @include('partials.notify')

  
  </body>
</html> 