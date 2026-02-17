@extends('layouts.app')

@section('title', 'نتيجة الاختبار')

@push('styles')
<style>
    /* بطاقة النتيجة الزجاجية */
    .result-card {
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 40px;
        padding: 3rem;
        color: white;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), inset 0 0 20px rgba(255, 255, 255, 0.05);
    }

    /* شارة النسبة/الدرجة */
    .score-badge {
        font-size: 2.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, var(--primary-gold), #d49a1e);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }

    /* صورة الشخصية */
    .personality-result-image {
        max-width: 200px;
        border-radius: 50%;
        border: 4px solid var(--primary-gold);
        padding: 5px;
        background: linear-gradient(145deg, var(--dark-blue), var(--mid-blue));
        box-shadow: 0 0 30px rgba(247, 183, 49, 0.4);
        transition: all 0.3s;
    }

    .personality-result-image:hover {
        transform: scale(1.05);
        box-shadow: 0 0 50px rgba(247, 183, 49, 0.6);
    }

    /* بطاقات الإحصائيات */
    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        padding: 1.5rem 0.5rem;
        color: white;
        transition: all 0.3s;
    }

    .stat-card:hover {
        border-color: var(--primary-gold);
        transform: translateY(-5px);
    }

    .stat-card .small {
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
    }

    .stat-card .fs-1 {
        font-weight: 700;
        background: linear-gradient(135deg, #fff, var(--primary-gold));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* الأزرار */
    .btn-premium {
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    /* النصوص */
    h2, h3 {
        font-family: 'Amiri', serif;
        color: white;
    }

    .lead {
        color: rgba(255, 255, 255, 0.8);
    }

    /* الوضع الليلي */
    [data-bs-theme="dark"] .result-card {
        background: rgba(0, 0, 0, 0.3);
    }
    [data-bs-theme="dark"] .stat-card {
        background: rgba(0, 0, 0, 0.2);
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="result-card p-5 text-center" data-aos="zoom-in">
                <i class="bi bi-trophy-fill display-1 mb-4" style="color: var(--primary-gold); filter: drop-shadow(0 0 15px rgba(247,183,49,0.5));"></i>
                <h2 class="mb-3">تهانينا! 🎉</h2>
                <p class="lead mb-4">لقد أكملت اختبار اليوم {{ $attempt->competition->day_number }}</p>

                @if(isset($personality) && $personality)
                    <div class="mb-5" data-aos="fade-up">
                        <img src="{{ $personality['image'] }}" alt="{{ $personality['name'] }}"
                             class="personality-result-image">
                        <h3 class="mt-3">{{ $personality['name'] }}</h3>
                        <p class="text-white-50">{{ $personality['description'] }}</p>
                    </div>
                @endif

                <div class="row g-4 mb-5">
                    <div class="col-4">
                        <div class="stat-card">
                            <div class="small text-white-50">الصحيح</div>
                            <div class="fs-1 fw-bold">{{ $attempt->correct_count }}</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-card">
                            <div class="small text-white-50">الخطأ</div>
                            <div class="fs-1 fw-bold">{{ $attempt->wrong_count }}</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-card">
                            <div class="small text-white-50">بدون إجابة</div>
                            <div class="fs-1 fw-bold">{{ $attempt->blank_count }}</div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-3">
                    <a href="{{ route('home') }}" class="btn-premium btn-primary-gold">
                        <i class="bi bi-house-door me-2"></i>العودة للرئيسية
                    </a>
                    <a href="{{ route('student.leaderboard', ['competition_id' => $attempt->competition_id]) }}"
                       class="btn-premium btn-outline-gold">
                        <i class="bi bi-bar-chart me-2"></i>عرض المتصدرين
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection