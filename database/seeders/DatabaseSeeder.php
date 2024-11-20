<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory()->create([
            'name' => 'admin',
            'description' => 'Tizim nazorarchisi',
        ]);
        User::factory()->create([
            'fio' => 'Esanov Otabek',
            'login' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
        ]);

        $this->call([
            SubjectsTableSeeder::class,
        ]);


    }
}
