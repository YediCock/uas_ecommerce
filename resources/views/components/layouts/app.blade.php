<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="multikit">
    <meta name="keywords" content="multikit">
    <title>SkincareStore</title>
    {{-- <link rel="manifest" href="manifest.json"> --}}
    <meta name="theme-color" content="#ff8d2f">
    {{-- <meta name="apple-mobile-web-app-capable" content="yes"> --}}
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="multikit">
    <meta name="msapplication-TileImage" content="/frontend/assets/images/favicon/1.svg">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/frontend/assets/images/favicon/2.svg" type="image/x-icon">
    <link rel="shortcut icon" href="/" type="image/x-icon">

    <!-- Google font css link  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap">

    <!-- Bootstrap css -->
    <link id="rtl-link" rel="stylesheet" type="text/css" href="/frontend/assets/css/vendors/bootstrap.css">

    <!-- Loader Normalize css -->
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/normalize.min.css">

    <!-- Swiper css -->
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/vendors/swiper/swiper-bundle.min.css">

    <!-- Remix Icon css -->
    <link rel="stylesheet" type="text/css" href="/frontend/assets/css/remixicon.css">

    <!-- Style css -->
    <link id="change-link" rel="stylesheet" type="text/css" href="/frontend/assets/scss/style.css">
    
    <!-- My css -->
    <link id="change-link" rel="stylesheet" type="text/css" href="/frontend/assets/css/mystyle.css">

    {{-- modal prod--}}
    <style>
        .modal-backdrop {
            display: none !important;
        }
        .modal {
            background-color: rgba(0, 0, 0, 0.3); /* Warna hitam dengan opacity 0.5 */
        }
    </style>
    @stack('css')
</head>

<body class="ecommerce-color">
    {{ $slot }}
    <!-- Divider Section Start -->
    <div class="pt-1">
        <div class="bottom-space"></div>
    </div>
    <!-- Divider Section End -->

    <!-- Bootstrap js-->
    <script src="/frontend/assets/js/vendors/bootstrap/bootstrap.bundle.min.js"></script>

    <!-- Loader js -->
    <script src="/frontend/assets/js/loader.js"></script>

    <!-- swiper js -->
    <script src="/frontend/assets/js/swiper-bundle.min.js"></script>
    <script src="/frontend/assets/js/custom_swiper.js"></script>

    <!-- Theme js-->
    <script src="/frontend/assets/js/script.js"></script>
    
    {{-- my js --}}
    <script src="/frontend/assets/js/myscript.js"></script>

    <!-- Theme Settings js-->
    {{-- <script src="/frontend/assets/js/theme-setting.js"></script> --}}

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <x-livewire-alert::flash />
    
</body>

</html>