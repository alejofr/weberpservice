<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CondicionesProveedores;

class CondicionesProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CondicionesProveedores::create([
            'dias_condiciones' => '0',
            'leyenda_condiciones' => 'Pago Inmediato'
        ]);
        CondicionesProveedores::create([
            'dias_condiciones' => '15',
            'leyenda_condiciones' => '15 Dias'
        ]);
        CondicionesProveedores::create([
            'dias_condiciones' => '21',
            'leyenda_condiciones' => '21 Dias'
        ]);
        CondicionesProveedores::create([
            'dias_condiciones' => '30',
            'leyenda_condiciones' => '30 Dias'
        ]);
        CondicionesProveedores::create([
            'dias_condiciones' => '45',
            'leyenda_condiciones' => '45 Dias'
        ]);
        CondicionesProveedores::create([
            'dias_condiciones' => '60',
            'leyenda_condiciones' => '2 Meses'
        ]);
        CondicionesProveedores::create([
            'dias_condiciones' => '30',
            'leyenda_condiciones' => 'Fin del mes siguiente'
        ]);
    }
}
