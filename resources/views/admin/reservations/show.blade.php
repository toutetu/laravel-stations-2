@extends('layouts.admin')

@section('content')
    <h1>予約詳細・編集</h1>

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

    <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="schedule_id" value="{{ $reservation->schedule_id }}">
        <input type="hidden" name="sheet_id" value="{{ $reservation->sheet_id }}">
        <input type="hidden" name="date" value="{{ $reservation->date }}">

        <div class="form-group">
            <label>映画：</label>
            <input type="text" class="form-control" value="{{ $reservation->schedule->movie->title }}" readonly>
        </div>

        <div class="form-group">
            <label>座席：</label>
            <input type="text" class="form-control" value="{{ $reservation->sheet->row }}{{ $reservation->sheet->column }}" readonly>
        </div>

        <div class="form-group">
            <label>日時：</label>
            <input type="text" class="form-control" value="{{ $reservation->date }} {{ $reservation->schedule->start_time }}" readonly>
        </div>

        <div class="form-group">
            <label for="name">名前：</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $reservation->name }}">
        </div>

        <div class="form-group">
            <label for="email">メールアドレス：</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $reservation->email }}">
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>

    <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
    </form>

    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">戻る</a>
@endsection
