@extends('layouts.app')

@section('title', 'تعديل المستخدم')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4"><i class="bi bi-person-gear me-2"></i>تعديل بيانات المستخدم</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">التخصص</label>
                        <input type="text" name="major" class="form-control" value="{{ old('major', $user->major) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم القيد</label>
                        <input type="text" name="student_no" class="form-control" value="{{ old('student_no', $user->student_no) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الدور</label>
                        <select name="role" class="form-select">
                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>طالب</option>
                            <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>محرر</option>
                            <option value="supervisor" {{ $user->role == 'supervisor' ? 'selected' : '' }}>مشرف</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>مدير</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                            <option value="approved" {{ $user->status == 'approved' ? 'selected' : '' }}>مقبول</option>
                            <option value="rejected" {{ $user->status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection