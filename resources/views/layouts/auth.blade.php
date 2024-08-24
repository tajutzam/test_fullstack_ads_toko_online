<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zam Store || Login</title>

    <link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon">
    @vite('resources/css/app.css')

    <link rel="stylesheet" href="assets/css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <!-- header -->
    <header class="py-4 shadow-sm bg-white">
        <div class="container flex items-center justify-between">
            <a href="/">
                <h5 class="font-bold"><span class="text-red-500">ZAM</span>STORE</h5>
            </a>
            @auth
                <a href="{{ route('user.profile') }}"
                    class="text-center text-gray-700 hover:text-primary transition relative">
                    <div class="text-2xl">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="text-xs leading-3">Account</div>
                </a>
            @endauth
        </div>
    </header>
    <!-- ./header -->

    <!-- navbar -->
    <nav class="bg-gray-800">
        <div class="container flex">
            <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="/" class="text-gray-200 hover:text-white transition">Home</a>
                </div>
                @guest
                    <a href="{{ url('/') }}/login" class="text-gray-200 hover:text-white transition">Login</a>
                @endguest

                @auth
                    <a href="{{ url('/') }}/login" class="text-gray-200 hover:text-white transition">Logout</a>
                @endauth
            </div>
        </div>
    </nav>

    @yield('content')
    @include('layouts.user_footer')
