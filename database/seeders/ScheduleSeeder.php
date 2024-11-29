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
            $numberOfSchedules = rand(2, 3);

            for ($i = 0; $i < $numberOfSchedules; $i++) {
                $fixedDate = Carbon::create(2050, 1, 1);
                $startTime = $fixedDate->copy()->setHour(rand(10, 20))->setMinute(0)->setSecond(0);
                // $startTime = Carbon::createFromTime(rand(10, 20), 0, 0);
                $endTime = $startTime->copy()->addHours(2);

                try {
                    Schedule::create([
                        'movie_id' => $movie->id,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ]);
                } catch (\Exception $e) {
                    // エラーメッセージをログに出力
                    \Log::error('Schedule creation failed: ' . $e->getMessage());
                }
            }
        }
    }
}