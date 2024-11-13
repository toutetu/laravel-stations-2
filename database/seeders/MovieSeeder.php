<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run()
    {
        $genres = ['アクション', 'コメディ', 'ドラマ', 'SF', 'ホラー'];
        foreach ($genres as $genreName) {
            Genre::factory()->create(['name' => $genreName]);
        }

        Movie::factory()->count(30)->create();
    }
}