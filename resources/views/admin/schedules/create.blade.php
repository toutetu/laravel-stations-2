@extends('layouts.admin')

@section('content')
    <h1>新規スケジュール作成</h1>
    <h2>作品: {{ $movie->title }}</h2>

    <form action="{{ route('admin.schedules.store', $movie->id) }}" method="POST">
        @csrf
        <div>
            <label for="start_time_date">開始日付:</label>
            <input type="date" name="start_time_date" required>
        </div>
        <div>
            <label for="start_time_time">開始時間:</label>
            <input type="time" name="start_time_time" required>
        </div>
        <div>
            <label for="end_time_date">終了日付:</label>
            <input type="date" name="end_time_date" required>
        </div>
        <div>
            <label for="end_time_time">終了時間:</label>
            <input type="time" name="end_time_time" required>
        </div>
        <button type="submit">作成</button>
    </form>
@endsection
