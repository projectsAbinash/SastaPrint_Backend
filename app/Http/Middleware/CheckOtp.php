<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOtp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->phone_verified_at == null) {
           return response()->json([
          'status' => 'false',
          'Message' => 'OTP Not Verfied',
           ]);
        }

        // if (1 == 1) {
        //     return response()->json([
        //    'status' => 'False',
        //    'Message' => 'User Is Blocked by Admin',
        //     ]);
        //  }
        return $next($request);
    }
}
