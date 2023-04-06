<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerified
{
    public function handle(Request $request, Closure $next)
    {   
        try {
            $user = Auth::user();
            if($user && $user->email_verified_at) return $next($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);  
        }

        // Email not verified
        return response()->json([
            'status' => 'email_not_verified',
            'email' => $user->email,
            'message' => 'Please verify your email before accessing your account.'
        ], 401);
    }
}
