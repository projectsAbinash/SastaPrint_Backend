<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
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
          'verification'=> 'false',
           ]);
        }

        #check if user is blocked
        $users = User::find($request->user()->id)->UserBlocked();
        if ($users->exists()) {
            return response()->json([
           'status' => 'false',
           'blocked' => 'true',
           'Message' => $users->first()->reasons,
            ]);
         }
        return $next($request);
    }
}
