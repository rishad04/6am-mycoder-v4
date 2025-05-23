<!DOCTYPE html>
<html lang="en">

<script>
    window.startTime = performance.now();
</script>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Rishad Task Submission At 6AmTech</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    {{-- CDN'S --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Favicons -->
    <link href="{{ asset('frontend/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('frontend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('frontend/assets/css/main.css') }}" rel="stylesheet">

    <style>
        /* body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        } */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #323232;
            color: #fff;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateX(150%);
            transition: transform 0.4s ease, opacity 0.4s ease;
            opacity: 0;
            z-index: 9999;
        }

        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }

        .notification .message {
            flex-grow: 1;
        }

        .notification .close-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
        }

        .img-2x1 {
            width: 2in;
            height: 1.5in;
            object-fit: cover;
            /* optional: crops to fill the space */
        }

        .p-5 {
            padding-right: 5px;
        }

        .pl-5 {
            padding-left: 5px;
        }

        .mr-5 {
            margin-right: 5px;
        }

        .float-right {
            position: absolute;
            bottom: 32px;
            right: 10px;
            padding-bottom: 10px;
        }

        .blink {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: red;
            border-radius: 50%;
            animation: blink-animation 1s infinite;
        }

        @keyframes blink-animation {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>

    <!-- =======================================================
  * Template Name: Sailor
  * Template URL: https://bootstrapmade.com/sailor-free-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <!-- Include your header here -->
    @include('frontend.partials.header')

    <main class="main">

        @yield('container')

        @include('frontend.partials.footer')
