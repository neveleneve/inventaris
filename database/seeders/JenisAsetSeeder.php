<?php

namespace Database\Seeders;

use App\Models\JenisAset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisAsetSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $jenis = [
            'Mesin',
            'Perabotan',
            'Alat Tulis Kantor',
        ];

        for ($i = 0; $i < count($jenis); $i++) {
            JenisAset::create([
                'name' => $jenis[$i]
            ]);
        }
    }
}
