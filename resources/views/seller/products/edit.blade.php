@extends('layouts.seller')

@section('content')
    <div class="container">
        <h1 class="text-2xl mb-4">Edit Product</h1>

        <!-- Menampilkan pesan error jika ada -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block">Name</label>
                <input type="text" id="name" name="name" class="border p-2 w-full"
                    value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="mb-4">
                <label for="price" class="block">Price</label>
                <input type="number" id="price" name="price" class="border p-2 w-full"
                    value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="mb-4">
                <label for="stok" class="block">Stock</label>
                <input type="number" id="stok" name="stok" class="border p-2 w-full"
                    value="{{ old('stok', $product->stok) }}" required>
            </div>

            <div class="mb-4">
                <label for="category" class="block">Category</label>
                <select id="category" name="category_id" class="border p-2 w-full" required>
                    <option value="" disabled>Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="image" class="block">Image</label>
                <input type="file" id="image" name="image" class="border p-2 w-full">
                <p class="text-sm text-gray-500">Leave this blank if you don't want to change the image.</p>
                @if ($product->image)
                    <img src="{{ asset('uploads/products/' . '/' . $product->image) }}" alt="{{ $product->name }}" class="w-20 mt-2">
                @endif
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
@endsection
