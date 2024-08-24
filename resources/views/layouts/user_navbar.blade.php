<body>
    <!-- header -->
    <header class="py-4 shadow-sm bg-white">
        <div class="container flex items-center justify-between">
            <a href="/">
                <h5 class="font-bold"><span class="text-red-500">ZAM</span>STORE</h5>
            </a>
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('user.cart') }}" class="text-center text-gray-700 hover:text-primary transition relative">
                        <div class="text-2xl">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <div class="text-xs leading-3">Cart</div>
                        <div
                            class="absolute -right-3 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-primary text-white text-xs">
                            {{ $cartCheckouted }}</div>
                    </a>
                    <a href="{{ route('user.profile') }}"
                        class="text-center text-gray-700 hover:text-primary transition relative">
                        <div class="text-2xl">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div class="text-xs leading-3">Account</div>
                    </a>
                @endauth
            </div>
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
                    <form action="{{ route('logout') }}" class="inline" method="post">
                        @csrf
                        <button type="submit" class="text-gray-200 hover:text-white transition">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>
    <div class="bg-cover bg-no-repeat bg-center py-36"
        style="background-image: url('{{ url('/') }}/assets/images/banner-bg.jpg');">
        <div class="container">
            <h1 class="text-6xl text-gray-800 font-medium mb-4 capitalize">
                Temukan Furniture Impianmu <br>di <span class="text-red-500">ZAM</span>STORE
            </h1>
            <p>Kualitas Terbaik, Desain Elegan, Harga Terjangkau.
                Hadirkan Kenyamanan dan Keindahan di Setiap Sudut Ruanganmu!</p>
            <div class="mt-12">
                <a href="/dashboard/#products"
                    class="bg-primary border border-primary text-white px-8 py-3 font-medium
                    rounded-md hover:bg-transparent hover:text-primary">Shop
                    Now</a>
            </div>
        </div>
    </div>
