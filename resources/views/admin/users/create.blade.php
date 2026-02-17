@extends('layouts.app')

@section('title', 'إضافة مستخدم جديد')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4"><i class="bi bi-person-plus-fill me-2"></i>إضافة مستخدم جديد</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">التخصص</label>
                        <input type="text" name="major" class="form-control" value="{{ old('major') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم القيد</label>
                        <input type="text" name="student_no" class="form-control" value="{{ old('student_no') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">كلمة المرور</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الدور</label>
                        <select name="role" class="form-select" required>
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>طالب</option>
                            <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>محرر</option>
                            <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>مشرف</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>مقبول</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection