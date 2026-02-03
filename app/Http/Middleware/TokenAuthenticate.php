<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helper\JWTToken;
use App\Models\User;
use App\Helper\ResponseHelper;

class TokenAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');

        if (!$token) {
            return ResponseHelper::Out('fail', 'Token missing', 401);
        }

        $decoded = JWTToken::ReadToken($token);

        if ($decoded === 'unauthorized') {
            return ResponseHelper::Out('fail', 'Invalid or expired token', 401);
        }

        $user = User::find($decoded->userID);

        if (!$user) {
            return ResponseHelper::Out('fail', 'User not found', 401);
        }
       
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

       ////
        $request->headers->set('email', $decoded->userEmail);
        $request->headers->set('id', $decoded->userID);
        $request->headers->set('role', $decoded->role);
        return $next($request);
        ////
    }
}
