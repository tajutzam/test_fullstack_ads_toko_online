<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{

    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('sanctum')->user();
        if (!$user || !in_array($user->role, $roles)) {
            $user = Auth::user();
            if ($user) {
                auth()->guard('web')->logout();
                $user->tokens()->delete();
            }
            Session::forget('auth_token');
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        return $next($request);
    }
}
