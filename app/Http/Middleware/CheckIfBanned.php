<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\BannedPokemon;

class CheckIfBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (BannedPokemon::where('name', $request->route('pokemon_name'))->exists()) {
            return response()->json(['message' => 'Ten Pokemon jest zakazany!'], 403);
        }

        return $next($request);
    }
}
