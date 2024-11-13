<!-- resources/views/sheets/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>座席表</title>
    <style>
        table { border-collapse: collapse; }
        td { border: 1px solid black; padding: 10px; text-align: center; }
        .screen { font-weight: bold; background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h1>座席表</h1>
    <table>
        <tr>
            <td></td>
            <td></td>
            <td class="screen" colspan="3">スクリーン</td>
            <td></td>
            <td></td>
        </tr>
        @foreach($sheets->groupBy('row') as $row => $rowSheets)
            <tr>
                @foreach($rowSheets as $sheet)
                    <td>{{ $sheet->row }}-{{ $sheet->column }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>