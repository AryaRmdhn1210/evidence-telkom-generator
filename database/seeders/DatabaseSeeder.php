<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Password di bawah hanya untuk pengembangan dan demo.
     * Ganti lewat menu Kelola User setelah login pertama.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@evidencetelkom.test',
                'password' => 'password',
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['username' => 'karyawan'],
            [
                'name' => 'Karyawan Contoh',
                'email' => 'karyawan@evidencetelkom.test',
                'password' => 'password',
                'role' => 'karyawan',
            ]
        );
    }
}
