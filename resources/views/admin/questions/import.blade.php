@extends('layouts.app')

@section('title', 'استيراد أسئلة')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h4 class="mb-0 fw-bold"><i class="bi bi-upload me-2"></i>استيراد أسئلة من ملف Excel</h4>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.questions.import') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="file" class="form-label fw-medium">اختر ملف Excel (xlsx, xls, csv)</label>
                    <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info">
                    <h5 class="alert-heading"><i class="bi bi-info-circle me-2"></i>صيغة الملف المطلوبة:</h5>
                    <p class="mb-0">يجب أن يحتوي الملف على الأعمدة التالية (بنفس الترتيب):</p>
                    <hr>
                    <ul class="mb-0">
                        <li><strong>text</strong> - نص السؤال</li>
                        <li><strong>choice_a</strong> - الخيار الأول</li>
                        <li><strong>choice_b</strong> - الخيار الثاني</li>
                        <li><strong>choice_c</strong> - الخيار الثالث</li>
                        <li><strong>choice_d</strong> - الخيار الرابع</li>
                        <li><strong>correct_choice</strong> - الحرف الصحيح (A,B,C,D)</li>
                        <li><strong>time_sec</strong> - الوقت بالثواني (اختياري)</li>
                    </ul>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">استيراد</button>
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection