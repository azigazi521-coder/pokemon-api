<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PokemonService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.pokeapi.url');
    }

    public function getPokemon(string $name): ?array
    {
        $name = strtolower($name);
        $ttl = $this->getSecondsUntilUpdate();

        $pokeApiUrl = config('services.pokeapi.url');

        return Cache::remember("pokemon_info_{$name}", $ttl, function () use ($name, $pokeApiUrl) {
            $response = Http::withoutVerifying()->get("{$pokeApiUrl}/{$name}");

            if ($response->failed()) {
                return null;
            }

            $data = $response->json();

            return [
                'name' => $data['name'],
                'height' => $data['height'],
                'weight' => $data['weight'],
                'types' => collect($data['types'])->pluck('type.name')->toArray(),
                'source' => 'oficjalny pokemon z Poke Api'
            ];
        });
    }

    private function getSecondsUntilUpdate(): int
    {
        $now = now()->timezone('Europe/Warsaw');
        $nextUpdate = now()->timezone('Europe/Warsaw')->hour(12)->minute(0)->second(0);

        if ($now->greaterThanOrEqualTo($nextUpdate)) {
            $nextUpdate->addDay();
        }

        return $now->diffInSeconds($nextUpdate);
    }
}
