<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BannedPokemon;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
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
            $response =  Http::withoutVerifying()->get("{$pokeApiUrl}/{$name}");

            if ($response->successful()) {
                $data = $response->json();
                $results[] = [
                    'name' => $data['name'],
                    'height' => $data['height'],
                    'weight' => $data['weight'],
                    'types' => collect($data['types'])->pluck('type.name')
                ];
            }
        }

        return response()->json([
            'data' => $results
        ]);
    }
}
