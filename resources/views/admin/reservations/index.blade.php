@extends('layouts.admin')

@section('content')
    <h1>予約一覧</h1>

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

    <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary mb-3">新規予約</a>

    <table class="table">
        <thead>
            <tr>
                <th>映画</th>
                <th>座席</th>
                <th>日時</th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->schedule->movie->title }}</td>
                    <!-- <td>{{ strtoupper($reservation->sheet->row . $reservation->sheet->column) }}</td> -->
                    <td>{{ strtoupper($reservation->sheet->number) }}</td>
                    <td>{{ $reservation->date }} {{ $reservation->schedule->start_time }}</td>
                    <td>{{ $reservation->name }}</td>
                    <td>{{ $reservation->email }}</td>
                    <td>
                    <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn btn-sm btn-info">詳細・編集</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
