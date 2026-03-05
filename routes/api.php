<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BannedPokemonController;
use App\Http\Controllers\Api\PokemonController;

Route::prefix('banned')
    ->middleware('auth.secret')
    ->group(function () {
        Route::get('/', [BannedPokemonController::class, 'index']);
        Route::post('/', [BannedPokemonController::class, 'store']);
        Route::delete('/{banned}', [BannedPokemonController::class, 'destroy']);
    });

Route::post('/info', [PokemonController::class, 'getData']);
