<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        $orders = Cart::whereIn('status', ['paid', 'done', 'canceled', 'shipping'])->paginate(10);
        $title = 'Order';
        return view("seller.orders.index", compact('orders', 'title'));
    }

    public function details($id)
    {
        $order = Cart::with('cartDetails.product')->findOrFail($id);
        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Cart::find($id);
        if ($order && $order->status === 'paid') {
            $order->status = 'shipping';
            $order->save();
            return response()->json(['message' => 'Order status updated to shipping.']);
        }
        return response()->json(['message' => 'Order not found or status already updated.'], 404);
    }

    public function updateStatusDone(Request $request, $id)
    {
        $order = Cart::find($id);
        if ($order && $order->status === 'shipping') {
            $order->status = 'done';
            $order->save();
            return redirect()->back()->with('success', 'Berhasil menyelesaikan pesanan');
        }
        return redirect()->back()->withErrors('Pesanan tidak dalam pengiriman!');
    }
}
