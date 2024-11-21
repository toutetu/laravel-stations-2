<?php

namespace Tests\Feature\LaravelStations\Station19;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AdminMovieTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    #[Test]
    #[Group('station19')]
    public function test管理者映画一覧に全ての映画のカラムが表示されているか(): void
    {
        $genreId = Genre::insertGetId(['name' => 'ジャンル']);

        for ($i = 0; $i < 3; $i++) {
            Movie::insert([
                'title' => 'タイトル' . $i,
                'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
                'published_year' => 2000 + $i,
                'description' => '概要' . $i,
                'is_showing' => random_int(0, 1),
                'genre_id' => $genreId,
            ]);
        }

        $response = $this->get('/admin/movies');
        $response->assertStatus(200);

        $movies = Movie::all();
        foreach ($movies as $movie) {
            $response->assertSeeText($movie->title);
            $response->assertSee($movie->image_url);
            $response->assertSeeText($movie->published_year);
            $response->assertSeeText($movie->description);
            if ($movie->is_showing) {
                $response->assertSeeText('上映中');
            } else {
                $response->assertSeeText('上映予定');
            }
        }
        // $response->assertDontSee('true');
        // $response->assertDontSee('false');
        $response->assertSee($movie->is_showing ? '上映中' : '上映予定');
    }

    #[Test]
    #[Group('station19')]
    public function test管理者映画作成画面が表示されているか(): void
    {
        $response = $this->get('/admin/movies/create');
        $response->assertSeeText('ジャンル');
        $response->assertStatus(200);
    }

    #[Test]
    #[Group('station19')]
    public function test管理者映画作成画面で映画が作成される(): void
    {
        $response = $this->post('/admin/movies', [
            'title' => '新しい映画',
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2022,
            'description' => "概要\n概要\n",
            'is_showing' => true,
            'genre' => 'ジャンル',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('movies', 1);
    }

    private function assertMovieCount(int $count): void
    {
        $movieCount = Movie::count();
        $this->assertEquals($movieCount, $count);
    }

    private function createMovie(): Movie
    {
        $movieId = Movie::insertGetId([
            'title' => '最初からある映画',
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2000,
            'description' => '概要',
            'is_showing' => false,
            'genre_id' => Genre::insertGetId(['name' => 'ジャンル']),
        ]);
        return Movie::find($movieId);
    }
}
