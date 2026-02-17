@extends('layouts.app')

@section('title', 'الفائزون')

@push('styles')
<style>
    /* بطاقة الفائز الزجاجية */
    .winner-card {
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 40px;
        padding: 2rem;
        color: white;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
    }

    .winner-card:hover {
        transform: translateY(-10px);
        border-color: var(--primary-gold);
        box-shadow: 0 20px 50px rgba(247, 183, 49, 0.3);
    }

    /* أيقونة فانوس صغيرة في الخلفية */
    .winner-card::after {
        content: "🏆";
        position: absolute;
        bottom: 10px;
        left: 10px;
        font-size: 3rem;
        opacity: 0.1;
        transform: rotate(-10deg);
        transition: opacity 0.3s;
        z-index: 1;
    }

    .winner-card:hover::after {
        opacity: 0.2;
    }

    /* ألوان الجوائز مع الحفاظ على بريقها */
    .trophy-gold {
        color: #ffd700;
        filter: drop-shadow(0 0 15px rgba(255, 215, 0, 0.5));
        transition: all 0.3s;
    }
    .trophy-silver {
        color: #c0c0c0;
        filter: drop-shadow(0 0 15px rgba(192, 192, 192, 0.5));
        transition: all 0.3s;
    }
    .trophy-bronze {
        color: #cd7f32;
        filter: drop-shadow(0 0 15px rgba(205, 127, 50, 0.5));
        transition: all 0.3s;
    }

    .winner-card:hover .trophy-gold,
    .winner-card:hover .trophy-silver,
    .winner-card:hover .trophy-bronze {
        transform: scale(1.05);
    }

    /* العناوين داخل البطاقة */
    .winner-card h3 {
        font-family: 'Amiri', serif;
        color: var(--primary-gold);
        margin-top: 1rem;
    }

    .winner-card h4 {
        font-weight: 700;
        color: white;
    }

    .winner-card p {
        color: rgba(255, 255, 255, 0.7);
    }

    /* حالة عدم وجود فائزين */
    .alert-glass {
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 40px;
        color: white;
        padding: 4rem 2rem;
    }

    /* زر العودة */
    .btn-premium {
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        position: relative;
        overflow: hidden;
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

    /* تحسين العنوان الرئيسي */
    h2 {
        font-family: 'Amiri', serif;
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    h2 i {
        filter: drop-shadow(0 0 10px var(--primary-gold));
    }

    /* الوضع الليلي */
    [data-bs-theme="dark"] .winner-card {
        background: rgba(0, 0, 0, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-5 fw-bold" data-aos="fade-down">
        <i class="bi bi-trophy-fill text-warning me-2"></i>
        فائزو اليوم {{ $competition->day_number ?? '' }}
    </h2>

    @if($winners->isNotEmpty())
        <div class="row justify-content-center">
            @foreach($winners as $winner)
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="winner-card text-center">
                        @if($winner->rank == 1)
                            <i class="bi bi-trophy-fill display-1 trophy-gold"></i>
                            <h3 class="fw-bold">🥇 المركز الأول</h3>
                        @elseif($winner->rank == 2)
                            <i class="bi bi-trophy-fill display-1 trophy-silver"></i>
                            <h3 class="fw-bold">🥈 المركز الثاني</h3>
                        @elseif($winner->rank == 3)
                            <i class="bi bi-trophy-fill display-1 trophy-bronze"></i>
                            <h3 class="fw-bold">🥉 المركز الثالث</h3>
                        @else
                            <i class="bi bi-award-fill display-1" style="color: var(--primary-gold); filter: drop-shadow(0 0 15px rgba(247,183,49,0.5));"></i>
                            <h3 class="fw-bold">المركز {{ $winner->rank }}</h3>
                        @endif
                        <h4 class="fw-bold mt-3">{{ $winner->user->name }}</h4>
                        @if($winner->note)
                            <p class="mt-2">{{ $winner->note }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('home') }}" class="btn-premium btn-primary-gold px-5">
                <i class="bi bi-house-door me-2"></i>العودة للرئيسية
            </a>
        </div>
    @else
        <div class="alert-glass text-center py-5" data-aos="zoom-in">
            <i class="bi bi-emoji-neutral fs-1 d-block mb-3" style="color: var(--primary-gold);"></i>
            <h4>لم يتم الإعلان عن الفائزين بعد</h4>
            <p class="text-white-50">تابعونا لمعرفة النتائج قريباً</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1"></script>
<script>
    @if($winners->isNotEmpty())
        // إطلاق كونفيتي ذهبي مناسب للثيمة
        confetti({
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 },
            colors: ['#f7b731', '#ffd966', '#ffffff', '#d49a1e']
        });
        setTimeout(() => {
            confetti({
                particleCount: 100,
                spread: 100,
                origin: { y: 0.5, x: 0.3 },
                colors: ['#f7b731', '#ffd966']
            });
            confetti({
                particleCount: 100,
                spread: 100,
                origin: { y: 0.5, x: 0.7 },
                colors: ['#f7b731', '#ffd966']
            });
        }, 300);
    @endif
</script>
@endpush