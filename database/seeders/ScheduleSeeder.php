<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $movies = Movie::all();

        foreach ($movies as $movie) {
            $numberOfSchedules = rand(2, 3); // 各映画に対して2〜3のスケジュールを作成

            for ($i = 0; $i < $numberOfSchedules; $i++) {
                $startTime = Carbon::today()->addDays(rand(0, 14))->setHour(rand(10, 20))->setMinute(0);
                $endTime = $startTime->copy()->addHours(2);

                Schedule::factory()->create([
                    'movie_id' => $movie->id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ]);
            }
        }
    }
}