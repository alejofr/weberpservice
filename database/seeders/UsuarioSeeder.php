<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nombre_usuario' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123')
        ])->assignRole('admin');
    }
}
