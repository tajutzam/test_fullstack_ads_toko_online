<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //

    public function index(Request $request)
    {
        $totalProducts = Product::where('seller_id', Auth::user()->id)->count();
        $totalOrders = Cart::where('seller_id', Auth::user()->id)->count();
        $title = 'Dashboard';
        return view("seller.index", compact('title', 'totalProducts' ,'totalOrders'));
    }
}
