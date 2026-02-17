@extends('layouts.app')

@section('title', 'إنشاء يوم جديد')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h4 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>إنشاء يوم جديد</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.competitions.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">رقم اليوم (1-30) <span class="text-danger">*</span></label>
                        <input type="number" name="day_number" class="form-control" value="{{ old('day_number') }}" required min="1" max="30">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">عنوان اليوم</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">وقت البداية <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="starts_at" class="form-control" value="{{ old('starts_at') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">وقت النهاية <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="ends_at" class="form-control" value="{{ old('ends_at') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">نظام المؤقت</label>
                        <select name="timer_mode" class="form-select">
                            <option value="uniform" {{ old('timer_mode') == 'uniform' ? 'selected' : '' }}>موحد لجميع الأسئلة</option>
                            <option value="per_question" {{ old('timer_mode') == 'per_question' ? 'selected' : '' }}>محدد لكل سؤال</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">الوقت الموحد (ثانية)</label>
                        <input type="number" name="uniform_time_sec" class="form-control" value="{{ old('uniform_time_sec', 30) }}" min="5">
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-star-fill text-warning me-2"></i>شخصية اليوم (اختياري)</h5>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="personality_enabled" id="personality_enabled" value="1" {{ old('personality_enabled') ? 'checked' : '' }}>
                        <label class="form-check-label" for="personality_enabled">تفعيل شخصية اليوم (ستظهر بعد آخر سؤال)</label>
                    </div>
                </div>

                <div id="personalityFields" style="{{ old('personality_enabled') ? '' : 'display:none;' }}">
                    <div class="mb-3">
                        <label class="form-label fw-medium">اسم الشخصية</label>
                        <input type="text" name="personality_name" class="form-control" value="{{ old('personality_name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">وصف الشخصية</label>
                        <textarea name="personality_description" class="form-control" rows="4">{{ old('personality_description') }}</textarea>
                        <div class="form-text">سيظهر هذا الوصف بعد الإجابة على آخر سؤال.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">صورة الشخصية</label>
                        <input type="file" name="personality_image" class="form-control" accept="image/*">
                        <div class="form-text">الصورة ستكون مضللة أثناء الاختبار، وتظهر بوضوح بعد الانتهاء.</div>
                    </div>
                </div>

                <hr class="my-4">
                <button type="submit" class="btn btn-primary w-100">حفظ</button>
                <a href="{{ route('admin.competitions') }}" class="btn btn-outline-secondary w-100 mt-2">إلغاء</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('personality_enabled').addEventListener('change', function() {
        document.getElementById('personalityFields').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endpush
@endsection