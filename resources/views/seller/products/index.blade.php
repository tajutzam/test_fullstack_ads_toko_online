@extends('layouts.seller')

@section('content')
    <div class="container">
        <a href="{{ route('seller.products.create') }}" class="bg-red-400 text-white px-4 py-2 rounded">Add Product</a>
        <table class="mt-4 w-full border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Stock</th>
                    <th class="border px-4 py-2">Image</th>
                    <th class="border px-4 py-2">Category Name</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="border px-4 py-2">{{ $product->name }}</td>
                        <td class="border px-4 py-2">Rp.{{ number_format($product->price, 2) }}</td>
                        <td class="border px-4 py-2">{{ $product->stok }}</td>
                        <td class="border px-4 py-2">
                            <img src="{{ asset('uploads/products/' . '/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-20 h-20 object-cover rounded-md">
                        </td>
                        <td class="border px-4 py-2">
                            {{ $product->category->name }}
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('seller.products.edit', $product) }}"
                                class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                            <form action="{{ route('seller.products.destroy', $product) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
