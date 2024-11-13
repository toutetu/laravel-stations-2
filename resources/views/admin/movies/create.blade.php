@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="page-title">新規映画登録</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.movies.store') }}" method="POST" class="movie-form">
        @csrf
        <div class="form-group">
            <label for="title">映画タイトル:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required class="form-control" lang="ja" placeholder="例: となりのトトロ" autofocus>
            @error('title')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image_url">画像URL:</label>
            <input type="url" id="image_url" name="image_url" value="{{ old('image_url') }}" required class="form-control">
            @error('image_url')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="published_year">公開年:</label>
            <select id="published_year" name="published_year" class="form-control">
                <option value="">選択してください</option>
                @for ($year = 2024; $year >= 1950; $year--)
                    <option value="{{ $year }}" {{ old('published_year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endfor
            </select>
            @error('published_year')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">概要:</label>
            <textarea id="description" name="description" class="form-control" lang="ja" placeholder="映画の概要を入力してください">{{ old('description') }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="genre">ジャンル:</label>
            <input type="text" id="genre" name="genre" value="{{ old('genre') }}" required class="form-control" lang="ja" placeholder="例: アクション">
            @error('genre')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group checkbox-group">
            <input type="checkbox" id="is_showing" name="is_showing" value="1" {{ old('is_showing') ? 'checked' : '' }} class="form-checkbox">
            <label for="is_showing">公開中</label>
            @error('is_showing')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">登録</button>
    </form>
</div>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    .page-title {
        color: #333;
        margin-bottom: 30px;
    }
    .movie-form {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }
    textarea.form-control {
        height: 100px;
    }
    .checkbox-group {
        display: flex;
        align-items: center;
    }
    .form-checkbox {
        margin-right: 10px;
    }
    .btn {
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
</style>
@endsection