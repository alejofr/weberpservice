<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Paises;

class PaisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Paises::create([
            'id_pais_erp' => '1',
            'nombre' => 'Colombia',
            'nacionalidad_pais' => 'Colombiana',
        ]);

        Paises::create([
            'id_pais_erp' => '2',
            'nombre' => 'Bolivia',
            'nacionalidad_pais' => 'Boliviana',
        ]);

        Paises::create([
            'id_pais_erp' => '3',
            'nombre' => 'México',
            'nacionalidad_pais' => 'Mexicana',
        ]);

        Paises::create([
            'id_pais_erp' => '3',
            'nombre' => 'Estados Unidos',
            'nacionalidad_pais' => 'Estadounidense',
        ]);
    }
}
