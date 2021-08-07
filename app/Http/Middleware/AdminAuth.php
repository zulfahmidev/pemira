<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->token) {
            $user = User::where('login_token', $request->token)->first();
            if ($user) {
                $request->attributes->set('user', $user);
                return $next($request);
            }
            return response()->json([
                "message" => "Unauthorized, user not found ",
                "body" => null,
            ], 401);
        }
        return response()->json([
            "message" => "Unauthorized, Invalid token.",
            "body" => null,
        ], 401);
    }
}
