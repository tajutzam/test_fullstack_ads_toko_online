@extends('layouts.user')


@push('style')
    <style>
        .tab-button.active {
            background-color: #3b82f6;
            color: white;
        }
    </style>
@endpush


@section('content')
    <div class="container mx-auto my-10">
        <h3 class="text-center text-3xl font-semibold mb-8">Keranjang</h3>

        <!-- Tabs -->
        <div class="flex justify-center mb-4">
            <button class="tab-button mx-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 active"
                data-status="all">
                All
            </button>
            <button class="tab-button mx-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400" data-status="pending">
                Pending
            </button>
            <button class="tab-button mx-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400" data-status="paid">
                Paid
            </button>
            <button class="tab-button mx-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400" data-status="done">
                Done
            </button>
            <button class="tab-button mx-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400" data-status="canceled">
                Canceled
            </button>
            <button class="tab-button mx-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400" data-status="shipping">
                Shiping
            </button>
        </div>

        <!-- Tab Content -->
        <div id="order-content">
            @php
                $total = 0;
            @endphp

            @if (empty($carts) || count($carts) === 0)
                <p class="text-center text-gray-600">No items have been checked out yet.</p>
            @else
                @foreach ($carts as $sellerId => $cart)
                    <!-- Display Seller Information -->
                    <div class="mb-6 order-item" data-status="{{ strtolower($cart->status) }}">
                        <h4 class="text-2xl font-semibold mb-4">Seller: {{ $cart->seller->name }}</h4>
                        <span class="text-sm bg-red-500 rounded-sm py-2 px-2 text-white">{{ $cart->status }}</span>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full bg-white shadow-lg rounded-lg mt-6">
                                <thead>
                                    <tr class="bg-gray-200 text-left">
                                        <th class="px-4 py-2">Product Name</th>
                                        <th class="px-4 py-2">Product Image</th>
                                        <th class="px-4 py-2 text-center">Quantity</th>
                                        <th class="px-4 py-2 text-right">Price</th>
                                        <th class="px-4 py-2 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart->cartDetails as $item)
                                        <tr class="border-t">
                                            <td class="px-4 py-2">{{ $item->product->name }}</td>
                                            <td class="px-4 py-2">
                                                <img class="h-20 w-20 rounded-md"
                                                    src="{{ asset('/uploads/products/') }}/{{ $item->product->image }}"
                                                    alt="products">
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <!-- Quantity Controls -->
                                                <div class="inline-flex items-center">
                                                    <button
                                                        @if ($cart->status == 'paid') @disabled(true) @endif
                                                        class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400 decrease-quantity"
                                                        data-id="{{ $item->id }}">−</button>
                                                    <input type="number"
                                                        class="w-14 text-center mx-2 px-2 border rounded quantity-input"
                                                        value="{{ $item->qty }}" min="1"
                                                        data-id="{{ $item->id }}">
                                                    <button
                                                        @if ($cart->status != 'pending') @disabled(true) @endif
                                                        class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400 increase-quantity"
                                                        data-id="{{ $item->id }}">+</button>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 text-right">Rp
                                                {{ number_format($item->product->price, 2) }}
                                            </td>
                                            <td class="px-4 py-2 text-right">
                                                <span class="sub-price" data-subprice-id="{{ $item->id }}">Rp
                                                    {{ number_format($item->sub_price, 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-right mt-4">
                            <strong data-totalseller-id="{{ $cart->id }} ">Subtotal
                                for
                                {{ $cart->seller->name }}: </strong>
                            <span class="subtotal" data-seller-id="{{ $sellerId }}">
                                Rp
                                {{ number_format(
                                    array_sum(
                                        array_map(function ($cartDetail) use (&$total) {
                                            $total += $cartDetail['sub_price'];
                                            return $cartDetail['sub_price'];
                                        }, $cart->cartDetails->toArray()),
                                    ),
                                    2,
                                ) }}
                            </span>
                        </div>
                        <div class="text-right mt-3">
                            @if ($cart->status == 'pending')
                                <button data-seller-name="{{ $cart->seller->name }}" data-seller-id="{{ $sellerId }}"
                                    data-price-id="{{ $cart->total_price }}" data-order-id="{{ $cart->id }}"
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 checkout-button">
                                    Bayar {{ $cart->seller->name }}
                                </button>
                            @else
                                @if ($cart->status == 'shipping')
                                    <form action="{{ route('user.order.done', ['id' => $cart->id]) }}" method="post">
                                        @method('put')
                                        @csrf
                                        <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                            Pesanan dalam status {{ $cart->status }} Selesaikan Pesanan
                                        </button>
                                    </form>
                                @else
                                    @if ($cart->status == 'done')
                                        <button @disabled(true)
                                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                            Pesanan telah diterima
                                        </button>
                                    @else
                                        <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                            Pesanan dalam status {{ $cart->status }}
                                        </button>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>


    <!-- Modal for Checkout -->
    <div id="checkoutModal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background backdrop -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity ease-out duration-300" aria-hidden="true">
        </div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal panel -->
                <div
                    class="text-start bg-white rounded-lg p-6 w-full max-w-lg mx-4 md:mx-0 shadow-lg transform transition-transform duration-300">
                    <h3 class="text-2xl font-semibold mb-4 text-gray-800">Enter Your Details</h3>
                    <form id="checkoutForm" method="POST">
                        @csrf
                        <input type="hidden" name="seller_id" id="sellerId">
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">Phone Number</label>
                            <input type="text" name="phone" id="phone"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                                required placeholder="Enter your phone number">
                        </div>
                        <div class="mb-6">
                            <label for="address" class="block text-gray-700 text-sm font-medium mb-2">Address</label>
                            <textarea name="address" id="address" rows="4"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                                required placeholder="Enter your address"></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="address" class="block text-gray-700 text-sm font-medium mb-2">Total Harga</label>
                            <textarea name="amount" id="amountInput" rows="4" readonly
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                                required placeholder="Enter your address"></textarea>
                        </div>
                        <input type="text" id="cart_id" name="cart_id" hidden>
                        <div class="flex justify-end space-x-4">
                            <button type="submit" style="background-color: blue"
                                class="px-6 py-2 bg-blue-500 rounded-sm text-white hover:bg-blue-600 transition duration-150">Submit</button>
                            <button type="button" style="background-color: red"
                                class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-150"
                                onclick="closeModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key=""></script>
    <script>
        document.getElementById('checkoutForm').addEventListener('submit', async function(event) {
            event.preventDefault(); // Mencegah pengiriman form default

            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;
            const amount = document.getElementById('amountInput').value;
            const cartId = document.getElementById('cart_id').value;
            const authToken = @json(session('auth_token'));

            // Payload yang dikirim ke server
            const payload = {
                phone: phone,
                address: address,
                amount: amount,
                cart_id: cartId
            };

            try {
                const response = await fetch("{{ route('payment') }}", {
                    method: 'POST',
                    headers: {
                        "Authorization": "Bearer " + authToken,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload)
                });

                console.log(payload)

                const result = await response.json();
                if (response.ok) {
                    snap.pay(result, {
                        onSuccess: function(result) {
                            closeModal();
                        },
                        onPending: function(result) {
                            console.log(result);
                            closeModal();
                        },
                        onError: function(result) {
                            console.log(result);
                            closeModal();
                        }
                    });
                } else {
                    closeModal();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: result.error,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                // Handle fetch errors (e.g., show error message to the user)
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const decreaseButtons = document.querySelectorAll('.decrease-quantity');
            const increaseButtons = document.querySelectorAll('.increase-quantity');

            const updateQuantity = (cartDetailId, qty) => {
                var authToken = @json(session('auth_token'));
                fetch(`/api/cart/update-quantity/${cartDetailId}`, {
                        method: 'POST',
                        headers: {
                            "Authorization": "Bearer " + authToken,
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            qty: qty
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                        document.querySelector(`[data-subprice-id="${cartDetailId}"]`).innerText = 'Rp ' +
                            data.subtotal;
                        location.reload();

                    })
                    .catch(error => console.error('Error:', error));
            };

            decreaseButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    const input = e.target.parentElement.querySelector('.quantity-input');
                    let newQty = parseInt(input.value) - 1;
                    if (newQty >= 1) {
                        input.value = newQty;
                        updateQuantity(e.target.getAttribute('data-id'), newQty);
                    }
                });
            });

            increaseButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    const input = e.target.parentElement.querySelector('.quantity-input');
                    let newQty = parseInt(input.value) + 1;
                    input.value = newQty;
                    updateQuantity(e.target.getAttribute('data-id'), newQty);
                });
            });
            quantityInputs.forEach(input => {
                input.addEventListener('change', (e) => {
                    let newQty = parseInt(e.target.value);
                    if (newQty >= 1) {
                        updateQuantity(e.target.getAttribute('data-id'), newQty);
                    } else {
                        e.target.value = 1;
                        updateQuantity(e.target.getAttribute('data-id'), 1);
                    }
                });
            });


            const checkoutButtons = document.querySelectorAll('.checkout-button');
            const modal = document.getElementById('checkoutModal');
            const sellerIdInput = document.getElementById('sellerId');
            const amountInput = document.getElementById('amountInput');
            const cart_id = document.getElementById('cart_id');



            checkoutButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    const sellerId = e.target.getAttribute('data-seller-id');
                    const totalPrice = e.target.getAttribute('data-price-id');
                    const orderId = e.target.getAttribute('data-order-id');

                    sellerIdInput.value = sellerId;
                    amountInput.value = totalPrice;
                    cart_id.value = orderId;
                    modal.classList.remove('hidden');
                    modal.classList.add('opacity-100');
                });
            });


            const tabs = document.querySelectorAll('.tab-button');
            const orderItems = document.querySelectorAll('.order-item');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const status = this.getAttribute('data-status');

                    // Remove active class from all tabs
                    tabs.forEach(tab => tab.classList.remove('bg-blue-500', 'text-white',
                        'active'));
                    this.classList.add('bg-blue-500', 'text-white', 'active');

                    // Show/Hide Orders based on status
                    orderItems.forEach(item => {
                        const itemStatus = item.getAttribute('data-status');
                        if (status === 'all' || status === itemStatus) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                });
            });

        });
        const modal = document.getElementById('checkoutModal');

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('opacity-100');
        }
    </script>

@endsection
