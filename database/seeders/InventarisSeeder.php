<?php

namespace Database\Seeders;

use App\Models\Inventaris;
use App\Models\InventarisKeluar;
use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventarisSeeder extends Seeder {
    public function run(): void {
        $item = [
            'name'      => 'HP Victus 17" RAM 16GB SSD 1TB',
            'jenis_id'  => 1
        ];
        $pengadaan = 3;
        for ($i = 0; $i < $pengadaan; $i++) {
            $inventarisMasuk = Inventaris::create([
                'kode_inventarisasi'    => $this->randomString(12),
                'tahun_pengadaan'       => 2022 + $i,
                'jenis_inventarisasi'   => 'masuk',
                'verified_at'           => $i == 2 ? null : date('Y-m-d H:i:s'),
            ]);
            if ($inventarisMasuk) {
                for ($j = 0; $j < rand(5, 8); $j++) {
                    Item::create([
                        'name'          => $item['name'],
                        'jenis_aset_id' => $item['jenis_id'],
                        'inventaris_id' => $inventarisMasuk->id,
                        'id_item'       => $this->randomString(20),
                    ]);
                }
            }
        }

        $jmlItem = Item::count();
        $inventarisKeluar = Inventaris::create([
            'kode_inventarisasi' => $this->randomString(12),
            'tahun_pengadaan' => 2024,
            'jenis_inventarisasi' => 'keluar',
        ]);
        if ($inventarisKeluar) {
            InventarisKeluar::create([
                'item_id' => rand(1, 10),
                'inventaris_id' => $inventarisKeluar->id,
                'keterangan' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio dolores doloribus voluptates? Facilis repudiandae odio magni veniam magnam culpa earum iste ut, consequuntur obcaecati quibusdam exercitationem cupiditate consequatur nihil corporis.',
            ]);
        }
    }

    function randomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkalmnopqrstuvwxyz';
        // $cap = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $low = 'abcdefghijkalmnopqrstuvwxyz';
        // $num = '0123456789';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $string .= $characters[$randomIndex];
        }
        return $string;
    }
}
