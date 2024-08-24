<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //


    public function loginView(Request $request)
    {

        return view("auth.login");
    }

    public function registerView()
    {
        return view("auth.register");
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:seller,user',
        ]);

        User::create($validated);

        return redirect('/login')->with('success', 'User successfuly register');
    }

    public function login(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        // Find user by email
        $user = User::where('email', $validated['email'])->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return redirect()->back()->withErrors(['email' => 'The provided credentials are incorrect!']);
        }

        Auth::login($user);

        $token = $user->createToken('Personal Access Token')->plainTextToken;

        // Store token in session
        $request->session()->put('auth_token', $token);

        if ($user->role === 'seller') {
            return redirect('/seller/dashboard');
        } elseif ($user->role === 'user') {
            return redirect('/');
        } else {
            return redirect('/login')->with('error', 'Invalid role');
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->tokens()->delete();
        }

        Session::forget('auth_token');

        auth()->guard('web')->logout();
        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
