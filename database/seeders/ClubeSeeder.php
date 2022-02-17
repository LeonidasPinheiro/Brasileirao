<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clube;

class ClubeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Clube::create([
            'nome' => 'Atlético-MG'
        ]);
        Clube::create([
            'nome' => 'Flamengo'
        ]);
        Clube::create([
            'nome' => '	Palmeiras'
        ]);
        Clube::create([
            'nome' => 'Fortaleza'
        ]);
        Clube::create([
            'nome' => 'Corinthians'
        ]);
        Clube::create([
            'nome' => 'Bragantino'
        ]);
        Clube::create([
            'nome' => 'Fluminense'
        ]);
        Clube::create([
            'nome' => '	América-MG'
        ]);
        Clube::create([
            'nome' => 'Atlético Goianiense'
        ]);
        Clube::create([
            'nome' => 'Santos'
        ]);
        Clube::create([
            'nome' => 'Ceará'
        ]);
        Clube::create([
            'nome' => 'Internacional'
        ]);
        Clube::create([
            'nome' => 'São Paulo'
        ]);
        Clube::create([
            'nome' => 'Athletico-PR'
        ]);
        Clube::create([
            'nome' => 'Cuiabá'
        ]);
        Clube::create([
            'nome' => 'Juventude'
        ]);
        Clube::create([
            'nome' => 'Grêmio'
        ]);
        Clube::create([
            'nome' => 'Bahia'
        ]);
        Clube::create([
            'nome' => 'Sport'
        ]);
        Clube::create([
            'nome' => 'Chapecoense'
        ]);
    }
}
