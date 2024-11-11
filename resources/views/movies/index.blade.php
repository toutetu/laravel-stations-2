<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>映画作品一覧</title>
    <style>
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        .movie-item {
            text-align: center;
        }
        .movie-item img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>映画作品一覧</h1>
    <div class="movie-grid">
        @foreach($movies as $movie)
            <div class="movie-item">
                <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}">
                <h3>{{ $movie->title }}</h3>
            </div>
        @endforeach
    </div>
</body>
</html>