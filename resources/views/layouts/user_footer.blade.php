<footer class="bg-white pt-16 pb-12 border-t border-gray-100">
    <div class="container grid grid-cols-1 ">
        <div class="col-span-1 space-y-4">
            <h5 class="font-bold"><span class="text-red-500">ZAM</span>STORE</h5>

            <div class="mr-2">
                <p class="text-gray-500">
                    Terima kasih telah berbelanja di Zamstore!
                    Jadikan ruang Anda lebih indah dengan furniture terbaik dari kami.
                </p>
            </div>
            <div class="flex space-x-5">
                <a href="#" class="text-gray-400 hover:text-gray-500"><i
                        class="fa-brands fa-facebook-square"></i></a>
                <a href="#" class="text-gray-400 hover:text-gray-500"><i
                        class="fa-brands fa-instagram-square"></i></a>
                <a href="#" class="text-gray-400 hover:text-gray-500"><i
                        class="fa-brands fa-twitter-square"></i></a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-brands fa-github-square"></i>
                </a>
            </div>
        </div>

        <div class="col-span-2 grid grid-cols-2 gap-4">
        </div>
    </div>
</footer>
<div class="bg-gray-800 py-4">
    <div class="container flex items-center justify-between">
        <p class="text-white">&copy; mohammadtajutzamzami07@gmail.com - All Right Reserved</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@stack('js')

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
</script>

</body>

</html>
