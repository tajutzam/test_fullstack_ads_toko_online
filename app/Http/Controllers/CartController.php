<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function index()
    {

        $user = Auth::user();
        $carts = $user->carts;

        $cartCheckouted = 0;
        foreach ($carts as $key => $value) {
            # code...
            if ($value->status == 'pending') {
                foreach ($value->cartDetails as $key => $cardDetail) {
                    # code...
                    $cartCheckouted++;
                }
            }
        }

        $carts = $user->carts()->with('cartDetails.product.seller')->get();
        $cartsBySeller = [];
        return view("user.cart", compact('cartCheckouted', 'cartsBySeller', 'carts'));
    }
}
