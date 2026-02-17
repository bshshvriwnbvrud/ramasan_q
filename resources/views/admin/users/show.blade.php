@extends('layouts.app')

@section('title', 'عرض المستخدم')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-person-badge me-2"></i>بيانات المستخدم</h2>
        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i>عودة
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">الاسم</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>البريد الإلكتروني</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>رقم الهاتف</th>
                    <td>{{ $user->phone }}</td>
                </tr>
                <tr>
                    <th>التخصص</th>
                    <td>{{ $user->major ?? '—' }}</td>
                </tr>
                <tr>
                    <th>رقم القيد</th>
                    <td>{{ $user->student_no ?? '—' }}</td>
                </tr>
                <tr>
                    <th>الدور</th>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge bg-danger">مدير</span>
                        @elseif($user->role == 'supervisor')
                            <span class="badge bg-warning text-dark">مشرف</span>
                        @elseif($user->role == 'editor')
                            <span class="badge bg-info">محرر</span>
                        @else
                            <span class="badge bg-secondary">طالب</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>الحالة</th>
                    <td>
                        @if($user->status == 'approved')
                            <span class="badge bg-success">مقبول</span>
                        @elseif($user->status == 'pending')
                            <span class="badge bg-warning text-dark">قيد المراجعة</span>
                        @else
                            <span class="badge bg-danger">مرفوض</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>تاريخ التسجيل</th>
                    <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @if($user->approved_at)
                <tr>
                    <th>تاريخ القبول</th>
                    <td>{{ $user->approved_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endif
            </table>

            @if(auth()->user()->role == 'admin')
                <div class="mt-4">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>تعديل
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection