@extends('layouts.app')

@section('title', 'فائزو اليوم ' . $competition->day_number)

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-trophy-fill me-2"></i>فائزو اليوم {{ $competition->day_number }}</h2>
        <div>
            @if(!$competition->results_published)
                <form method="POST" action="{{ route('admin.competitions.winners.publish', $competition) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-success" onclick="return confirm('سيتم نشر النتائج للمستخدمين. هل أنت متأكد؟')">
                        <i class="bi bi-megaphone me-1"></i>نشر النتائج
                    </button>
                </form>
            @else
                <span class="badge bg-success p-2">منشور</span>
            @endif
            <a href="{{ route('admin.competitions.winners.select', $competition) }}" class="btn btn-primary">
                <i class="bi bi-pencil-square me-2"></i>اختيار الفائزين يدويًا
            </a>
            <a href="{{ route('admin.competitions') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-right me-1"></i>عودة
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-transparent">
            <span>{{ $competition->title ?? '' }}</span>
        </div>
        <div class="card-body">
            @if($winners->isEmpty())
                <p class="text-muted text-center py-4">لم يتم تحديد فائزين بعد.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>المركز</th><th>الاسم</th><th>ملاحظات</th></tr>
                        </thead>
                        <tbody>
                            @foreach($winners as $winner)
                                <tr>
                                    <td>
                                        @if($winner->rank == 1) 🥇
                                        @elseif($winner->rank == 2) 🥈
                                        @elseif($winner->rank == 3) 🥉
                                        @else {{ $winner->rank }}
                                        @endif
                                    </td>
                                    <td>{{ $winner->user->name }}</td>
                                    <td>{{ $winner->note }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection