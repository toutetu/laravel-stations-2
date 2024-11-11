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
    </style>
</head>
<body>
    <header>
        <h1>映画管理システム</h1>
    </header>
    <nav>
        <ul>
            <li><a href="{{ route('admin.movies.index') }}">映画一覧</a></li>
        </ul>
    </nav>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>&copy; 2024 映画管理システム</p>
    </footer>
</body>
</html>