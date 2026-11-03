<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            'Cardiologia',
            'Dermatologia',
            'Endocrinologia',
            'Ginecologia',
            'Neurologia',
            'Oftalmologia',
            'Ortopedia',
            'Pediatria',
            'Psiquiatria',
            'Urologia',
        ];

        foreach ($specialties as $name) {
            Specialty::firstOrCreate([
                'name' => $name,
            ]);
        }
    }
}