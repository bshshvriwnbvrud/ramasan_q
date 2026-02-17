@extends('layouts.app')

@section('title', 'الاختبار - اليوم ' . $competition->day_number)

@push('styles')
<style>
    :root {
        --primary-gold: #f7b731;
        --secondary-gold: #d49a1e;
        --dark-blue: #1a1e2b;
        --mid-blue: #2a2f3f;
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
    }

    /* تحسينات عامة */
    .text-white-50 {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* شريط التقدم */
    .progress-wrapper {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 50px;
        padding: 5px;
        border: 1px solid var(--glass-border);
        backdrop-filter: blur(5px);
    }
    .progress {
        height: 20px;
        border-radius: 50px;
        background-color: rgba(255, 255, 255, 0.1);
    }
    .progress-bar {
        background: linear-gradient(90deg, var(--primary-gold), var(--secondary-gold));
        border-radius: 50px;
        position: relative;
        overflow: hidden;
    }
    .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 2s infinite;
    }
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* شارة السؤال */
    .badge-gold {
        background: rgba(247, 183, 49, 0.15);
        border: 2px solid var(--primary-gold);
        color: var(--primary-gold);
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.8rem;
        font-weight: 700;
        box-shadow: 0 0 20px rgba(247, 183, 49, 0.3);
        backdrop-filter: blur(5px);
    }

    /* عداد الوقت المتطور */
    .timer-container {
        background: linear-gradient(145deg, #2a2f3f, #1a1e2b);
        border-radius: 60px;
        padding: 0.7rem 2.5rem;
        color: white;
        font-size: 2.2rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5), inset 0 2px 5px rgba(255,255,255,0.1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .timer-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transform: translateX(-100%);
        transition: transform 0.5s;
        pointer-events: none;
    }
    .timer-container.critical::before {
        transform: translateX(100%);
        animation: sweep 2s infinite;
    }
    @keyframes sweep {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    .timer-container.pulse {
        animation: pulse 1s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.03); }
        100% { transform: scale(1); }
    }
    .timer-container i {
        font-size: 1.8rem;
        margin-left: 10px;
        transition: color 0.3s;
    }

    /* بطاقة السؤال */
    .question-card {
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 50px;
        padding: 2.5rem;
        color: white;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5), inset 0 0 30px rgba(255, 255, 255, 0.05);
        transition: all 0.4s;
    }

    /* أزرار الخيارات */
    .choice-btn {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border-radius: 40px;
        padding: 1.3rem 2rem;
        font-size: 1.15rem;
        border: 2px solid var(--glass-border);
        text-align: right;
        background: rgba(0, 0, 0, 0.2);
        color: white;
        backdrop-filter: blur(10px);
        width: 100%;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        position: relative;
        overflow: hidden;
    }
    .choice-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(247, 183, 49, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    .choice-btn:hover::before {
        width: 300px;
        height: 300px;
    }
    .choice-btn:hover {
        transform: translateY(-5px) scale(1.02);
        border-color: var(--primary-gold);
        box-shadow: 0 15px 30px rgba(247, 183, 49, 0.3);
    }
    .choice-btn.selected {
        border-color: var(--primary-gold);
        background: rgba(247, 183, 49, 0.15);
        color: white;
        font-weight: 700;
        box-shadow: 0 0 20px rgba(247, 183, 49, 0.5);
    }
    .choice-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    /* الأزرار الرئيسية */
    .btn-premium {
        padding: 1rem 2.5rem;
        border-radius: 60px;
        font-weight: 700;
        font-size: 1.2rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        position: relative;
        overflow: hidden;
    }
    .btn-primary-gold {
        background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
        color: var(--dark-blue) !important;
        box-shadow: 0 10px 25px rgba(212, 154, 30, 0.4);
    }
    .btn-primary-gold:hover:not(:disabled) {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(212, 154, 30, 0.6);
    }
    .btn-primary-gold:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* شخصية اليوم */
    .personality-section {
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 50px;
        padding: 2.5rem;
        margin-top: 2rem;
        color: white;
        transition: all 0.4s;
    }
    .personality-image {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid var(--primary-gold);
        padding: 5px;
        background: linear-gradient(145deg, var(--dark-blue), var(--mid-blue));
        box-shadow: 0 0 30px rgba(247, 183, 49, 0.4);
        transition: all 0.5s ease;
    }
    .personality-image.blurred {
        filter: blur(12px);
        opacity: 0.6;
    }
    .personality-name {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary-gold);
        font-family: 'Amiri', serif;
        margin-bottom: 1rem;
    }

    /* شارات الصحة */
    .correct-badge, .incorrect-badge {
        padding: 0.7rem 2rem;
        border-radius: 60px;
        font-weight: 700;
        display: inline-block;
        backdrop-filter: blur(5px);
    }
    .correct-badge {
        background: rgba(40, 167, 69, 0.15);
        border: 2px solid var(--success-color);
        color: var(--success-color);
    }
    .incorrect-badge {
        background: rgba(220, 53, 69, 0.15);
        border: 2px solid var(--danger-color);
        color: var(--danger-color);
    }

    /* مؤشر التحميل */
    .spinner-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s;
    }
    .spinner-overlay.show {
        opacity: 1;
        pointer-events: all;
    }

    /* تلميحات */
    [data-bs-toggle="tooltip"] {
        cursor: help;
    }

    /* الوضع الليلي */
    [data-bs-theme="dark"] .choice-btn {
        background: rgba(0, 0, 0, 0.4);
    }
    [data-bs-theme="dark"] .choice-btn.selected {
        background: rgba(255, 193, 7, 0.2);
        border-color: var(--secondary-gold);
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- شريط التقدم والعداد -->
    <div class="row align-items-center g-3 mb-4" data-aos="fade-down">
        <div class="col-md-7">
            <div class="d-flex align-items-center gap-3">
                <div class="badge-gold">{{ $current }}</div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between mb-1 small text-white-50">
                        <span>السؤال {{ $current }} من {{ $total }}</span>
                        <span>{{ round(($current / $total) * 100) }}%</span>
                    </div>
                    <div class="progress-wrapper">
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                 role="progressbar"
                                 style="width: {{ ($current / $total) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 text-md-end">
            <div id="timerContainer" class="timer-container">
                <i class="bi bi-hourglass-split"></i>
                <span id="timer">{{ $remaining }}</span> ث
            </div>
        </div>
    </div>

    <!-- رسالة انتهاء الوقت (تظهر عند الضرورة) -->
    @if(session('timeout'))
        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert" data-aos="fade-up">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('timeout') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- بطاقة السؤال -->
    <div class="question-card p-4 p-lg-5 mb-4" data-aos="zoom-in">
        <h3 class="mb-4" style="font-family: 'Amiri', serif; line-height: 1.6;">{{ $question->text }}</h3>

        <form id="answerForm" method="POST" action="{{ route('attempt.answer', $attempt) }}">
            @csrf
            <input type="hidden" name="selected_choice" id="selected_choice" value="">
            <input type="hidden" name="confirm" value="yes">

            <div class="row g-4">
                @php
                    $letters = ['A', 'B', 'C', 'D'];
                @endphp
                @foreach($letters as $letter)
                <div class="col-12 col-md-6">
                    <button type="button" class="choice-btn btn w-100 text-start"
                            onclick="selectChoice('{{ $letter }}')" id="choice{{ $letter }}"
                            {{ $showAnswer ? 'disabled' : '' }}
                            @if($showAnswer) data-bs-toggle="tooltip" title="لا يمكن التعديل بعد الإجابة" @endif>
                        <span class="fw-bold ms-3" style="color: var(--primary-gold); font-size: 1.3rem;">{{ $letter }}</span>
                        {{ $question->{'choice_'.strtolower($letter)} }}
                    </button>
                </div>
                @endforeach
            </div>

            <div id="confirmBtnContainer" class="text-center mt-5" style="display: none;">
                <button type="submit" class="btn-premium btn-primary-gold px-5" id="confirmBtn" disabled>
                    <i class="bi bi-check-circle me-2"></i>تأكيد الإجابة نهائياً
                </button>
                <p class="text-white-50 small mt-3">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    بعد التأكيد لا يمكنك الرجوع أو التعديل
                </p>
            </div>
        </form>

        <div class="text-white-50 small mt-4 d-flex align-items-center">
            <i class="bi bi-info-circle me-2 fs-5"></i>
            <span>لا يمكنك العودة للسؤال السابق. عند انتهاء الوقت سيتم الانتقال تلقائياً.</span>
        </div>
    </div>

    @if($isPersonality && $personality)
    <!-- قسم الشخصية (يظهر فقط إذا كان السؤال من نوع شخصية) -->
    <div class="personality-section" data-aos="fade-up">
        <div class="row align-items-center g-4">
            <div class="col-md-4 text-center">
                @if($showAnswer && $personality['image'])
                    <img src="{{ $personality['image'] }}"
                         class="personality-image"
                         alt="{{ $personality['name'] }}">
                @elseif($showAnswer)
                    <div class="personality-image d-flex align-items-center justify-content-center bg-dark">
                        <i class="bi bi-person-circle fs-1" style="color: var(--primary-gold);"></i>
                    </div>
                @else
                    <img src="https://via.placeholder.com/200?text=?"
                         class="personality-image blurred"
                         alt="شخصية اليوم">
                @endif
            </div>
            <div class="col-md-8">
                @if($showAnswer)
                    <div class="mb-3">
                        @if($isCorrect)
                            <span class="correct-badge"><i class="bi bi-check-circle-fill me-2"></i>إجابة صحيحة! ✅</span>
                        @else
                            <span class="incorrect-badge"><i class="bi bi-x-circle-fill me-2"></i>إجابة خاطئة ❌</span>
                        @endif
                    </div>
                    <h3 class="personality-name">{{ $personality['name'] }}</h3>
                    <p class="text-white-50">{{ $personality['description'] }}</p>
                    @if($current == $total)
                        <div class="mt-4">
                            <a href="{{ route('attempt.result', $attempt) }}" class="btn-premium btn-primary-gold">
                                <i class="bi bi-flag-fill me-2"></i>إنهاء الاختبار وعرض النتيجة
                            </a>
                        </div>
                    @endif
                @else
                    <div class="alert" style="background: rgba(247, 183, 49, 0.1); border: 2px dashed var(--primary-gold); border-radius: 30px; color: white;">
                        <i class="bi bi-question-circle-fill me-2" style="color: var(--primary-gold);"></i>
                        بعد الإجابة على هذا السؤال ستظهر لك شخصية اليوم!
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

<!-- شاشة تحميل عند الإرسال -->
<div id="loadingOverlay" class="spinner-overlay">
    <div class="text-center text-white">
        <div class="spinner-border text-warning mb-3" style="width: 4rem; height: 4rem;" role="status">
            <span class="visually-hidden">جاري التحميل...</span>
        </div>
        <h4>جاري تأكيد الإجابة...</h4>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // متغيرات عامة
    let remaining = {{ $remaining }};
    const initialRemaining = remaining; // لحساب النسبة
    const timerEl = document.getElementById('timer');
    const timerContainer = document.getElementById('timerContainer');
    const confirmBtn = document.getElementById('confirmBtn');
    const confirmContainer = document.getElementById('confirmBtnContainer');
    const choiceButtons = document.querySelectorAll('.choice-btn');
    const answerForm = document.getElementById('answerForm');
    const loadingOverlay = document.getElementById('loadingOverlay');
    let answerSubmitted = {{ $showAnswer ? 'true' : 'false' }};
    let timerInterval;

    // دالة تحديث لون العداد بناءً على الوقت المتبقي
    function updateTimerColor() {
        if (remaining <= 0) return;

        // حساب النسبة المتبقية (من 0 إلى 1)
        const ratio = remaining / initialRemaining;

        // تحديد اللون: من أزرق (hue 240) إلى أحمر (hue 0) مع تشبع وسطوع مناسبين
        // نستخدم hsl لتدرج سلس: الأزرق (hue=240) -> الأحمر (hue=0)
        const hue = Math.min(240, Math.max(0, 240 * ratio)); // 240->0 مع انخفاض النسبة

        // تشبع وسطوع ثابتين للحصول على ألوان زاهية
        const saturation = 80;
        const lightness = 55;

        // تطبيق اللون كخلفية مع الحفاظ على التدرج الأصلي
        timerContainer.style.background = `linear-gradient(145deg, hsl(${hue}, ${saturation}%, ${lightness}%), hsl(${hue-20}, ${saturation}%, ${lightness-10}%))`;

        // إضافة تأثيرات خاصة عند الاقتراب من النهاية
        if (remaining <= 5) {
            timerContainer.classList.add('critical', 'pulse');
            // تغيير الأيقونة إلى تنبيه
            const icon = timerContainer.querySelector('i');
            if (icon) icon.className = 'bi bi-exclamation-triangle-fill';
        } else if (remaining <= 10) {
            timerContainer.classList.add('pulse');
            timerContainer.classList.remove('critical');
            const icon = timerContainer.querySelector('i');
            if (icon) icon.className = 'bi bi-hourglass-split';
        } else {
            timerContainer.classList.remove('critical', 'pulse');
            const icon = timerContainer.querySelector('i');
            if (icon) icon.className = 'bi bi-hourglass-split';
        }
    }

    // بدء العداد
    function startTimer() {
        if (answerSubmitted) return;
        timerInterval = setInterval(() => {
            if (answerSubmitted) {
                clearInterval(timerInterval);
                return;
            }
            remaining--;
            timerEl.innerText = remaining;
            updateTimerColor();

            if (remaining <= 0) {
                clearInterval(timerInterval);
                // إظهار رسالة وإعادة تحميل الصفحة
                alert('انتهى الوقت! سيتم تحديث الصفحة.');
                location.reload();
            }
        }, 1000);
    }

    // اختيار إجابة
    window.selectChoice = function(choice) {
        if (answerSubmitted) return;

        // إزالة التحديد من جميع الأزرار
        choiceButtons.forEach(btn => btn.classList.remove('selected'));

        // تحديد الزر المختار
        const selectedBtn = document.getElementById('choice' + choice);
        selectedBtn.classList.add('selected');

        // تعيين القيمة في الحقل المخفي
        document.getElementById('selected_choice').value = choice;

        // تفعيل زر التأكيد وإظهاره
        confirmBtn.disabled = false;
        confirmContainer.style.display = 'block';

        // تمرير سلس إلى زر التأكيد
        confirmBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
    };

    // عند إرسال النموذج (تم إزالة confirm)
    answerForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // إيقاف العداد
        if (timerInterval) clearInterval(timerInterval);

        // إظهار شاشة التحميل
        loadingOverlay.classList.add('show');

        // تعطيل جميع الأزرار
        choiceButtons.forEach(btn => btn.disabled = true);
        confirmBtn.disabled = true;

        // إرسال النموذج
        this.submit();
    });

    // منع F5 والتحديث
    window.addEventListener('keydown', function(e) {
        if ((e.key === 'F5' || (e.ctrlKey && e.key === 'r')) && !answerSubmitted) {
            e.preventDefault();
            alert('لا يمكن تحديث الصفحة أثناء الاختبار. يرجى استخدام الأزرار المخصصة.');
        }
    });

    // منع النقر بزر الماوس الأيمن (اختياري)
    window.addEventListener('contextmenu', function(e) {
        if (!answerSubmitted) {
            e.preventDefault();
        }
    });

    // بدء العداد إذا لم يتم الإجابة بعد
    if (!answerSubmitted) {
        startTimer();
        updateTimerColor(); // تعيين اللون الأولي
    }

    // تفعيل tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(el => new bootstrap.Tooltip(el));
    });

    // إذا تم الإجابة مسبقاً، إخفاء العداد بشكل ودي
    if (answerSubmitted) {
        timerContainer.style.opacity = '0.5';
    }
</script>
@endpush