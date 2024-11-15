<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Movie;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $movies = Movie::take(2)->get();

        foreach ($movies as $index => $movie) {
            Schedule::create([
                'movie_id' => $movie->id,
                'start_time' => Carbon::today()->setTime(10 + $index * 4, 0),
                'end_time' => Carbon::today()->setTime(12 + $index * 4, 0),
            ]);

            Schedule::create([
                'movie_id' => $movie->id,
                'start_time' => Carbon::today()->setTime(14 + $index * 4, 0),
                'end_time' => Carbon::today()->setTime(16 + $index * 4, 0),
            ]);
        }
    }
}