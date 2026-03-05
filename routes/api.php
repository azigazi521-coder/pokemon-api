<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BannedPokemonController;
use App\Http\Controllers\Api\PokemonController;
use App\Http\Controllers\Api\CustomPokemonController;

Route::prefix('banned')
    ->middleware('auth.secret')
    ->group(function () {
        Route::get('/', [BannedPokemonController::class, 'index']);
        Route::post('/', [BannedPokemonController::class, 'store']);
        Route::delete('/{banned}', [BannedPokemonController::class, 'destroy']);
    });

Route::prefix('custom')
    ->middleware('auth.secret')
    ->group(function () {
        Route::get('/', [CustomPokemonController::class, 'index']);
        Route::post('/', [CustomPokemonController::class, 'store']);
        Route::delete('/{custom}', [CustomPokemonController::class, 'destroy']);
    });

Route::post('/info', [PokemonController::class, 'getData']);
