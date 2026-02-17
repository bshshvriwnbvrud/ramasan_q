@extends('layouts.app')

@section('title', 'اقتراح الفائزين')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4"><i class="bi bi-magic me-2"></i>اقتراح فائزي اليوم {{ $competition->day_number }}</h2>

    @if(empty($suggested))
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            لا توجد نتائج كافية لاقتراح فائزين.
        </div>
        <a href="{{ route('admin.competitions.winners.index', $competition) }}" class="btn btn-secondary">عودة</a>
    @else
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.competitions.winners.store', $competition) }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr><th>المركز</th><th>المستخدم</th><th>الدرجة</th><th>ملاحظات</th></tr>
                            </thead>
                            <tbody>
                                @foreach($suggested as $index => $item)
                                    <tr>
                                        <td>
                                            <input type="number" name="winners[{{ $index }}][rank]"
                                                   value="{{ $item['rank'] }}" class="form-control form-control-sm" style="width:80px;" readonly>
                                        </td>
                                        <td>
                                            <select name="winners[{{ $index }}][user_id]" class="form-select" required>
                                                <option value="{{ $item['user_id'] }}" selected>
                                                    {{ \App\Models\User::find($item['user_id'])->name }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>{{ $item['score'] }}</td>
                                        <td><input type="text" name="winners[{{ $index }}][note]" class="form-control form-control-sm" placeholder="اختياري"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-success">حفظ الفائزين</button>
                    <a href="{{ route('admin.competitions.winners.index', $competition) }}" class="btn btn-secondary">إلغاء</a>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection