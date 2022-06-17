<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MonedasCambios;
use App\Models\Monedas;

class MonedasCambiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $moneda_nc = Monedas::where('abreviatura', '=', 'MXN')->select('id_moneda')->first();
        $moneda_divisa = Monedas::where('abreviatura', '=', 'USD')->select('id_moneda')->first();

        MonedasCambios::create([
            'id_moneda_nc' => $moneda_nc->id_moneda,
            'id_moneda_divisa' => $moneda_divisa->id_moneda
        ]);
    }
}
