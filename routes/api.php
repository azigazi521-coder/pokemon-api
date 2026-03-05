<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BannedPokemonController;

Route::get('/banned', [BannedPokemonController::class, 'index']);

Route::post('/banned', [BannedPokemonController::class, 'store']);

Route::delete('/banned/{banned}', [BannedPokemonController::class, 'destroy']);
