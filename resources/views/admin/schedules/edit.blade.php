@extends('layouts.admin')

@section('content')
    <h1>スケジュール編集</h1>
    <h2>作品: {{ $schedule->movie->title }}</h2>

    <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div>
            <label for="start_time_date">開始日付:</label>
            <input type="date" name="start_time_date" value="{{ date('Y-m-d', strtotime($schedule->start_time)) }}" required>
        </div>
        <div>
            <label for="start_time_time">開始時間:</label>
            <input type="time" name="start_time_time" value="{{ date('H:i', strtotime($schedule->start_time)) }}" required>
        </div>
        <div>
            <label for="end_time_date">終了日付:</label>
            <input type="date" name="end_time_date" value="{{ date('Y-m-d', strtotime($schedule->end_time)) }}" required>
        </div>
        <div>
            <label for="end_time_time">終了時間:</label>
            <input type="time" name="end_time_time" value="{{ date('H:i', strtotime($schedule->end_time)) }}" required>
        </div>
        <button type="submit">更新</button>
    </form>

    <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button type="submit">削除</button>
    </form>
@endsection
