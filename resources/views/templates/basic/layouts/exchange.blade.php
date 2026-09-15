<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage" data-theme="light">

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

  
  
   <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('partials.seo')
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
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
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/main.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/premium.css') }}">
     
    @stack('style-lib')

    @stack('style')

  @include('partials.seo')

  <title>{{ $general->sitename(__($pageTitle)) }}</title>

</head>
  
<body>

   @include($activeTemplate. 'partials.auth_header')
   @include($activeTemplate. 'partials.others')
  
    @yield('content')

    @include($activeTemplate. 'partials.footer')
  
  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

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
    <script src="{{ asset($activeTemplateTrue. 'js/premium.js') }}"></script>

    @stack('script-lib')
    @stack('script')

  @include('partials.plugins')
  @include('partials.notify')

</body>

</html>
