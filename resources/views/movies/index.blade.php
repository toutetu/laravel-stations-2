<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>映画作品一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container">
        <h1>映画作品一覧</h1>

        <form action="{{ route('movies.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="タイトルまたは概要で検索..." class="form-control">
                </div>
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_showing" id="all" value="" {{ request('is_showing') === null ? 'checked' : '' }}>
                        <label class="form-check-label" for="all">すべて</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_showing" id="upcoming" value="0" {{ request('is_showing') === '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="upcoming">上映予定</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_showing" id="showing" value="1" {{ request('is_showing') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="showing">上映中</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">検索</button>
                </div>
            </div>
        </form>

        <div class="movie-grid">
            @foreach($movies as $movie)
                <div class="movie-item">
                    <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}">
                    <h3>{{ $movie->title }}</h3>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $movies->appends(request()->query())->links() }}
        </div>
    </div>
</body>
</html>