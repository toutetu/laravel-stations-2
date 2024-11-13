@extends('layouts.admin')

@section('content')

<h1>映画一覧</h1>

@if(isset($dbStatus))
    <div class="alert alert-info">
        {{ $dbStatus }}
    </div>
@endif

<form action="{{ route('admin.movies.index') }}" method="GET" class="mb-4">
    <div class="form-group">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="タイトルまたは概要で検索..." class="form-control">
    </div>
    
    <div class="form-group">
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

    <button type="submit" class="btn btn-primary">検索</button>
</form>

@if($movies->isEmpty())
    <p>該当する映画が見つかりませんでした。</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>映画タイトル</th>
                <th>画像URL</th>
                <th>公開年</th>
                <th>上映中</th>
                <th>ジャンル</th>
                <th>概要</th>
                <th>登録日時</th>
                <th>更新日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movies as $movie)
                <tr>
                    <td>{{ $movie->id }}</td>
                    <td>{{ $movie->title }}</td>
                    <td>{{ Str::limit($movie->image_url, 30) }}</td>
                    <td>{{ $movie->published_year }}</td>
                    <td>{{ $movie->is_showing ? '上映中' : '上映予定' }}</td>
                    <td>{{ $movie->genre->name ?? 'N/A' }}</td>
                    <td>{{ Str::limit($movie->description, 50) }}</td>
                    <td>{{ $movie->created_at ? $movie->created_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                    <td>{{ $movie->updated_at ? $movie->updated_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.movies.show', $movie) }}" class="btn btn-sm btn-info">詳細</a>
                        <a href="{{ route('admin.movies.edit', $movie) }}" class="btn btn-sm btn-primary">編集</a>
                        <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-movie" data-movie-title="{{ $movie->title }}">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $movies->appends(request()->query())->links() }}
    </div>
@endif

@endsection