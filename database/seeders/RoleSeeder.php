<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $roles = [
            'ketua',
            'admin',
        ];

        for ($i = 0; $i < count($roles); $i++) {
            Role::create([
                'name' => $roles[$i]
            ]);
        }
    }
}
