@extends('layouts.admin')

@section('content')
    <h1>新規予約</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

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
        <div class="form-group mb-3">
            <label for="movie_id">映画</label>
            <select name="movie_id" id="movie_id" class="form-control @error('movie_id') is-invalid @enderror" required>
                <option value="">選択してください</option>
                @foreach ($movies as $movie)
                    <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                        {{ $movie->title }}
                    </option>
                @endforeach
            </select>
            @error('movie_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="schedule_id">スケジュール</label>
            <select name="schedule_id" id="schedule_id" class="form-control @error('schedule_id') is-invalid @enderror" required>
                <option value="">選択してください</option>
                @foreach ($schedules as $schedule)
                    <option value="{{ $schedule->id }}" 
                            {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}
                            data-date="{{ date('Y-m-d', strtotime($schedule->start_time)) }}">
                        {{ $schedule->start_time }}
                    </option>
                @endforeach
            </select>
            @error('schedule_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="sheet_id">座席</label>
            <select name="sheet_id" id="sheet_id" class="form-control @error('sheet_id') is-invalid @enderror" required>
                <option value="">選択してください</option>
                @foreach ($sheets as $sheet)
                    <option value="{{ $sheet->id }}" {{ old('sheet_id') == $sheet->id ? 'selected' : '' }}>
                        {{ $sheet->row }}{{ $sheet->column }}
                    </option>
                @endforeach
            </select>
            @error('sheet_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- <div class="form-group">
            <label for="date">日付</label>
            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
            @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div> -->

        <!-- 日付を隠しフィールドとして追加 -->
        <input type="hidden" name="date" id="date" value="">

        <div class="form-group mb-3">
            <label for="name">名前</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">予約する</button>
    </form>

    <script>
        document.getElementById('schedule_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const date = selectedOption.getAttribute('data-date');
            document.getElementById('date').value = date;
        });
    </script>
@endsection