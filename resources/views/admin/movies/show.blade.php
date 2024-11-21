@extends('layouts.admin')

@section('content')
    <h1>映画詳細</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table>
        <tr>
            <th>ID</th>
            <td>{{ $movie->id }}</td>
        </tr>
        <tr>
            <th>映画タイトル</th>
            <td>{{ $movie->title }}</td>
        </tr>
        <tr>
            <th>画像URL</th>
            <td>{{ $movie->image_url }}</td>
        </tr>
        <tr>
            <th>公開年</th>
            <td>{{ $movie->published_year }}</td>
        </tr>
        <tr>
            <th>公開中かどうか</th>
            <td>{{ $movie->is_showing ? '上映中' : '上映予定' }}</td>
        </tr>
        <tr>
            <th>ジャンル</th>
            <td>{{ $movie->genre->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>概要</th>
            <td>{{ $movie->description }}</td>
        </tr>
        <tr>
            <th>登録日時</th>
            <td>{{ $movie->created_at }}</td>
        </tr>
        <tr>
            <th>更新日時</th>
            <td>{{ $movie->updated_at }}</td>
        </tr>
    </table>
    <h2>スケジュール</h2>
        <a href="{{ route('admin.schedules.create', $movie->id) }}">新規スケジュール作成</a>
        <ul>
            @foreach($movie->schedules as $schedule)
                <li>
                    <a href="{{ route('admin.schedules.show', $schedule->id) }}">
                        開始時刻: {{ $schedule->start_time }} - 終了時刻: {{ $schedule->end_time }}
                    </a>
                </li>
            @endforeach
        </ul>
    <a href="{{ route('admin.movies.index') }}">一覧に戻る</a>
@endsection