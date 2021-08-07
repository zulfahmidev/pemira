<?php

namespace App\Http\Middleware;

use App\Models\Voter;
use Closure;
use Illuminate\Http\Request;

class VoterAuth
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
            $voter = Voter::where('login_token', $request->token)->first();
            if ($voter) {
                $request->attributes->set('voter', $voter);
                return $next($request);
            }
            return response()->json([
                "message" => "Unauthorized, voter not found ",
                "body" => null,
            ], 401);
        }
        return response()->json([
            "message" => "Unauthorized, Invalid token.",
            "body" => null,
        ], 401);
    }
}
