@extends('layouts.app')

@section('title', 'تعليمات المسابقة')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card glass-card border-0" data-aos="zoom-in">
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, var(--primary-gold), #d49a1e); border-radius: 40px 40px 0 0; border-bottom: 1px solid var(--glass-border);">
                    <h2 class="mb-0 text-dark">
                        <i class="bi bi-question-circle-fill me-2"></i>تعليمات المسابقة
                    </h2>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <i class="bi bi-lightbulb text-warning display-1" style="filter: drop-shadow(0 0 15px var(--primary-gold));"></i>
                        <h3 class="mt-3" style="font-family: 'Amiri', serif; color: white;">كيف تشارك في المسابقة؟</h3>
                    </div>

                    <div class="accordion" id="instructionsAccordion">
                        <!-- التسجيل -->
                        <div class="accordion-item glass-accordion">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                    <i class="bi bi-person-plus-fill me-2" style="color: var(--primary-gold);"></i>
                                    ١. التسجيل في الموقع
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#instructionsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>قم بإنشاء حساب جديد عبر صفحة التسجيل.</li>
                                        <li>أدخل بياناتك الشخصية (الاسم، البريد الإلكتروني، رقم الهاتف، التخصص، رقم القيد اختياري).</li>
                                        <li>بعد التسجيل، سيكون حسابك قيد المراجعة من قبل الإدارة. ستتلقى إشعاراً عند قبول حسابك.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- مواعيد المسابقة -->
                        <div class="accordion-item glass-accordion">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                    <i class="bi bi-clock-history me-2" style="color: var(--primary-gold);"></i>
                                    ٢. مواعيد المسابقة
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#instructionsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li><strong>الوقت:</strong> تفتح المسابقة يومياً من الساعة 9:00 مساءً حتى 11:00 مساءً.</li>
                                        <li><strong>المدة:</strong> لا يمكن الدخول قبل أو بعد هذا الوقت.</li>
                                        <li><strong>عدد الأسئلة:</strong> يختلف من يوم لآخر (عادة 20-30 سؤال).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- طريقة الاختبار -->
                        <div class="accordion-item glass-accordion">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                    <i class="bi bi-pencil-square me-2" style="color: var(--primary-gold);"></i>
                                    ٣. طريقة الاختبار
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#instructionsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>اختر اليوم المطلوب من الصفحة الرئيسية.</li>
                                        <li>سيظهر لك سؤال مع أربعة خيارات.</li>
                                        <li>لديك <strong>30 ثانية</strong> لكل سؤال (قد يختلف الوقت حسب إعدادات اليوم).</li>
                                        <li>اختر إجابتك ثم اضغط على "تأكيد الإجابة".</li>
                                        <li><span class="text-danger">تنبيه:</span> لا يمكنك العودة للسؤال السابق بعد تأكيد الإجابة.</li>
                                        <li>إذا انتهى الوقت دون إجابة، ينتقل السؤال تلقائياً ويتم احتساب الإجابة خاطئة.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- سؤال شخصية اليوم -->
                        <div class="accordion-item glass-accordion">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                    <i class="bi bi-star-fill me-2" style="color: var(--primary-gold);"></i>
                                    ٤. شخصية اليوم (السؤال الخاص)
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#instructionsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>في نهاية كل اختبار، هناك سؤال خاص عن شخصية معينة.</li>
                                        <li>قبل الإجابة، تظهر صورة الشخصية مشوشة ولا يمكن رؤيتها.</li>
                                        <li>بعد الإجابة (سواء صحيحة أو خاطئة)، ستظهر الصورة واضحة مع اسم ووصف الشخصية.</li>
                                        <li>إذا كانت إجابتك صحيحة، يظهر شريط أخضر مع علامة صح. وإذا خاطئة يظهر شريط أحمر.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- النتائج -->
                        <div class="accordion-item glass-accordion">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                                    <i class="bi bi-bar-chart-fill me-2" style="color: var(--primary-gold);"></i>
                                    ٥. النتائج والفائزون
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#instructionsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>بعد انتهاء الاختبار، تظهر صفحة النتيجة مباشرة مع عدد الإجابات الصحيحة والخاطئة والفارغة.</li>
                                        <li>يتم إعلان الفائزين لكل يوم بعد مراجعة الإدارة.</li>
                                        <li>يمكنك الاطلاع على الفائزين من خلال الصفحة الرئيسية، بعد أن يتم نشر النتائج.</li>
                                        <li>سيظهر تأثير احتفالي (كونفيتي) عند عرض الفائزين.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- نصائح مهمة -->
                        <div class="accordion-item glass-accordion">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6">
                                    <i class="bi bi-exclamation-triangle-fill me-2" style="color: var(--primary-gold);"></i>
                                    ٦. نصائح مهمة
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#instructionsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>تأكد من استقرار اتصالك بالإنترنت قبل بدء الاختبار.</li>
                                        <li>لا تقم بتحديث الصفحة أو الضغط على زر الرجوع أثناء الاختبار.</li>
                                        <li>يمكنك الدخول للاختبار مرة واحدة فقط لكل يوم.</li>
                                        <li>إذا واجهت مشكلة تقنية، تواصل مع إدارة الموقع.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-5 glass-card" style="border: 1px solid rgba(247, 183, 49, 0.5);">
                        <i class="bi bi-chat-dots-fill me-2" style="color: var(--primary-gold);"></i>
                        للمزيد من الاستفسارات، يمكنك التواصل مع إدارة الكلية عبر البريد الإلكتروني: <strong>info@college.edu</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* تنسيق البطاقة الزجاجية */
    .glass-card {
        background: var(--glass-bg) !important;
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 40px;
        color: white;
    }

    /* تنسيق الأكورديون الزجاجي */
    .glass-accordion {
        background: rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 30px !important;
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .glass-accordion .accordion-header {
        border-radius: 30px;
    }

    .glass-accordion .accordion-button {
        background: transparent;
        color: white;
        font-weight: 700;
        padding: 1.5rem 2rem;
        border-radius: 30px !important;
        box-shadow: none;
    }

    .glass-accordion .accordion-button:not(.collapsed) {
        background: rgba(247, 183, 49, 0.1);
        color: var(--primary-gold);
    }

    .glass-accordion .accordion-button::after {
        filter: brightness(0) invert(1); /* يجعل السهم أبيض */
    }

    .glass-accordion .accordion-button:not(.collapsed)::after {
        filter: brightness(0) invert(1) sepia(1) hue-rotate(180deg); /* لون ذهبي تقريباً */
    }

    .glass-accordion .accordion-body {
        background: rgba(0, 0, 0, 0.2);
        color: rgba(255, 255, 255, 0.9);
        border-top: 1px solid var(--glass-border);
        padding: 1.5rem 2rem;
        border-radius: 0 0 30px 30px;
    }

    .glass-accordion .accordion-body ul {
        list-style-type: disc;
        padding-right: 1.5rem;
    }

    .glass-accordion .accordion-body li {
        margin-bottom: 0.5rem;
        line-height: 1.7;
    }

    .glass-accordion .accordion-body strong {
        color: var(--primary-gold);
    }

    /* تنسيق التنبيه */
    .alert-info {
        background: rgba(13, 202, 240, 0.1) !important;
        border: 1px solid rgba(13, 202, 240, 0.3);
        color: white;
        border-radius: 30px;
        padding: 1.2rem 1.8rem;
    }

    /* أيقونات أكبر قليلاً */
    .bi {
        vertical-align: middle;
    }

    /* تنسيق النص داخل البطاقة */
    .card-body h3 {
        color: white;
        font-size: 2.2rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
</style>
@endpush