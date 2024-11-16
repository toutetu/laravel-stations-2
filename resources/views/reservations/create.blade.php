@extends('layouts.app')

@section('content')
    <h1>座席予約</h1>
    <form method="POST" action="{{ route('reservations.store', [ 'schedule_id' => $schedule->id]) }}">
        @csrf
        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
        <input type="hidden" name="sheet_id" value="{{ $sheetId }}">
        <input type="hidden" name="date" value="{{ $date }}">
        
        <p>映画: {{ $movie->title }}</p>
        <p>日付: {{ $date }}</p>
        <p>時間: {{ $schedule->start_time }}</p>
        <p>座席番号: {{ $sheetId }}</p>

        <div>
            <label for="name">名前:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="email">メールアドレス:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <button type="submit">予約する</button>
    </form>
@endsection
