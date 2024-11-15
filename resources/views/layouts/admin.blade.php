<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>映画管理画面</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
    </style>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>映画管理システム</h1>
    </header>
    <nav>
        <ul>
            <li><a href="{{ route('admin.movies.index') }}">映画一覧</a></li>
            <li><a href="{{ route('admin.movies.create') }}">新規映画登録</a></li>
            <li><a href="{{ route('admin.schedules.index') }}">スケジュール一覧</a></li>
        </ul>
    </nav>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <main>
        @yield('content')
    </main>
    <footer>
        <p>&copy; 2024 映画管理システム</p>
    </footer>
</body>
</html>