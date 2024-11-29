@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">上映スケジュール一覧</h1>
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

    @foreach($movies as $movie)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">{{ $movie->title }}</h2>
                <!-- <a href="{{ route('admin.schedules.create', $movie->id) }}" class="btn btn-primary">スケジュールの追加</a> -->
                <a href="{{ route('admin.schedules.create', ['id' => $movie->id]) }}" class="btn btn-primary">スケジュールの追加</a>
            </div>
            <div class="card-body">
                @if($movie->schedules->isNotEmpty())
                    <ul class="list-group">
                        @foreach($movie->schedules as $schedule)
                            <li class="list-group-item">
                                <a href="{{ route('admin.schedules.show', $schedule->id) }}">
                                    開始時刻: {{ $schedule->start_time->format('H:i') }} - 
                                    終了時刻: {{ $schedule->end_time->format('H:i') }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">スケジュールの登録はありません</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection