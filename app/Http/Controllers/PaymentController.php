<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    //

    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }


    public function createCharge(Request $request)
    {
        try {

            $user = Auth::user();

            $params = [
                'transaction_details' => [
                    'order_id' => $request->cart_id,
                    'gross_amount' => $request->amount,
                ],
                'credit_card' => [
                    'secure' => true
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'last_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $request->phone,
                ],
                'shipping_address' => [
                    'address' => $request->address
                ]
            ];

            $cart = Cart::findOrFail($request->cart_id)->update(
                [
                    'address' => $request->address,
                    'phone_number' => $request->phone
                ]
            );

            $snapToken = Snap::getSnapToken($params);

            return response()->json($snapToken);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateStatus(Request $request)
    {
        $transaction = Cart::where('id', $request->order_id)->first();

        if ($transaction) {
            if ($request->fraud_status == 'accept') {
                $transaction->status = 'paid';
                $transaction->save();
                return response()->json(['success' => true]);
            } else {
                $transaction->status = 'canceled';
                $transaction->save();
                return response()->json(['success' => true]);
            }
        }
        return response()->json(['success' => false], 404);
    }
}
