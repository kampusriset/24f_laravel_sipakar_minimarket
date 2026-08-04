<?php

namespace Database\Seeders;

use App\Models\Kasir;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@smartmini.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $kasir1 = User::updateOrCreate(
            ['email' => 'kasir1@smartmini.test'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('password'),
                'role' => 'kasir',
                'email_verified_at' => now(),
            ]
        );

        $kasir2 = User::updateOrCreate(
            ['email' => 'kasir2@smartmini.test'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'kasir',
                'email_verified_at' => now(),
            ]
        );

        Kasir::updateOrCreate(
            ['user_id' => $kasir1->id],
            [
                'kode_kasir' => 'KSR-01',
                'nama_kasir' => $kasir1->name,
                'no_hp' => '0812-1111-2222',
                'alamat' => 'Surakarta, Jawa Tengah',
                'status' => 'aktif',
            ]
        );

        Kasir::updateOrCreate(
            ['user_id' => $kasir2->id],
            [
                'kode_kasir' => 'KSR-02',
                'nama_kasir' => $kasir2->name,
                'no_hp' => '0813-3333-4444',
                'alamat' => 'Surakarta, Jawa Tengah',
                'status' => 'aktif',
            ]
        );
    }
}
