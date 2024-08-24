<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //

    public function index()
    {
        if (auth('sanctum')->check()) {
            return redirect('/dashboard');
        }
        return view("welcome");
    }

    public function dashboard()
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
        return view("welcome", compact('cartCheckouted'));
    }

    public function findByCategory($id)
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
        return view('categories', compact('cartCheckouted'));
    }
}
