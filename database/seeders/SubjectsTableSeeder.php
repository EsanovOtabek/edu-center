<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectsTableSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            'Matematika', 'Fizika', 'Kimyo', 'Biologiya', 'Ingliz tili',
            'O‘zbek tili', 'Rus tili', 'Tarix', 'Geografiya', 'Informatika',
            'Falsafa', 'Iqtisodiyot', 'Adabiyot', 'Astronomiya',
            'Texnologiya', 'Huquqshunoslik', 'Psixologiya',
            'Dizayn', 'Musiqa', 'San’at'
        ];

        foreach ($subjects as $subject) {
            Subject::create(['name' => $subject]);
        }
    }
}
