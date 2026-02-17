@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card glass-card border-0" data-aos="zoom-in">
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, var(--primary-gold), #d49a1e); border-radius: 40px 40px 0 0; border-bottom: 1px solid var(--glass-border);">
                    <h4 class="mb-0 text-dark fw-bold"><i class="bi bi-person-circle me-2"></i>الملف الشخصي</h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-glass-success" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-glass-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if(isset($pendingRequest) && $pendingRequest)
                        <div class="alert alert-glass-warning" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            لديك طلب تعديل قيد المراجعة (تم إرساله في {{ $pendingRequest->created_at->format('Y-m-d H:i') }}). يرجى الانتظار.
                        </div>
                    @endif

                    <table class="table table-borderless text-white">
                        <tr>
                            <th width="200" class="text-white-50">الاسم</th>
                            <td class="fw-bold">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-white-50">البريد الإلكتروني</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th class="text-white-50">رقم الهاتف</th>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <th class="text-white-50">التخصص</th>
                            <td>{{ $user->major ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th class="text-white-50">رقم القيد</th>
                            <td>{{ $user->student_no ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th class="text-white-50">الدور</th>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge badge-glass-danger">مدير</span>
                                @elseif($user->role == 'supervisor')
                                    <span class="badge badge-glass-warning">مشرف</span>
                                @elseif($user->role == 'editor')
                                    <span class="badge badge-glass-info">محرر</span>
                                @else
                                    <span class="badge badge-glass-secondary">طالب</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-white-50">حالة الحساب</th>
                            <td>
                                @if($user->status == 'approved')
                                    <span class="badge badge-glass-success">مقبول</span>
                                @elseif($user->status == 'pending')
                                    <span class="badge badge-glass-warning">قيد المراجعة</span>
                                @else
                                    <span class="badge badge-glass-danger">مرفوض</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if(!isset($pendingRequest) || !$pendingRequest)
                        <div class="text-center mt-4">
                            <a href="{{ route('student.profile.edit') }}" class="btn-premium btn-primary-gold">
                                <i class="bi bi-pencil me-2"></i>طلب تعديل البيانات
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* بطاقة زجاجية */
    .glass-card {
        background: var(--glass-bg) !important;
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 40px;
        color: white;
    }

    /* التنبيهات الزجاجية */
    .alert-glass-success {
        background: rgba(40, 167, 69, 0.2);
        backdrop-filter: blur(8px);
        border: 1px solid #28a745;
        color: #28a745;
        border-radius: 30px;
        padding: 1rem 1.5rem;
    }
    .alert-glass-danger {
        background: rgba(220, 53, 69, 0.2);
        backdrop-filter: blur(8px);
        border: 1px solid #dc3545;
        color: #dc3545;
        border-radius: 30px;
        padding: 1rem 1.5rem;
    }
    .alert-glass-warning {
        background: rgba(255, 193, 7, 0.2);
        backdrop-filter: blur(8px);
        border: 1px solid #ffc107;
        color: #ffc107;
        border-radius: 30px;
        padding: 1rem 1.5rem;
    }

    /* الشارات الزجاجية */
    .badge-glass-success {
        background: rgba(40, 167, 69, 0.2);
        border: 1px solid #28a745;
        color: #28a745;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }
    .badge-glass-danger {
        background: rgba(220, 53, 69, 0.2);
        border: 1px solid #dc3545;
        color: #dc3545;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }
    .badge-glass-warning {
        background: rgba(255, 193, 7, 0.2);
        border: 1px solid #ffc107;
        color: #ffc107;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }
    .badge-glass-info {
        background: rgba(23, 162, 184, 0.2);
        border: 1px solid #17a2b8;
        color: #17a2b8;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }
    .badge-glass-secondary {
        background: rgba(108, 117, 125, 0.2);
        border: 1px solid #6c757d;
        color: #adb5bd;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }

    /* الجدول */
    .table th, .table td {
        border-color: rgba(255,255,255,0.1);
    }
    .table th {
        font-weight: 500;
    }

    /* الزر المميز */
    .btn-premium {
        padding: 0.8rem 2.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        position: relative;
        overflow: hidden;
        display: inline-block;
        text-decoration: none;
    }

    .btn-primary-gold {
        background: linear-gradient(135deg, var(--primary-gold), #d49a1e);
        color: var(--dark-blue) !important;
        box-shadow: 0 10px 20px rgba(212, 154, 30, 0.3);
    }

    .btn-primary-gold:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(212, 154, 30, 0.5);
    }
</style>
@endpush