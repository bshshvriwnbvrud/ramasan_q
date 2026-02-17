@extends('layouts.app')

@section('title', 'اختيار الفائزين - اليوم ' . $competition->day_number)

@push('styles')
<style>
    .winner-row.selected {
        background-color: rgba(40, 167, 69, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-trophy-fill me-2"></i>اختيار الفائزين لليوم {{ $competition->day_number }}</h2>
        <a href="{{ route('admin.competitions.winners.index', $competition) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i>عودة
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($attempts->isEmpty())
        <div class="alert alert-warning">لا توجد محاولات مكتملة لهذا اليوم.</div>
    @else
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.competitions.winners.store', $competition) }}" id="winnersForm">
                    @csrf

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>الترتيب</th>
                                    <th>الاسم</th>
                                    <th>الدرجة</th>
                                    <th>وقت الإنهاء</th>
                                    <th>اختيار</th>
                                    <th>المركز</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attempts as $index => $attempt)
                                <tr class="winner-row" id="row-{{ $attempt->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $attempt->user->name }}</td>
                                    <td>{{ $attempt->score }}</td>
                                    <td>{{ $attempt->submitted_at->format('H:i:s') }}</td>
                                    <td>
                                        <input type="checkbox" class="form-check-input select-winner" 
                                               data-user-id="{{ $attempt->user_id }}" 
                                               data-attempt-id="{{ $attempt->id }}">
                                    </td>
                                    <td>
                                        <select name="winners[{{ $index }}][rank]" class="form-select form-select-sm rank-select" disabled>
                                            <option value="">--</option>
                                            @for($i=1; $i<=10; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <input type="hidden" name="winners[{{ $index }}][user_id]" class="user-id-input" value="{{ $attempt->user_id }}" disabled>
                                    </td>
                                    <td>
                                        <input type="text" name="winners[{{ $index }}][note]" class="form-control form-control-sm note-input" placeholder="اختياري" disabled>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success" id="saveBtn">
                            <i class="bi bi-check-circle me-2"></i>حفظ الفائزين
                        </button>
                        <a href="{{ route('admin.competitions.winners.index', $competition) }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.select-winner');
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const row = this.closest('tr');
                const rankSelect = row.querySelector('.rank-select');
                const noteInput = row.querySelector('.note-input');
                const userIdInput = row.querySelector('.user-id-input');
                
                if (this.checked) {
                    row.classList.add('selected');
                    rankSelect.disabled = false;
                    noteInput.disabled = false;
                    userIdInput.disabled = false;
                } else {
                    row.classList.remove('selected');
                    rankSelect.disabled = true;
                    noteInput.disabled = true;
                    userIdInput.disabled = true;
                }
            });
        });

        // التحقق قبل الإرسال من تحديد المراكز لكل من تم اختياره
        document.getElementById('winnersForm').addEventListener('submit', function(e) {
            let valid = true;
            document.querySelectorAll('.select-winner:checked').forEach(checkbox => {
                const row = checkbox.closest('tr');
                const rankSelect = row.querySelector('.rank-select');
                if (!rankSelect.value) {
                    valid = false;
                    alert('يرجى تحديد المركز لكل من تم اختياره');
                    e.preventDefault();
                }
            });
            
            if (!valid) e.preventDefault();
        });
    });
</script>
@endpush