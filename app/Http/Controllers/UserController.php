<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $user = Auth::user();

        return view("user.profile", compact('cartCheckouted', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'first' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|confirmed|min:8',
            'new_password_confirmation' => 'nullable|same:new_password',
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->password = Hash::make($request->input('new_password'));
        }

        $user->name = $request->input('first');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
