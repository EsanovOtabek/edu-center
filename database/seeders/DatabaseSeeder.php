<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Role;
use App\Models\Day;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Role::factory()->create([
        //     'name' => 'admin',
        //     'description' => 'Tizim nazorarchisi',
        // ]);
        // User::factory()->create([
        //     'fio' => 'Esanov Otabek',
        //     'login' => 'admin',
        //     'role' => 'admin',
        //     'password' => Hash::make('12345678'),
        // ]);

        $days = [
            ['name' => 'Dushanba', 'name_en' => 'Monday'],
            ['name' => 'Seshanba', 'name_en' => 'Tuesday'],
            ['name' => 'Chorshanba', 'name_en' => 'Wednesday'],
            ['name' => 'Payshanba', 'name_en' => 'Thursday'],
            ['name' => 'Juma', 'name_en' => 'Friday'],
            ['name' => 'Shanba', 'name_en' => 'Saturday'],
            ['name' => 'Yakshanba', 'name_en' => 'Sunday'],
        ];

        foreach ($days as $day) {
            Day::factory()->create($day);
        }


        // $this->call([
        //     SubjectsTableSeeder::class,
        // ]);


    }
}
