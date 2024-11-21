<?php

namespace Tests\Feature\LaravelStations\Station19;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Sheet;
use App\Models\Reservation;
use App\Models\Schedule;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

class AdminReservationTest extends TestCase
{
    use RefreshDatabase;

    private int $genreId;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->genreId = Genre::insertGetId(['name' => 'ジャンル']);
    }

    #[Test]
    #[Group('station19')]
    public function test管理者予約一覧が表示されているか(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $movieId = $this->createMovie('タイトル' . $i)->id;
            Reservation::insert([
                'date' => new CarbonImmutable('2050-01-01'),
                'schedule_id' => Schedule::insertGetId([
                    'movie_id' => $movieId,
                    'start_time' => new CarbonImmutable('2050-01-01 00:00:00'),
                    'end_time' => new CarbonImmutable('2050-01-01 02:00:00'),
                ]),
                'sheet_id' => $i + 1,
                'email' => 'sample@exmaple.com',
                'name' => 'サンプル太郎',
            ]);
        }
        $response = $this->get('/admin/reservations/');
        $response->assertStatus(200);

        $reservations = Reservation::all();
        foreach ($reservations as $reservation) {
            $response->assertSee($reservation->date);
            $response->assertSee($reservation->name);
            $response->assertSee($reservation->email);
            $response->assertSee(strtoupper($reservation->sheet->row . $reservation->sheet->column));
        }
    }

    private function assertReservationCount(int $count): void
    {
        $reservationCount = Reservation::count();
        $this->assertEquals($reservationCount, $count);
    }


    private function createMovie(string $title): Movie
    {
        $movieId = Movie::insertGetId([
            'title' => $title,
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2000,
            'description' => '概要',
            'is_showing' => rand(0, 1),
            'genre_id' => $this->genreId,
        ]);
        return Movie::find($movieId);
    }

    private function createSchedule(int $movieId): Schedule
    {
        $scheduleId = Schedule::insertGetId([
            'movie_id' => $movieId,
            'start_time' => new CarbonImmutable(),
            'end_time' => new CarbonImmutable(),
        ]);
        return Schedule::find($scheduleId);
    }

}
