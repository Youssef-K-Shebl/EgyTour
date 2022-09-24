<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = [
            'Restaurant',
            'Cafes',
            'Beaches',
            'Museums'
        ];

        foreach ($cats as $cat)
            DB::table('categories')->insert([
                'name' => $cat
            ]);
    }
}
