@extends('layouts.user')
@section('content')
    <div class="">
        <div class="container py-16">
            <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">Belanja Berdasarkan Kategori</h2>
            <div id="category-grid" class="grid grid-cols-3 gap-3">
                {{-- category here --}}
            </div>
        </div>
    </div>

    @php
        $token = session('auth_token');
    @endphp

    <div class="container pb-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">3 Produk Terlaris</h2>
        <div id="products" class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Products will be dynamically loaded here -->
        </div>
    </div>
@endsection

{{-- js --}}

@push('js')
    <script>
        // fetch category
        document.addEventListener("DOMContentLoaded", () => {
            fetch('/api/categories')
                .then(response => response.json())
                .then(data => {
                    const gridContainer = document.getElementById('category-grid');
                    data.data.forEach(category => {
                        const categoryElement = document.createElement('div');
                        categoryElement.className = 'relative rounded-sm overflow-hidden group';
                        categoryElement.innerHTML = `
                    <img src="${category.image}" alt="${category.name}" class="w-full">
                    <a href='/product/category/${category.id}' class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">${category.name}</a>
                `;
                        gridContainer.appendChild(categoryElement);
                    });
                })
                .catch(error => console.error('Error fetching categories:', error));

            fetch('/api/products/random')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const products = data.data;
                    const productsContainer = document.getElementById('products');
                    productsContainer.innerHTML = products.map(product => `
            <div class="bg-white shadow rounded overflow-hidden group flex flex-col">
                <div class="relative flex-grow">
                    <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover">
                </div>
                <div class="pt-4 pb-3 px-4 flex-grow">
                    <a href="#">
                        <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-primary transition">
                            ${product.name}
                        </h4>
                    </a>
                    <div class="flex items-baseline mb-1 space-x-2">
                        <p class="text-xl text-primary font-semibold">${product.price}</p>
                    </div>
                </div>
                <a href="#" class="block w-full py-1 text-center text-white bg-primary border border-primary rounded-b hover:bg-transparent hover:text-primary transition add-to-cart" data-product-id="${product.id}">
                    Add to cart
                </a>
            </div>
        `).join('');
                    // Add event listener for 'Add to cart' buttons
                    document.querySelectorAll('.add-to-cart').forEach(button => {
                        button.addEventListener('click', function(event) {
                            event.preventDefault();
                            const productId = this.getAttribute('data-product-id');
                            var authToken = @json(session('auth_token'));

                            fetch('/api/cart/add', {
                                    method: 'POST',
                                    headers: {
                                        'Authorization': `Bearer ${authToken}`,
                                        'Content-Type': 'application/json',
                                        'accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        product_id: productId
                                    })
                                })
                                .then(response => {
                                    if (response.status === 401) {
                                        window.location.href =
                                            '/login'; // Adjust the login URL if necessary
                                        return; // Exit the promise chain
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'success',
                                            title: data.message,
                                            showConfirmButton: false,
                                            timer: 3000
                                        });
                                    } else {
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'error',
                                            title: data.message,
                                            showConfirmButton: false,
                                            timer: 3000
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.log(error);
                                    console.error('Error adding product to cart:', error);
                                });
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                });
        });
    </script>
@endpush
