@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $movie->title }}</h1>
    
    <div class="row">
        <div class="col-md-4">
            <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}" class="img-fluid">
        </div>
        <div class="col-md-8">
            <table class="table">
                <tr>
                    <th>公開年</th>
                    <td>{{ $movie->published_year ?? '未設定' }}</td>
                </tr>
                <tr>
                    <th>公開状況</th>
                    <td>{{ $movie->is_showing ? '公開中' : '未公開' }}</td>
                </tr>
                <tr>
                    <th>ジャンル</th>
                    <td>{{ $movie->genre->name ?? '未設定' }}</td>
                </tr>
                <tr>
                    <th>概要</th>
                    <td>{{ $movie->description ?? '概要なし' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <h2 class="mt-4">上映スケジュール</h2>
    @if($movie->schedules->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>開始時間</th>
                    <th>終了時間</th>
                    <th>予約</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movie->schedules as $schedule)
                    <tr>
                    <td>{{ $schedule->start_time instanceof \DateTime ? $schedule->start_time->format('Y-m-d H:i') : $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time instanceof \DateTime ? $schedule->end_time->format('Y-m-d H:i') : $schedule->end_time }}</td>
                    <td><a href="{{ route('movies.schedules.sheets', ['movie_id' => $movie->id, 'schedule_id' => $schedule->id, 'date' => date('Y-m-d')]) }}">
                    座席を予約する
                    </a></td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    @else
        <p>現在スケジュールはありません。</p>
    @endif
</div>
@endsection