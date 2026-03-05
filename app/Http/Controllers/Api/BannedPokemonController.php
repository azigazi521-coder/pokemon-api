<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BannedPokemon;


class BannedPokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(BannedPokemon::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:banned_pokemon,name'
        ]);

        $pokemon = BannedPokemon::create(['name' => strtolower($validated['name'])]);
        return response()->json($pokemon, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $name)
    {
        $deleted = BannedPokemon::where('name', $name)->delete();
        return response()->json(null, $deleted ? 204 : 404);
    }
}
