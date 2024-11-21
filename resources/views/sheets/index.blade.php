@extends('layouts.app')

@section('content')
<h2>座席表</h2>
<div class="card mt-4">
    <div class="card-body">
        <div class="seats-container">
            <div class="screen mb-4">スクリーン</div>
            @php
                $rows = $sheets->groupBy('row');
            @endphp
            @foreach ($rows as $row => $rowSheets)
                <div class="seat-row">
                    @foreach ($rowSheets as $sheet)
                        <div class="seat available">
                            <span>{{ $sheet->row }}{{ $sheet->column }}</span>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection