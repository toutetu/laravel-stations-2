@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">予約の詳細・編集・削除</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="schedule_id" value="{{ $reservation->schedule_id }}">
        <input type="hidden" name="sheet_id" value="{{ $reservation->sheet_id }}">
        <input type="hidden" name="date" value="{{ $reservation->date }}">

        <div class="mb-3">
            <label class="form-label fw-bold">映画</label>
            <input type="text" class="form-control" value="{{ $reservation->schedule->movie->title }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">座席</label>
            <input type="text" class="form-control" value="{{ $reservation->sheet->row }}{{ $reservation->sheet->column }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">日時</label>
            <!-- <input type="text" class="form-control" value="{{ $reservation->date }} {{ $reservation->schedule->start_time }}" readonly> -->
            <input type="text" class="form-control" value="{{ $reservation->schedule->start_time }}" readonly>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label fw-bold">名前</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $reservation->name }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-bold">メールアドレス</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $reservation->email }}">
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">更新</button>
            <!-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                削除
            </button> -->
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">戻る</a>
        </div>
    </form>

    <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？？')">削除</button>
    </form>

    <!-- 削除確認モーダル -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">削除の確認</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    この予約を削除してもよろしいですか？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection