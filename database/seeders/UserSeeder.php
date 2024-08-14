<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $users = [
            [
                'name' => 'Ketua',
                'email' => 'aurel@gmail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Administrator',
                'email' => 'administrator@gmail.com',
                'password' => Hash::make('12345678'),
            ],
        ];

        for ($i = 0; $i < count($users); $i++) {
            $user = User::create($users[$i]);
            $user->assignRole($i + 1);
        }
    }
}
