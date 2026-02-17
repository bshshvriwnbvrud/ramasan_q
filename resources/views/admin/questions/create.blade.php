@extends('layouts.app')

@section('title', 'إضافة سؤال جديد')

@section('content')
<div class="container py-4" style="max-width: 800px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h4 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>إضافة سؤال جديد</h4>
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

            <form method="POST" action="{{ route('admin.questions.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-medium">نص السؤال</label>
                    <textarea name="text" class="form-control @error('text') is-invalid @enderror" rows="3" required>{{ old('text') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">الخيار A</label>
                        <input type="text" name="choice_a" class="form-control" value="{{ old('choice_a') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">الخيار B</label>
                        <input type="text" name="choice_b" class="form-control" value="{{ old('choice_b') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">الخيار C</label>
                        <input type="text" name="choice_c" class="form-control" value="{{ old('choice_c') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">الخيار D</label>
                        <input type="text" name="choice_d" class="form-control" value="{{ old('choice_d') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-medium">الإجابة الصحيحة</label>
                        <select name="correct_choice" class="form-select" required>
                            <option value="">اختر</option>
                            <option value="A" {{ old('correct_choice') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('correct_choice') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ old('correct_choice') == 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ old('correct_choice') == 'D' ? 'selected' : '' }}>D</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-medium">الوقت (ثانية) - اختياري</label>
                        <input type="number" name="time_sec" class="form-control" value="{{ old('time_sec', 30) }}" min="5">
                    </div>
                </div>

                <!-- حقل شخصية اليوم -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="is_personality" id="is_personality" value="1" {{ old('is_personality') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_personality">سؤال شخصية اليوم (يظهر كسؤال مميز مع وصف وصورة)</label>
                </div>

                <div id="personalityFields" style="display: {{ old('is_personality') ? 'block' : 'none' }};">
                    <div class="mb-3">
                        <label class="form-label fw-medium">اسم الشخصية</label>
                        <input type="text" name="personality_name" class="form-control" value="{{ old('personality_name') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">وصف الشخصية</label>
                        <textarea name="personality_description" class="form-control" rows="3">{{ old('personality_description') }}</textarea>
                        <div class="form-text">هذا الوصف سيظهر مع السؤال بعد الإجابة عليه.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">صورة الشخصية</label>
                        <input type="file" name="personality_image" class="form-control" accept="image/*">
                        <div class="form-text">صورة تمثل الشخصية (ستظهر بعد الإجابة).</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">ربط بالأيام (اختياري)</label>
                    <select name="competitions[]" class="form-select" multiple size="5">
                        @foreach($competitions as $comp)
                            <option value="{{ $comp->id }}" {{ (is_array(old('competitions')) && in_array($comp->id, old('competitions'))) ? 'selected' : '' }}>
                                اليوم {{ $comp->day_number }} - {{ $comp->title ?? 'بدون عنوان' }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">يمكنك اختيار أكثر من يوم (اضغط Ctrl للاختيار المتعدد). إذا كان السؤال شخصية، سيظهر في الأيام المحددة كسؤال شخصية.</div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('is_personality').addEventListener('change', function() {
        document.getElementById('personalityFields').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endsection