@extends('layouts.seller')

@section('content')
    <div class="container bg-white rounded px-2 py-2 shadow-md">
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block">Name</label>
                <input type="text" id="name" name="name" class="border p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="price" class="block">Price</label>
                <input type="number" id="price" name="price" class="border p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="stok" class="block">Stock</label>
                <input type="number" id="stok" name="stok" class="border p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="category" class="block">Category</label>
                <select id="category" name="category_id" class="border p-2 w-full" required>
                    <option value="" disabled selected>Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="image" class="block">Image</label>
                <input type="file" id="image" name="image" class="border p-2 w-full" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
@endsection
