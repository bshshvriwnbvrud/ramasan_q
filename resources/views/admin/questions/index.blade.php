@extends('layouts.app')

@section('title', 'الأسئلة')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-patch-question-fill me-2"></i>الأسئلة</h2>
        <div>
            <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>إضافة سؤال
            </a>
            <a href="{{ route('admin.questions.import_to_competition.form') }}" class="btn btn-warning">
                <i class="bi bi-upload me-2"></i>استيراد ليوم محدد
            </a>
            <a href="{{ route('admin.questions.import.form') }}" class="btn btn-success">
                <i class="bi bi-upload me-2"></i>استيراد عام
            </a>
            <a href="{{ route('admin.questions.export') }}" class="btn btn-info">
                <i class="bi bi-download me-2"></i>تصدير
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- فلتر -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="competition_id" class="form-label fw-medium">تصفية حسب اليوم:</label>
                    <select name="competition_id" id="competition_id" class="form-select" onchange="this.form.submit()">
                        <option value="">جميع الأسئلة</option>
                        @foreach($competitions as $comp)
                            <option value="{{ $comp->id }}" {{ $competitionId == $comp->id ? 'selected' : '' }}>
                                اليوم {{ $comp->day_number }} - {{ $comp->title ?? 'بدون عنوان' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>السؤال</th>
                            <th>الخيارات</th>
                            <th>الإجابة الصحيحة</th>
                            <th>الوقت (ث)</th>
                            <th>شخصية</th>
                            <th>الأيام المرتبط بها</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                            <tr>
                                <td>{{ $question->id }}</td>
                                <td>{{ Str::limit($question->text, 50) }}</td>
                                <td>
                                    <small>
                                        A: {{ Str::limit($question->choice_a, 20) }}<br>
                                        B: {{ Str::limit($question->choice_b, 20) }}<br>
                                        C: {{ Str::limit($question->choice_c, 20) }}<br>
                                        D: {{ Str::limit($question->choice_d, 20) }}
                                    </small>
                                </td>
                                <td><span class="badge bg-success">{{ $question->correct_choice }}</span></td>
                                <td>{{ $question->time_sec ?? '—' }}</td>
                                <td>
                                    @if($question->is_personality)
                                        <span class="badge bg-info">نعم</span>
                                    @else
                                        <span class="badge bg-secondary">لا</span>
                                    @endif
                                </td>
                                <td>
                                    @foreach($question->competitions as $comp)
                                        <span class="badge bg-info me-1">{{ $comp->day_number }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" class="d-inline"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا السؤال؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit" title="حذف">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">لا توجد أسئلة.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $questions->links() }}
        </div>
    </div>
</div>
@endsection