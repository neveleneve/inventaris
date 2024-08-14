<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $all = [
            'dashboard',
            'aset index',
            'aset show',
            'inventaris index',
            'inventaris create',
            'inventaris delete',
            'inventaris show',
            'inventaris verification',
            'report index',
            'report show',
        ];
        for ($i = 0; $i < count($all); $i++) {
            Permission::create([
                'name' => $all[$i],
            ]);
        }

        $ketua = [
            'dashboard',
            'aset index',
            'aset show',
            'inventaris index',
            'inventaris show',
            'inventaris verification',
            'report index',
            'report show',
        ];
        $admin = [
            'dashboard',
            'aset index',
            'aset show',
            'inventaris index',
            'inventaris create',
            'inventaris delete',
            'inventaris show',
            'report index',
            'report show',
        ];

        $roletotal = Role::count();
        for ($i = 0; $i < $roletotal; $i++) {
            $role = Role::findById($i + 1);
            if ($i == 0) {
                $role->givePermissionTo($ketua);
            } elseif ($i == 1) {
                $role->givePermissionTo($admin);
            }
        }
    }
}
