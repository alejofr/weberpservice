<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Monedas;
use Illuminate\Support\Facades\DB;

class MonedasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colombia = DB::table('wse_paises')->where('nombre', '=', 'Colombia')->first();
        $bolivia = DB::table('wse_paises')->where('nombre', '=', 'Bolivia')->first();
        $mexico = DB::table('wse_paises')->where('nombre', '=', 'México')->first();
        $usa = DB::table('wse_paises')->where('nombre', '=', 'Estados Unidos')->first();

        Monedas::create([
            'id_pais' => $colombia->id_pais,
            'id_moneda_erp' => '1', 
            'nombre' => 'Pesos Colombiano',
            'abreviatura' => 'COP'
        ]);
        Monedas::create([
            'id_pais' => $bolivia->id_pais,
            'id_moneda_erp' => '2', 
            'nombre' => 'Bolivianos',
            'abreviatura' => 'BOB'
        ]);
        Monedas::create([
            'id_pais' => $mexico->id_pais,
            'id_moneda_erp' => '3',
            'nombre' => 'Pesos Mexicanos',
            'abreviatura' => 'MXN'
        ]);

        Monedas::create([
            'id_pais' => $usa->id_pais,
            'id_moneda_erp' => '4',
            'nombre' => 'Dolar Estadounidense',
            'abreviatura' => 'USD'
        ]);
    }
}
