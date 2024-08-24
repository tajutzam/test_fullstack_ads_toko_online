@extends('layouts.seller')

@section('content')
    <div class="container">
        <table class="mt-4 w-full border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Order ID</th>
                    <th class="border px-4 py-2">Customer Name</th>
                    <th class="border px-4 py-2">Total Amount</th>
                    <th class="border px-4 py-2">Order Date</th>
                    <th class="border px-4 py-2">Payment Status</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td class="border px-4 py-2">{{ $order->id }}</td>
                        <td class="border px-4 py-2">{{ $order->user->name }}</td>
                        <td class="border px-4 py-2">Rp.{{ number_format($order->total_amount, 2) }}</td>
                        <td class="border px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="border px-4 py-2">
                            @if ($order->status === 'paid')
                                <span class="bg-green-500 text-white px-2 py-1 rounded">Paid</span>
                            @elseif ($order->status === 'done')
                                <span class="bg-blue-500 text-white px-2 py-1 rounded">Done</span>
                            @elseif ($order->status === 'canceled')
                                <span class="bg-red-500 text-white px-2 py-1 rounded">Canceled</span>
                            @elseif ($order->status === 'shipping')
                                <span class="bg-yellow-500 text-white px-2 py-1 rounded">Shipping</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            <button type="button" onclick="showOrderDetails('{{ $order->id }}')"
                                class="bg-yellow-500 text-white px-2 py-1 rounded">
                                @if ($order->status == 'paid')
                                    KIRIM
                                @else
                                    DETAILS
                                @endif
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Modal -->
    <div id="orderDetailsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg">
            <h2 class="text-xl font-bold mb-4">Order Details</h2>
            <div id="modalContent">
                <!-- Detail pesanan akan di sini -->
            </div>
            <form id="updateOrderForm" method="POST" action="" style="display: none;">
                @csrf
                @method('PUT')
                <input type="hidden" id="orderIdInput" name="order_id" value="">
                <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
            </form>
            <button type="button" onclick="hideModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Close</button>
        </div>
    </div>

    <script>
        function showOrderDetails(orderId) {
            const authToken = @json(session('auth_token')); // Mengambil auth token dari session
            fetch(`/api/seller/orders/${orderId}/details`, {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + authToken,
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let content = `<p><strong>Order ID:</strong> ${data.id}</p>`;
                    content += `<p><strong>Status:</strong> ${data.status}</p>`;
                    content += `<p><strong>Address:</strong> ${data.address}</p>`;
                    content += `<p><strong>Phone Number:</strong> ${data.phone_number}</p>`;
                    content += `<p><strong>Total Price:</strong> Rp. ${data.total_price}</p>`;
                    content += '<p><strong>Products:</strong></p>';
                    content += '<ul>';
                    data.cart_details.forEach(item => {
                        content +=
                            `<li>${item.product.name} - Qty: ${item.qty} - Price: Rp. ${item.sub_price}</li>`;
                    });
                    content += '</ul>';
                    document.getElementById('modalContent').innerHTML = content;

                    if (data.status == 'paid') {
                        document.getElementById('updateOrderForm').action = `/seller/orders/${orderId}/update-status`;
                        document.getElementById('orderIdInput').value = orderId;
                        document.getElementById('updateOrderForm').style.display = 'block';
                    }
                    document.getElementById('orderDetailsModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                });
        }



        function hideModal() {
            document.getElementById('orderDetailsModal').classList.add('hidden');
        }
    </script>
@endsection
