<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomPokemon;
use Illuminate\Support\Facades\Http;
use App\Services\PokemonService;

class CustomPokemonController extends Controller
{

    public function __construct(private PokemonService $pokemonService) {}

    public function index()
    {
        return response()->json(CustomPokemon::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:custom_pokemon,name',
            'height' => 'required|integer',
            'weight' => 'required|integer',
            'types' => 'required|array'
        ]);

        $name = strtolower($validated['name']);

        $pokemonData = $this->pokemonService->getPokemon(strtolower($name));

        if ($pokemonData) {
            return response()->json(['error' => 'Pokemon o tej nazwie już istnieje w PokeAPI'], 422);
        }

        $pokemon = CustomPokemon::create(array_merge($validated, ['name' => $name]));
        return response()->json($pokemon, 201);
    }

    public function destroy($name)
    {
        $deleted = CustomPokemon::where('name', $name)->delete();
        return response()->json(null, $deleted ? 204 : 404);
    }
}
