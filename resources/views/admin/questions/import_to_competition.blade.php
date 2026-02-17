@extends('layouts.app')

@section('title', 'استيراد أسئلة ليوم محدد')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-upload me-2"></i>استيراد أسئلة ليوم محدد</h2>
        <a href="{{ route('admin.questions.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i>عودة
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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
            <form method="POST" action="{{ route('admin.questions.import_to_competition') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="competition_id" class="form-label">اختر اليوم <span class="text-danger">*</span></label>
                        <select name="competition_id" id="competition_id" class="form-select" required>
                            <option value="">-- اختر اليوم --</option>
                            @foreach($competitions as $comp)
                                <option value="{{ $comp->id }}">
                                    اليوم {{ $comp->day_number }} - {{ $comp->title ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">سيتم إضافة الأسئلة إلى هذا اليوم مع الحفاظ على ترتيب الأسئلة الحالي.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="file" class="form-label">ملف Excel <span class="text-danger">*</span></label>
                        <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i>
                            الملف يجب أن يحتوي على الأعمدة: text, choice_a, choice_b, choice_c, choice_d, correct_choice, time_sec (اختياري)
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-lightbulb me-2"></i>
                    سيتم إضافة الأسئلة إلى اليوم المحدد مع ترتيب تلقائي حسب ترتيبها في الملف (بعد الأسئلة الموجودة حالياً).
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-upload me-2"></i>استيراد وربط باليوم
                </button>
            </form>
        </div>
    </div>
</div>
@endsection