<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function findAll()
    {
        $products = Product::where('stok', '<>', 0)->get();
        return ProductResource::collection($products);
    }

    public function findByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)
            ->where('stok', '<>', 0)
            ->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found for this category'], 404);
        }

        return ProductResource::collection($products);
    }


    public function findRandom()
    {
        $products = Product::where('stok', '<>', 0)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return ProductResource::collection($products);
    }
}
