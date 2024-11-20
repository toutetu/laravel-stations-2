<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SheetSeeder extends Seeder
{
    public function run()
    {
        $sheets = [
            ['column' => 1, 'row' => 'A'], ['column' => 2, 'row' => 'A'], ['column' => 3, 'row' => 'A'], ['column' => 4, 'row' => 'A'], ['column' => 5, 'row' => 'A'],
            ['column' => 1, 'row' => 'B'], ['column' => 2, 'row' => 'B'], ['column' => 3, 'row' => 'B'], ['column' => 4, 'row' => 'B'], ['column' => 5, 'row' => 'B'],
            ['column' => 1, 'row' => 'C'], ['column' => 2, 'row' => 'C'], ['column' => 3, 'row' => 'C'], ['column' => 4, 'row' => 'C'], ['column' => 5, 'row' => 'C'],
        ];

        DB::table('sheets')->insert($sheets);
    }
}