<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classificacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'clube',
        'pontos',
        'jogos_disputados',
        'vitorias',
        'empates',
        'derrotas',
        'gol_pro',
        'gol_contra',
        'saldo_gols'
    ];

}
