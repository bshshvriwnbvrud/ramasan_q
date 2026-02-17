@extends('layouts.app')

@section('title', 'تعديل الملف الشخصي')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card glass-card border-0" data-aos="zoom-in">
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, var(--primary-gold), #d49a1e); border-radius: 40px 40px 0 0; border-bottom: 1px solid var(--glass-border);">
                    <h4 class="mb-0 text-dark fw-bold"><i class="bi bi-pencil-square me-2"></i>طلب تعديل البيانات</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('student.profile.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label text-white-50">الاسم</label>
                            <input type="text" name="name" class="form-control glass-input" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control glass-input" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control glass-input" value="{{ old('phone', $user->phone) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50">التخصص (اختياري)</label>
                            <input type="text" name="major" class="form-control glass-input" value="{{ old('major', $user->major) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50">رقم القيد (اختياري)</label>
                            <input type="text" name="student_no" class="form-control glass-input" value="{{ old('student_no', $user->student_no) }}">
                        </div>

                        <div class="alert alert-glass-info">
                            <i class="bi bi-info-circle me-2"></i>
                            بعد إرسال الطلب، سيقوم الأدمن بمراجعته والموافقة عليه. سيتم إشعارك عند الانتهاء.
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn-premium btn-primary-gold flex-grow-1">
                                <i class="bi bi-send me-2"></i>إرسال الطلب
                            </button>
                            <a href="{{ route('student.profile') }}" class="btn-premium btn-outline-gold">
                                <i class="bi bi-x-circle me-2"></i>إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* البطاقة الزجاجية */
    .glass-card {
        background: var(--glass-bg) !important;
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 40px;
        color: white;
    }

    /* حقول الإدخال الزجاجية */
    .glass-input {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 2px solid var(--glass-border) !important;
        border-radius: 30px !important;
        color: white !important;
        padding: 0.75rem 1.5rem !important;
        transition: all 0.3s;
    }

    .glass-input:focus {
        background: rgba(255, 255, 255, 0.15) !important;
        border-color: var(--primary-gold) !important;
        box-shadow: 0 0 15px rgba(247, 183, 49, 0.5) !important;
        outline: none;
    }

    .glass-input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    /* تنبيه زجاجي بالمعلومات */
    .alert-glass-info {
        background: rgba(23, 162, 184, 0.2);
        backdrop-filter: blur(8px);
        border: 1px solid #17a2b8;
        color: #17a2b8;
        border-radius: 30px;
        padding: 1rem 1.5rem;
    }

    /* الأزرار المميزة */
    .btn-premium {
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    .btn-outline-gold {
        background: transparent;
        color: white;
        border: 2px solid var(--primary-gold);
    }

    .btn-outline-gold:hover {
        background: var(--primary-gold);
        color: var(--dark-blue);
        transform: translateY(-5px);
    }

    /* تسميات الحقول */
    .form-label {
        font-weight: 500;
        margin-right: 0.5rem;
    }
</style>
@endpush