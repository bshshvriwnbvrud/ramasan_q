@extends('layouts.app')

@section('title', 'سجل النشاطات')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4"><i class="bi bi-clock-history me-2"></i>سجل النشاطات</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>الوقت</th>
                            <th>المستخدم</th>
                            <th>الوصف</th>
                            <th>التفاصيل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    @if($log->causer)
                                        <span class="fw-medium">{{ $log->causer->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">نظام</span>
                                    @endif
                                </td>
                                <td>{{ $log->description }}</td>
                                <td>
                                    @if($log->properties)
                                        <button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="collapse" data-bs-target="#log-{{ $log->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <div class="collapse mt-2" id="log-{{ $log->id }}">
                                            <pre class="bg-light p-2 rounded small">{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">لا توجد نشاطات.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection