@extends('layouts.admin')

@section('content')
    <h1>映画詳細</h1>
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
            <td>{{ $movie->is_showing ? '公開中' : '公開予定' }}</td>
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
    <a href="{{ route('admin.movies.index') }}">一覧に戻る</a>
@endsection
