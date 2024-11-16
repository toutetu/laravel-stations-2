@extends('layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h2>座席表</h2>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <p><strong>映画:</strong> {{ $movie->title }}</p>
            <p><strong>日付:</strong> {{ $date }}</p>
            <p><strong>時間:</strong> {{ $schedule->start_time }}</p>

            <div class="seats-container">
                <div class="screen">スクリーン</div>
                @php
                    $rows = $sheets->groupBy('row');
                @endphp
                @foreach ($rows as $row => $rowSheets)
                    <div class="seat-row">
                        @foreach ($rowSheets as $sheet)
                            <div class="seat {{ in_array($sheet->id, $reservedSheets) ? 'reserved' : 'available' }}">
                                @if (in_array($sheet->id, $reservedSheets))
                                    <span>{{ $sheet->row }}{{ $sheet->column }}</span>
                                @else
                                    <a href="{{ route('reservations.create', ['movie_id' => $movie->id, 'schedule_id' => $schedule->id, 'date' => $date, 'sheetId' => $sheet->id]) }}">
                                        {{ $sheet->row }}{{ $sheet->column }}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection