<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'fecha_ingreso' => now(),
            'estado' => '1',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Jose Andrade Mamani',
            'email' => 'jandrade@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'fecha_ingreso' => now(),
            'estado' => '1',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Maria Gandarillas Quispe',
            'email' => 'mgandarillas@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'fecha_ingreso' => now(),
            'estado' => '1',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Rosmery Alanoca Quispe',
            'email' => 'ralanoca@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'fecha_ingreso' => now(),
            'estado' => '1',
            'remember_token' => Str::random(10),
        ]);
    }
}
