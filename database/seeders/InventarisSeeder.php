<?php

namespace Database\Seeders;

use App\Models\Inventaris;
use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventarisSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $item = [
            'name' => 'HP Victus 17" RAM 16GB SSD 1TB',
            'jenis_id' => 1
        ];
        $pengadaan = 2;
        for ($i = 0; $i < $pengadaan; $i++) {
            $inventaris = Inventaris::create([
                'kode_inventarisasi' => $this->randomString(12),
                'tahun_pengadaan' => 2022 + $i,
                'jenis_inventaris' => 'masuk',
            ]);
            if ($inventaris) {
                for ($j = 0; $j < rand(5, 8); $j++) {
                    Item::create([
                        'name' => $item['name'],
                        'jenis_id' => $item['jenis_id'],
                        'inventaris_id' => $inventaris->id,
                        'id_item' => $this->randomString(20),
                    ]);
                }
            }
        }
    }

    function randomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkalmnopqrstuvwxyz';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $string .= $characters[$randomIndex];
        }
        return $string;
    }
}
