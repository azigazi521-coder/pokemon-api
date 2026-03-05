<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BannedPokemon;
use Illuminate\Support\Facades\Http;
use App\Models\CustomPokemon;
use App\Services\PokemonService;

class PokemonController extends Controller
{

    public function __construct(private PokemonService $pokemonService) {}


    public function getData(Request $request)
    {
        $validated = $request->validate([
            'names' => 'required|array|min:1',
            'names.*' => 'required|string'
        ]);

        $requestedNames = array_map('strtolower', $validated['names']);

        $bannedNames = BannedPokemon::whereIn('name', $requestedNames)
            ->pluck('name')
            ->toArray();

        $allowedNames = array_diff($requestedNames, $bannedNames);

        $results = [];
        $pokeApiUrl = config('services.pokeapi.url');

        foreach ($allowedNames as $name) {

            $custom = CustomPokemon::where('name', $name)->first();

            if ($custom) {

                $results[] = [
                    'name' => $custom->name,
                    'height' => $custom->height,
                    'weight' => $custom->weight,
                    'types' => $custom->types,
                    'source' => 'pokemon dodany własnoręcznie'
                ];
            } else {

                $pokemonData = $this->pokemonService->getPokemon($name);
                if ($pokemonData) {
                    $results[] = $pokemonData;
                }
            }
        }

        return response()->json([
            'data' => $results
        ]);
    }
}
