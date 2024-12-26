<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'Admin 1',
                'email' => 'admin@untirta.ac.id',
                'password' => Hash::make('admin1234'),
                'role_id' => 1, // admin
            ]
        );

        DB::table('users')->updateOrInsert(
            ['id' => 2],
            [
                'name' => 'Petugas',
                'email' => 'petugas@untirta.ac.id',
                'password' => Hash::make('petugas1234'),
                'role_id' => 2, // staff
            ]
        );

        DB::table('users')->updateOrInsert(
            ['id' => 3],
            [
                'name' => 'Mahasiwa',
                'email' => 'mahasiswa@untirta.ac.id',
                'password' => Hash::make('mahasiswa123'),
                'role_id' => 3, // mahasiswa
            ]
        );

        DB::table('users')->updateOrInsert(
            ['id' => 4],
            [
                'name' => 'Leano',
                'email' => '3337230024@untirta.ac.id',
                'password' => Hash::make('lano1234'),
                'role_id' => 3, // mahasiswa
            ]
        );
        DB::table('users')->updateOrInsert(
            ['id' => 5],
            [
                'name' => 'Pak royan',
                'email' => 'dosen@untirta.ac.id',
                'password' => Hash::make('dosen1234'),
                'role_id' => 2, // staff
            ]
        );
    }
}