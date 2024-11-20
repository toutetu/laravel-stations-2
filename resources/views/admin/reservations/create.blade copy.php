@extends('layouts.admin')

@section('content')
    <h1>新規予約</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.reservations.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="movie_id">映画</label>
            <select name="movie_id" id="movie_id" class="form-control" required>
                @foreach ($movies as $movie)
                    <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="schedule_id">スケジュール</label>
            <select name="schedule_id" id="schedule_id" class="form-control" required>
                @foreach ($schedules as $schedule)
                    <option value="{{ $schedule->id }}">{{ $schedule->start_time }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="sheet_id">座席</label>
            <select name="sheet_id" id="sheet_id" class="form-control" required>
                @foreach ($sheets as $sheet)
                    <option value="{{ $sheet->id }}">{{ $sheet->row }}{{ $sheet->column }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="date">日付</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">予約する</button>
    </form>
@endsection