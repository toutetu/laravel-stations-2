@extends('layouts.app')

@section('content')
    <h1>座席予約</h1>
    <form method="POST" action="{{ route('reservations.store', [ 'schedule_id' => $schedule->id]) }}">
        @csrf
        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
        <input type="hidden" name="sheet_id" value="{{ $sheetId }}">
        <input type="hidden" name="date" value="{{ $schedule->start_time }}">
        
        <p>映画: {{ $movie->title }}</p>
        <p><strong>日付:</strong> {{ \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d') }}</p>
        <p><strong>開始時刻:</strong> {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:m') }}</p>
        <p><strong>終了時刻:</strong> {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:m') }}</p>
        @php
        $sheet = App\Models\Sheet::find($sheetId);
        @endphp
        <p>座席番号: {{ $sheet ? strtoupper($sheet->row) . $sheet->column : 'N/A' }}</p>

        <div>
            <label for="name">名前:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="email">メールアドレス:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <button type="submit" class="btn btn-primary">予約する</button>
    </form>
@endsection
