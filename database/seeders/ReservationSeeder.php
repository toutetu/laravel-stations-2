<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Sheet;
use App\Models\Reservation;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // 既存のスケジュールをランダムに取得
        $schedules = Schedule::inRandomOrder()->take(5)->get();

        foreach ($schedules as $schedule) {
            // 各スケジュールに対して1〜3件の予約を作成
            $numberOfReservations = rand(1, 3);

            for ($i = 0; $i < $numberOfReservations; $i++) {
                // 利用可能なシートをランダムに取得
                $sheet = Sheet::whereNotIn('id', function($query) use ($schedule) {
                    $query->select('sheet_id')
                          ->from('reservations')
                          ->where('schedule_id', $schedule->id);
                })->inRandomOrder()->first();

                // シートが利用可能な場合のみ予約を作成
                if ($sheet) {
                    Reservation::create([
                        'date' => $schedule->start_time->toDateString(),
                        'schedule_id' => $schedule->id,
                        'sheet_id' => $sheet->id,
                        'email' => $faker->email,
                        'name' => $faker->name,
                    ]);
                }
            }
        }
    }
}