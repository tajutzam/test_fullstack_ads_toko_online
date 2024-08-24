<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function addToCart(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('product_id');
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $product = Product::findOrFail($productId);

        if ($product->stok <= 0) {
            return response()->json(['success' => false, 'message' => 'Product out of stock'], 400);
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'seller_id' => $product->seller_id, 'status' => 'pending'],
            ['status' => 'pending']
        );

        $cartDetail = CartDetail::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $productId
        ]);

        $cartDetail->qty = ($cartDetail->qty ?? 0) + 1;
        $cartDetail->sub_price = $product->price * $cartDetail->qty;
        $cartDetail->save();

        $product->stok -= 1;
        $product->save();

        $this->updateCartTotalPrice($cart->id);

        return response()->json(['success' => true, 'message' => 'Product added to cart']);
    }

    protected function updateCartTotalPrice($cartId)
    {
        $cart = Cart::findOrFail($cartId);

        // Calculate the total price by summing up all cart details
        $totalPrice = CartDetail::where('cart_id', $cartId)->sum('sub_price');

        // Update the cart's total price
        $cart->total_price = $totalPrice;
        $cart->save();
    }

    public function updateQuantity(Request $request, $cartDetailId)
    {
        // Cari item keranjang berdasarkan ID
        $cartDetail = CartDetail::find($cartDetailId);

        // Update quantity
        $cartDetail->qty = $request->qty;
        $cartDetail->sub_price = $cartDetail->qty * $cartDetail->product->price;
        $cartDetail->save();

        $sellerId = $cartDetail->product->seller_id;
        $sellerCartDetails = CartDetail::whereHas('product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->get();

        $sellerSubtotal = $sellerCartDetails->sum('sub_price');

        // Hitung total semua seller
        $total = CartDetail::with('product')->get()->sum('sub_price');

        // Kembalikan respon JSON
        return response()->json([
            'subtotal' => number_format($cartDetail->sub_price, 2),
            'sellerSubtotal' => number_format($sellerSubtotal, 2),
            'total' => number_format($total, 2),
        ]);
    }
}
