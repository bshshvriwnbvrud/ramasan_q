@extends('layouts.app')

@section('title', 'الأيام')

@section('content')
<div class="container py-3 py-md-4">
    <!-- رأس الصفحة المحسّن -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
        <div>
            <h1 class="fw-bold mb-1" style="font-family: 'Amiri', serif; font-size: clamp(1.8rem, 5vw, 2.5rem); background: linear-gradient(to bottom, #fff 20%, var(--primary-gold) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-star-fill text-warning me-2"></i>مرحباً، {{ auth()->user()->name }}
            </h1>
            <p class="text-white-50 small">اختر يوم المسابقة وابدأ التحدي</p>
        </div>

        @if(auth()->user()->status !== 'approved')
            <span class="badge bg-warning text-dark p-3 px-4 fs-6 rounded-pill shadow-sm" style="background: rgba(255, 193, 7, 0.2) !important; border: 1px solid #ffc107; color: #ffc107 !important;">
                <i class="bi bi-hourglass-split me-1"></i> في انتظار الموافقة
            </span>
        @endif
    </div>

    <!-- رسائل التنبيه بشكل محسّن (toast-like) -->
    @if(session('err'))
        <div class="alert alert-danger alert-dismissible fade show glass-card d-flex align-items-center" role="alert" data-aos="fade-up">
            <i class="bi bi-exclamation-triangle me-2 fs-4"></i>
            <div>{{ session('err') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show glass-card d-flex align-items-center" role="alert" data-aos="fade-up">
            <i class="bi bi-check-circle me-2 fs-4"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- شبكة البطاقات -->
    <div class="row g-4">
        @forelse($days as $d)
            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100 border-0 day-card {{ $d['status'] === 'open' ? 'ramadan-open' : '' }}">
                    <!-- شريط علوي يمثل الحالة (تحسين التمييز البصري) -->
                    <div class="status-strip status-{{ $d['status'] }}"></div>

                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-calendar-day me-2 text-warning"></i>اليوم {{ $d['day_number'] }}
                            </h5>
                            @if($d['status'] === 'open')
                                <span class="badge px-3 py-2 rounded-pill status-badge status-open">مفتوح الآن</span>
                            @elseif($d['status'] === 'closed')
                                <span class="badge px-3 py-2 rounded-pill status-badge status-closed">مغلق</span>
                            @else
                                <span class="badge px-3 py-2 rounded-pill status-badge status-upcoming">قادم</span>
                            @endif
                        </div>

                        @if($d['title'])
                            <p class="text-white-50 mb-3">{{ $d['title'] }}</p>
                        @endif

                        <div class="small text-white-50 mb-3">
                            <div class="d-flex align-items-center mb-1">
                                <i class="bi bi-clock me-2"></i>
                                <span class="text-truncate">يبدأ: {{ \Carbon\Carbon::parse($d['starts_at'])->format('Y-m-d h:i A') }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock-history me-2"></i>
                                <span class="text-truncate">ينتهي: {{ \Carbon\Carbon::parse($d['ends_at'])->format('Y-m-d h:i A') }}</span>
                            </div>
                        </div>

                        <!-- عداد تنازلي اختياري (يمكن تفعيله لاحقاً) -->
                        @if($d['status'] === 'upcoming')
                            <div class="countdown-timer mb-3 small text-center text-warning" data-end="{{ $d['starts_at'] }}">
                                <i class="bi bi-hourglass-top me-1"></i>
                                <span>يبدأ بعد <span class="fw-bold countdown-digits">--</span></span>
                            </div>
                        @endif

                        <div class="mt-4">
                            @if($d['status'] === 'open')
                                @php
                                    $attempt = auth()->user()->attempts()->where('competition_id', $d['id'])->first();
                                @endphp

                                @if($attempt && $attempt->status === 'in_progress')
                                    <a href="{{ route('attempt.continue', $attempt) }}" class="btn btn-warning w-100 rounded-pill btn-continue">
                                        <i class="bi bi-arrow-repeat me-2"></i>استكمال الاختبار
                                    </a>
                                @elseif($attempt && $attempt->status !== 'in_progress')
                                    <a href="{{ route('attempt.result', $attempt) }}" class="btn btn-outline-light w-100 rounded-pill">
                                        <i class="bi bi-eye me-2"></i>عرض نتيجتك
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('attempt.start', $d['id']) }}" class="start-form">
                                        @csrf
                                        <button type="submit" class="btn btn-premium btn-primary-gold w-100 rounded-pill btn-start" data-loading-text="جاري التحميل...">
                                            <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                                            <span class="btn-text"><i class="bi bi-play-fill me-2"></i>ابدأ الاختبار</span>
                                        </button>
                                    </form>
                                @endif

                            @elseif($d['status'] === 'closed')
                                @if($d['results_published'])
                                    <a href="{{ route('student.leaderboard', ['competition_id' => $d['id']]) }}"
                                       class="btn btn-outline-gold w-100 rounded-pill">
                                        <i class="bi bi-trophy me-2"></i>عرض الفائزين
                                    </a>
                                @else
                                    <button class="btn btn-outline-light w-100 rounded-pill" disabled
                                            data-bs-toggle="tooltip" title="سيتم نشر النتائج قريباً">
                                        <i class="bi bi-hourglass-split me-2"></i>النتائج قريباً
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-outline-light w-100 rounded-pill" disabled
                                        data-bs-toggle="tooltip" title="{{ $d['starts_at'] ? 'يبدأ في '.\Carbon\Carbon::parse($d['starts_at'])->format('Y-m-d') : 'غير متاح الآن' }}">
                                    <i class="bi bi-lock me-2"></i>غير متاح الآن
                                </button>
                            @endif
                        </div>
                    </div>
                    <!-- أيقونة خلفية محسّنة (أيقونة متجهة من Bootstrap) -->
                    <div class="background-icon">
                        <i class="bi bi-moon-stars"></i>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5 glass-card">
                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                    <h5>لا توجد مسابقات منشورة حالياً</h5>
                    <p class="mb-0">ترقبوا الإعلان عن المسابقات القادمة</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --primary-gold: #f7b731;
        --secondary-gold: #d49a1e;
        --dark-blue: #1a1e2b;
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    /* تحسين التباين للنص */
    .text-white-50 {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* تخصيص بطاقة اليوم */
    .day-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border) !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        /* fallback للمتصفحات القديمة */
        background: rgba(0, 0, 0, 0.3);
    }
    @supports (backdrop-filter: blur(12px)) {
        .day-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
        }
    }

    .day-card:hover {
        transform: translateY(-10px);
        border-color: var(--primary-gold) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 30px rgba(247, 183, 49, 0.2);
    }

    .day-card .card-body {
        position: relative;
        z-index: 2;
        color: white;
    }

    /* شريط الحالة العلوي */
    .status-strip {
        height: 4px;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 3;
    }
    .status-open {
        background: linear-gradient(90deg, #28a745, #5cb85c);
    }
    .status-closed {
        background: linear-gradient(90deg, #6c757d, #495057);
    }
    .status-upcoming {
        background: linear-gradient(90deg, #ffc107, #ffdb6e);
    }

    /* شارات الحالة - شفافة مع حدود ملونة */
    .status-badge {
        backdrop-filter: blur(4px);
        font-weight: 600;
    }
    .status-badge.status-open {
        background: rgba(40, 167, 69, 0.2) !important;
        border: 1px solid #28a745;
        color: #28a745 !important;
    }
    .status-badge.status-closed {
        background: rgba(108, 117, 125, 0.2) !important;
        border: 1px solid #6c757d;
        color: #adb5bd !important;
    }
    .status-badge.status-upcoming {
        background: rgba(255, 193, 7, 0.2) !important;
        border: 1px solid #ffc107;
        color: #ffc107 !important;
    }

    /* أيقونة الخلفية */
    .background-icon {
        position: absolute;
        bottom: 10px;
        left: 10px;
        font-size: 3rem;
        opacity: 0.2;
        transform: rotate(10deg);
        transition: opacity 0.3s;
        z-index: 1;
        color: var(--primary-gold);
    }
    .day-card:hover .background-icon {
        opacity: 0.4;
    }

    /* زر ذهبي مميز (لبدء الاختبار) */
    .btn-primary-gold {
        background: linear-gradient(135deg, var(--primary-gold), #d49a1e);
        color: var(--dark-blue) !important;
        border: none;
        box-shadow: 0 10px 20px rgba(212, 154, 30, 0.3);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        font-weight: 700;
    }
    .btn-primary-gold:hover:not(:disabled) {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(212, 154, 30, 0.5);
        background: linear-gradient(135deg, var(--secondary-gold), var(--primary-gold));
    }
    .btn-primary-gold.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    /* زر ذهبي بإطار شفاف (لعرض الفائزين) */
    .btn-outline-gold {
        border: 2px solid var(--primary-gold);
        color: white;
        background: transparent;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        font-weight: 700;
    }
    .btn-outline-gold:hover {
        background: var(--primary-gold);
        color: var(--dark-blue);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(247, 183, 49, 0.4);
        border-color: var(--primary-gold);
    }

    /* زر الاستكمال (warning) */
    .btn-continue {
        background: rgba(255, 193, 7, 0.2);
        border: 1px solid #ffc107;
        color: #ffc107 !important;
        backdrop-filter: blur(4px);
    }
    .btn-continue:hover {
        background: #ffc107;
        color: #000 !important;
    }

    /* تنسيق العداد التنازلي */
    .countdown-timer {
        background: rgba(0, 0, 0, 0.2);
        padding: 5px;
        border-radius: 20px;
        border: 1px dashed var(--primary-gold);
    }

    /* تحسينات الوضع الليلي */
    [data-bs-theme="dark"] .day-card {
        background: rgba(0, 0, 0, 0.5) !important;
    }
    [data-bs-theme="dark"] .btn-outline-gold {
        border-color: var(--secondary-gold);
        color: var(--secondary-gold);
    }
    [data-bs-theme="dark"] .btn-outline-gold:hover {
        background: var(--secondary-gold);
        color: #000;
    }

    /* تحسين الاستجابة للهواتف */
    @media (max-width: 576px) {
        .day-card .card-body {
            padding: 1.5rem !important;
        }
        .background-icon {
            font-size: 2.5rem;
        }
        .btn {
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // تفعيل tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // إضافة حالة التحميل لأزرار بدء الاختبار
        const startForms = document.querySelectorAll('.start-form');
        startForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const btn = this.querySelector('.btn-start');
                if (btn) {
                    btn.classList.add('loading');
                    btn.disabled = true;
                    const spinner = btn.querySelector('.spinner-border');
                    const btnText = btn.querySelector('.btn-text');
                    if (spinner) spinner.classList.remove('d-none');
                    if (btnText) btnText.innerHTML = 'جاري التحميل...';
                }
            });
        });

        // عداد تنازلي بسيط (اختياري)
        const countdownElements = document.querySelectorAll('.countdown-timer');
        countdownElements.forEach(el => {
            const endDateStr = el.dataset.end;
            if (!endDateStr) return;
            const endDate = new Date(endDateStr).getTime();
            const digitsSpan = el.querySelector('.countdown-digits');
            if (!digitsSpan) return;

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endDate - now;

                if (distance < 0) {
                    digitsSpan.innerText = 'الآن';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                let text = '';
                if (days > 0) text += `${days} يوم `;
                if (hours > 0) text += `${hours} ساعة `;
                if (days === 0 && hours === 0) text += `${minutes} دقيقة`;
                digitsSpan.innerText = text || 'أقل من دقيقة';
            }

            updateCountdown();
            setInterval(updateCountdown, 60000); // تحديث كل دقيقة
        });
    });
</script>
@endpush