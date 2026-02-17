@extends('layouts.app')

@section('title', 'طلبات تعديل الملفات الشخصية')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4"><i class="bi bi-person-badge me-2"></i>طلبات تعديل الملفات الشخصية</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>المستخدم</th>
                            <th>البيانات الحالية</th>
                            <th>البيانات الجديدة</th>
                            <th>الحالة</th>
                            <th>تاريخ الطلب</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>{{ $req->user->name ?? '—' }}</td>
                                <td>
                                    <small>
                                        @if($req->old_data)
                                            {{ $req->old_data['name'] ?? '' }}<br>
                                            {{ $req->old_data['email'] ?? '' }}
                                        @else
                                            —
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <small>
                                        @if($req->new_data)
                                            {{ $req->new_data['name'] ?? '' }}<br>
                                            {{ $req->new_data['email'] ?? '' }}
                                        @else
                                            —
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    @if($req->status == 'pending')
                                        <span class="badge bg-warning">قيد المراجعة</span>
                                    @elseif($req->status == 'approved')
                                        <span class="badge bg-success">مقبول</span>
                                    @else
                                        <span class="badge bg-danger">مرفوض</span>
                                    @endif
                                </td>
                                <td>{{ $req->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.profile_requests.show', $req) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">لا توجد طلبات.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection