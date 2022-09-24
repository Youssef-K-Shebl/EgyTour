<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $govs = [
            'Alexandria',
            'Aswan',
            'Asyut',
            'Damanhur',
            'Bani Suef',
            'Cairo',
            'Mansora',
            'Damietta',
            'Faiyum',
            'Tanta',
            'Giza',
            'Ismailia',
            'Kaft El Sheikh',
            'Luxor',
            'Marsa Matruh',
            'Minya',
            'Momofiya',
            'Qena',
            'dakahleya',
            'Gharbeya',
            'Bort Said',
            'Suez',
            'North Sinai',
            'Sohag',
            'Beheira',
            'Fayoum'
        ];
        foreach ($govs as $gov)
        DB::table('governorates')->insert([
            'name' => $gov
        ]);

    }
}
