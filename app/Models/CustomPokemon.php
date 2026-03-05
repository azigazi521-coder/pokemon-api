<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomPokemon extends Model
{

    protected $table = 'custom_pokemon';

    protected $fillable = [
        'name',
        'height',
        'weight',
        'types'
    ];

    protected $casts = [
        'types' => 'array',
    ];
}
