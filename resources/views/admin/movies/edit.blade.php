@extends('layouts.app')

@section('content')
<div class="container">
    <h1>映画情報の編集</h1>
    <form action="{{ route('admin.movies.update', $movie) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="mb-3">
            <label for="title" class="form-label">タイトル</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $movie->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="image_url" class="form-label">画像 URL</label>
            <input type="url" class="form-control" id="image_url" name="image_url" value="{{ old('image_url', $movie->image_url) }}" required>
        </div>

        <div class="mb-3">
            <label for="release_year" class="form-label">公開年</label>
            <input type="number" class="form-control" id="release_year" name="release_year" value="{{ old('release_year', $movie->release_year) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">概要</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $movie->description) }}</textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_showing" name="is_showing" value="1" {{ old('is_showing', $movie->is_showing) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_showing">上映中</label>
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection