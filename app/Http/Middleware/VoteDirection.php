<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteDirection
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
        $user = Auth::user();
        // dd($user);
        if ($user) {
            $voter = User::find(Auth::user()->id);
            if (!is_null($voter->login_at)) {
                if (time() > (strtotime($voter->login_at) + (60*5))) {
                    // dd(date("H:m:s", strtotime($voter->login_at) + (60*5)));
                    $voter->login_at = null;
                    $voter->save();
                    Auth::logout();
                }
            }
            if (is_null($user->cdpm_id)) {
                if ($request->route()->getName() == 'votedpm') {
                    return $next($request);
                }
                return redirect()->route('votedpm');
            }else if (is_null($user->cbem_id)) {
                if ($request->route()->getName() == 'votebem') {
                    return $next($request);
                }
                return redirect()->route('votebem');
            }else {
                $voter->login_at = null;
                $voter->save();
                Auth::logout();
                return redirect()->route('home');
            }
        }
        return $next($request);
    }
}
