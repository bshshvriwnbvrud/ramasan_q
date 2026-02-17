@extends('layouts.app')

@section('title', 'تفاصيل الطلب')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-file-text me-2"></i>تفاصيل طلب تعديل الملف الشخصي</h2>
        <a href="{{ route('admin.profile_requests.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i>عودة
        </a>
    </div>

    @if(!isset($profileRequest))
        <div class="alert alert-danger">الطلب غير موجود.</div>
    @else
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">البيانات الحالية</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr><th>الاسم</th><td>{{ $profileRequest->old_data['name'] ?? '' }}</td></tr>
                            <tr><th>البريد</th><td>{{ $profileRequest->old_data['email'] ?? '' }}</td></tr>
                            <tr><th>الهاتف</th><td>{{ $profileRequest->old_data['phone'] ?? '' }}</td></tr>
                            <tr><th>التخصص</th><td>{{ $profileRequest->old_data['major'] ?? '—' }}</td></tr>
                            <tr><th>رقم القيد</th><td>{{ $profileRequest->old_data['student_no'] ?? '—' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100 border-warning">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0">البيانات الجديدة المطلوبة</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr><th>الاسم</th><td>{{ $profileRequest->new_data['name'] ?? '' }}</td></tr>
                            <tr><th>البريد</th><td>{{ $profileRequest->new_data['email'] ?? '' }}</td></tr>
                            <tr><th>الهاتف</th><td>{{ $profileRequest->new_data['phone'] ?? '' }}</td></tr>
                            <tr><th>التخصص</th><td>{{ $profileRequest->new_data['major'] ?? '—' }}</td></tr>
                            <tr><th>رقم القيد</th><td>{{ $profileRequest->new_data['student_no'] ?? '—' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if($profileRequest->status == 'pending')
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <form method="POST" action="{{ route('admin.profile_requests.approve', $profileRequest->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('موافقة على الطلب؟')">
                                <i class="bi bi-check-circle me-2"></i>موافقة
                            </button>
                        </form>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="bi bi-x-circle me-2"></i>رفض
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal للرفض مع إدخال ملاحظات -->
            <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.profile_requests.reject', $profileRequest->id) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectModalLabel">رفض الطلب</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="admin_note" class="form-label">ملاحظات (اختياري)</label>
                                    <textarea name="admin_note" id="admin_note" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                <button type="submit" class="btn btn-danger">تأكيد الرفض</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-{{ $profileRequest->status == 'approved' ? 'success' : 'danger' }}">
                تم {{ $profileRequest->status == 'approved' ? 'الموافقة' : 'الرفض' }} على هذا الطلب بواسطة 
                {{ $profileRequest->processor->name ?? '—' }} 
                @if($profileRequest->processed_at)
                    في {{ $profileRequest->processed_at->format('Y-m-d H:i') }}
                @endif
                @if($profileRequest->admin_note)
                    <br><strong>ملاحظات:</strong> {{ $profileRequest->admin_note }}
                @endif
            </div>
        @endif
    @endif
</div>
@endsection