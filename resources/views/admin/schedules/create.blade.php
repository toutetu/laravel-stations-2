@extends('layouts.admin')

@section('content')
    <h1>新規スケジュール作成</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>作品: {{ $movie->title }}</h2>
    <form action="{{ route('admin.schedules.store', ['id' => $movie->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
        <div>
            <label for="start_time_date">開始日付:</label>
            <input type="date" name="start_time_date" value="{{ old('start_time_date', date('Y-m-d')) }}" pattern="\d{4}-\d{2}-\d{2}" required>
        </div>
        <div>
            <label for="start_time_time">開始時間:</label>
            <input type="time" name="start_time_time" value="{{ old('start_time_time', '00:00') }}" pattern="[0-2][0-9]:[0-5][0-9]" required>
        </div>
        <div>
            <label for="end_time_date">終了日付:</label>
            <input type="date" name="end_time_date" value="{{ old('end_time_date', date('Y-m-d')) }}" pattern="\d{4}-\d{2}-\d{2}" required>
        </div>
        <div>
            <label for="end_time_time">終了時間:</label>
            <input type="time" name="end_time_time" value="{{ old('end_time_time', '00:00') }}" pattern="[0-2][0-9]:[0-5][0-9]" required>
        </div>
        <button type="submit" class="btn btn-primary">作成</button>
    </form>
@endsection
