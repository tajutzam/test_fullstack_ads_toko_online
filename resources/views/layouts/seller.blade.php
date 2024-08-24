<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sidebar</title>
    @vite('resources/css/app.css')
    <link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <style>
        @media (max-width: 1024px) {
            aside {
                transition: all 0.3s ease;
            }

            aside.closed {
                transform: translatex(-100%);
            }
        }
    </style>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>

<body>
    <div class='flex bg-gray-100'>
        <aside
            class='h-screen bg-white fixed lg:sticky top-0 border-r-2 p-6 pt-10 whitespace-nowrap z-10 closed shadow-xl '>
            <div class='mb-10 flex items-center justify-between '>
                <div class=' p-2 bg-purple-600 text-white rounded'>
                    <i data-feather='box'></i>
                </div>

                <button class='lg:hidden bg-gray-200 text-gray-500 rounded leading-none p-1 btn-close-menu'>
                    <i data-feather='chevron-left'></i>
                </button>
            </div>
            <ul id="sidebar-menu" class='text-gray-500 font-semibold flex flex-col gap-2'>
                <li>
                    <a href="{{ route('seller.dashboard') }}" data-url="{{ route('seller.dashboard') }}"
                        class='flex items-center rounded px-3 py-2 hover:text-black hover:bg-gray-50 transition-all'>
                        <i data-feather="home" style='width: 1.2em' class='mr-3'></i>
                        <span class='flex-grow'>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('seller.products.index') }}" data-url="{{ route('seller.products.index') }}"
                        class='flex items-center rounded px-3 py-2 hover:text-black hover:bg-gray-50 transition-all'>
                        <i data-feather="archive" style='width: 1.2em' class='mr-3'></i>
                        <span class='flex-grow'>Product</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('seller.orders') }}" data-url="{{ route('seller.orders') }}"
                        class='flex rounded px-3 py-2 hover:text-black hover:bg-gray-50 transition-all'>
                        <span class='flex items-center gap-3'>
                            <i data-feather="dollar-sign" style='width: 1.2em'></i>
                            Orders
                        </span>
                    </a>
                </li>
                <li class='border my-2'></li>
                <li>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit">
                            <span class='flex items-center gap-3'>
                                <i data-feather="log-out" style='width: 1.2em'></i>
                                Logout
                            </span>
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <div class='w-full'>
            <header class='px-6 lg:px-8 pb-4 lg:pb-6 pt-6 lg:pt-10 shadow bg-white mb-1 sticky top-0'>
                <h1 class='text-xl font-semibold mb-6 flex items-center'>
                    <button class='btn-open-menu inline-block lg:hidden mr-6'>
                        <i data-feather='menu'></i>
                    </button>
                    <span>{{ $title }}</span>
                </h1>
            </header>
            <main class='px-6 py-8 lg:px-8 bg-gray-100 flex flex-col gap-6 '>
                @yield('content')
            </main>
        </div>
    </div>

    @stack('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: '{{ $errors->first() }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif
        });

        feather.replace();

        const btnOpenMenu = document.querySelector(".btn-open-menu");
        const btnCloseMenu = document.querySelector(".btn-close-menu");
        const aside = document.querySelector("aside");
        const body = document.querySelector("body");
        const menuItems = document.querySelectorAll("#sidebar-menu a");

        // Set active class based on current URL
        const currentUrl = window.location.href;
        menuItems.forEach((item) => {
            const url = item.getAttribute('data-url');
            if (currentUrl === url) {
                item.classList.add('text-black', 'bg-gray-100');
            } else {
                item.classList.remove('text-black', 'bg-gray-100');
            }
        });

        btnOpenMenu.addEventListener("click", (event) => {
            event.stopPropagation();
            aside.classList.remove("closed");
            body.classList.add("pointer-events-none", "overflow-hidden");
            aside.classList.add("pointer-events-auto");
        });

        btnCloseMenu.addEventListener("click", (event) => {
            aside.classList.add("closed");
            body.classList.remove("pointer-events-none", "overflow-hidden");
        });

        aside.addEventListener("click", (event) => {
            event.stopPropagation();
        });

        document.addEventListener("click", (event) => {
            aside.classList.add("closed");
            body.classList.remove("pointer-events-none", "overflow-hidden");
        });
    </script>
</body>

</html>
