<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //


    public function index()
    {
        $products = Product::where('seller_id', Auth::user()->id)->paginate(1);
        $title = 'Products';
        return view("seller.products.index", compact('products', 'title'));
    }

    public function create()
    {
        $categories = Category::all();
        $title = 'Add Products';

        return view("seller.products.create", compact('categories', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'stok' => 'required|integer|min:1',
            'category_id' => 'required|exists:category,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stok' => $request->stok,
            'category_id' => $request->category_id,
            'image' => $imageName,
            'seller_id' => Auth::user()->id,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Product added successfully.');
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $title  = 'Edit product';
        $categories = Category::all();
        return view("seller.products.edit", compact('product', 'title', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stok' => 'required|integer',
            'category_id' => 'required|exists:category,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->stok = $request->stok;
        $product->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully.');
    }
}
