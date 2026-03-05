<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthSecretKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $clientKey = $request->header('X-SUPER-SECRET-KEY');
        $serverKey = env('APP_SUPER_SECRET_KEY');

        if (!$clientKey) {
            return response()->json(['error' => 'Brak wymaganego nagłówka X-SUPER-SECRET-KEY'], 401);
        }

        if ($clientKey !== $serverKey) {
            return response()->json(['error' => 'Niepoprawny klucz autoryzacji'], 403);
        }

        return $next($request);
    }
}
