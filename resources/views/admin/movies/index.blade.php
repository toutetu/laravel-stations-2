@extends('layouts.admin')

@section('content')
    <h1>映画一覧</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>映画タイトル</th>
                <th>画像URL</th>
                <th>公開年</th>
                <th>上映中</th>
                <th>概要</th>
                <th>登録日時</th>
                <th>更新日時</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movies as $movie)
                <tr>
                    <td>{{ $movie->id }}</td>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->image_url }}</td>
                    <td>{{ $movie->published_year }}</td>
                    <td>{{ $movie->is_showing ? '上映中' : '上映予定' }}</td>
                    <td>{{ Str::limit($movie->description, 50) }}</td>
                    <td>{{ $movie->created_at }}</td>
                    <td>{{ $movie->updated_at }}</td>
                    <td><a href="{{ route('admin.movies.show', $movie) }}">詳細</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
