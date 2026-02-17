@extends('layouts.app')

@section('title', 'إدارة أيام رمضان')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-calendar2-week-fill me-2"></i>أيام رمضان</h2>
        <a href="{{ route('admin.competitions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>إنشاء يوم جديد
        </a>
    </div>

    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>اليوم</th>
                            <th>العنوان</th>
                            <th>البداية</th>
                            <th>النهاية</th>
                            <th>شخصية اليوم</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($competitions as $c)
                        <tr>
                            <td><span class="fw-bold">اليوم {{ $c->day_number }}</span></td>
                            <td>{{ $c->title ?? '—' }}</td>
                            <td>{{ $c->starts_at->format('Y-m-d h:i A') }}</td>
                            <td>{{ $c->ends_at->format('Y-m-d h:i A') }}</td>
                            <td>
                                @if($c->personality_enabled)
                                    <span class="badge bg-info" data-bs-toggle="tooltip" title="{{ $c->personality_name }}">
                                        <i class="bi bi-star-fill text-warning me-1"></i>مفعلة
                                    </span>
                                @else
                                    <span class="badge bg-secondary">غير مفعلة</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $c->is_published ? 'success' : 'secondary' }}">
                                    {{ $c->is_published ? 'منشور' : 'غير منشور' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.competitions.edit', $c) }}" class="btn btn-sm btn-outline-primary" title="تعديل">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.competitions.winners.index', $c) }}" class="btn btn-sm btn-outline-warning" title="الفائزين">
                                        <i class="bi bi-trophy"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.competitions.toggle', $c) }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-{{ $c->is_published ? 'secondary' : 'success' }}" title="{{ $c->is_published ? 'إلغاء النشر' : 'نشر' }}">
                                            <i class="bi bi-{{ $c->is_published ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // تفعيل tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection