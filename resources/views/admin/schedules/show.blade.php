@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">スケジュール詳細</h1>
    <div class="bg-light p-4 rounded">
        <dl class="row">
            <dt class="col-sm-3">作品ID:</dt>
            <dd class="col-sm-9">{{ $schedule->movie_id }}</dd>

            <dt class="col-sm-3">作品名:</dt>
            <dd class="col-sm-9">{{ $schedule->movie->title }}</dd>

            <dt class="col-sm-3">開始時刻:</dt>
            <dd class="col-sm-9">{{ $schedule->start_time->format('Y年m月d日 H:i') }}</dd>

            <dt class="col-sm-3">終了時刻:</dt>
            <dd class="col-sm-9">{{ $schedule->end_time->format('Y年m月d日 H:i') }}</dd>

            <dt class="col-sm-3">作成日時:</dt>
            <dd class="col-sm-9">{{ $schedule->created_at->format('Y年m月d日 H:i:s') }}</dd>

            <dt class="col-sm-3">更新日時:</dt>
            <dd class="col-sm-9">{{ $schedule->updated_at->format('Y年m月d日 H:i:s') }}</dd>
        </dl>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-primary me-2">
            <i class="fas fa-edit"></i> 編集
        </a>

        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('本当に削除しますか？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i> 削除
            </button>
        </form>
    </div>
</div>
@endsection