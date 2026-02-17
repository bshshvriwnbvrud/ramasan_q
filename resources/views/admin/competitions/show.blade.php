@extends('layouts.app')

@section('title', 'تفاصيل اليوم ' . $competition->day_number)

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-calendar2-day me-2"></i>اليوم {{ $competition->day_number }}: {{ $competition->title ?? '' }}</h2>
        <div>
            <a href="{{ route('admin.competitions') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-right"></i> العودة
            </a>
            <form method="POST" action="{{ route('admin.competitions.toggle', $competition) }}" class="d-inline">
                @csrf
                <button class="btn btn-outline-{{ $competition->is_published ? 'secondary' : 'success' }}">
                    <i class="bi bi-{{ $competition->is_published ? 'eye-slash' : 'eye' }}"></i>
                    {{ $competition->is_published ? 'إلغاء النشر' : 'نشر' }}
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- معلومات اليوم -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>معلومات اليوم</h5>
                </div>
                <div class="card-body">
                    <p><strong>رقم اليوم:</strong> {{ $competition->day_number }}</p>
                    <p><strong>العنوان:</strong> {{ $competition->title ?? '—' }}</p>
                    <p><strong>البداية:</strong> {{ $competition->starts_at->format('Y-m-d h:i A') }}</p>
                    <p><strong>النهاية:</strong> {{ $competition->ends_at->format('Y-m-d h:i A') }}</p>
                    <p><strong>الحالة:</strong>
                        @if($competition->is_published)
                            <span class="badge bg-success">منشور</span>
                        @else
                            <span class="badge bg-secondary">غير منشور</span>
                        @endif
                    </p>
                    <p><strong>عدد المشاركين:</strong> {{ $competition->attempts()->count() }}</p>
                </div>
            </div>
        </div>

        <!-- الأسئلة المرتبطة -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-patch-question me-2"></i>أسئلة اليوم</h5>
                    <a href="{{ route('admin.questions.create', ['competition_id' => $competition->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>إضافة سؤال
                    </a>
                </div>
                <div class="card-body">
                    @if($competition->questions->isEmpty())
                        <p class="text-muted text-center py-3">لا توجد أسئلة مرتبطة بهذا اليوم.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>السؤال</th>
                                        <th>الخيارات</th>
                                        <th>الإجابة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($competition->questions as $question)
                                        <tr>
                                            <td>{{ $question->pivot->sort_order }}</td>
                                            <td>{{ Str::limit($question->text, 50) }}</td>
                                            <td>
                                                <small>A: {{ Str::limit($question->choice_a, 15) }}<br>
                                                B: {{ Str::limit($question->choice_b, 15) }}<br>
                                                C: {{ Str::limit($question->choice_c, 15) }}<br>
                                                D: {{ Str::limit($question->choice_d, 15) }}</small>
                                            </td>
                                            <td>{{ $question->correct_choice }}</td>
                                            <td>
                                                <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- الفائزون -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>الفائزون</h5>
                    <a href="{{ route('admin.competitions.winners.index', $competition) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-gear me-1"></i>إدارة الفائزين
                    </a>
                </div>
                <div class="card-body">
                    @if($competition->winners->isEmpty())
                        <p class="text-muted text-center py-3">لم يتم تحديد فائزين بعد.</p>
                    @else
                        <div class="row">
                            @foreach($competition->winners->sortBy('rank') as $winner)
                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-3 text-center">
                                        @if($winner->rank == 1) 🥇
                                        @elseif($winner->rank == 2) 🥈
                                        @elseif($winner->rank == 3) 🥉
                                        @endif
                                        <h5 class="mt-2">{{ $winner->user->name }}</h5>
                                        <span class="badge bg-primary">المركز {{ $winner->rank }}</span>
                                        @if($winner->note)
                                            <p class="small text-muted mt-2">{{ $winner->note }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection