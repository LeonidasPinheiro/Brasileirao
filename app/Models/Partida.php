<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $fillable = [
        'rodada',
        'uid_rodada',
        'clube_mandante_gol',
        'clube_visitante_gol',
        'clube_mandante',
        'clube_visitante',
        'ativa'
    ];

}
