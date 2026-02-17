@extends('layouts.app')

@section('title', 'عنا')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card glass-card border-0" data-aos="zoom-in">
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, var(--primary-gold), #d49a1e); border-radius: 40px 40px 0 0; border-bottom: 1px solid var(--glass-border);">
                    <h2 class="mb-0 text-dark">
                        <i class="bi bi-info-circle-fill me-2"></i>عن المسابقة
                    </h2>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <i class="bi bi-moon-stars-fill text-warning display-1" style="filter: drop-shadow(0 0 15px var(--primary-gold));"></i>
                        <h3 class="mt-3" style="font-family: 'Amiri', serif; color: white;">مسابقة رمضان الثقافية</h3>
                        <p class="lead" style="color: rgba(255,255,255,0.8);">تنظيم كلية العلوم والآداب - جامعة تعز</p>
                    </div>

                    <div class="row mt-5">
                        <!-- عن الكلية -->
                        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge-glass rounded-circle p-3">
                                        <i class="bi bi-building fs-4" style="color: var(--primary-gold);"></i>
                                    </span>
                                </div>
                                <div>
                                    <h5 style="color: var(--primary-gold);">عن الكلية</h5>
                                    <p style="color: rgba(255,255,255,0.8);">كلية العلوم والآداب هي إحدى كليات جامعة تعز، تأسست عام 1995م، وتسعى إلى تخريج كوادر مؤهلة في مختلف التخصصات العلمية والإنسانية.</p>
                                </div>
                            </div>
                        </div>
                        <!-- عن المسابقة -->
                        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge-glass rounded-circle p-3">
                                        <i class="bi bi-trophy fs-4" style="color: var(--primary-gold);"></i>
                                    </span>
                                </div>
                                <div>
                                    <h5 style="color: var(--primary-gold);">عن المسابقة</h5>
                                    <p style="color: rgba(255,255,255,0.8);">مسابقة يومية طوال شهر رمضان المبارك، تهدف إلى تنمية المعرفة الثقافية والدينية وتعزيز الروح التنافسية بين الطلاب.</p>
                                </div>
                            </div>
                        </div>
                        <!-- الفريق المنظم -->
                        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge-glass rounded-circle p-3">
                                        <i class="bi bi-people fs-4" style="color: var(--primary-gold);"></i>
                                    </span>
                                </div>
                                <div>
                                    <h5 style="color: var(--primary-gold);">الفريق المنظم</h5>
                                    <p style="color: rgba(255,255,255,0.8);">يشرف على المسابقة نخبة من أعضاء هيئة التدريس بالكلية، بدعم من عمادة الكلية وإدارة الجامعة.</p>
                                </div>
                            </div>
                        </div>
                        <!-- المطورون -->
                        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge-glass rounded-circle p-3">
                                        <i class="bi bi-code-slash fs-4" style="color: var(--primary-gold);"></i>
                                    </span>
                                </div>
                                <div>
                                    <h5 style="color: var(--primary-gold);">المطورون</h5>
                                    <p style="color: rgba(255,255,255,0.8);">تم تطوير هذا الموقع بواسطة فريق طلابي من قسم تقنية المعلومات، بإشراف د. محمد عبدالله.</p>
                                    <ul class="list-unstyled" style="color: rgba(255,255,255,0.8);">
                                        <li><i class="bi bi-person-circle me-2" style="color: var(--primary-gold);"></i> أحمد علي - قائد الفريق</li>
                                        <li><i class="bi bi-person-circle me-2" style="color: var(--primary-gold);"></i> فاطمة صالح - مطور واجهات</li>
                                        <li><i class="bi bi-person-circle me-2" style="color: var(--primary-gold);"></i> عبدالله محمود - مطور خلفية</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
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

    /* شارات زجاجية دائرية */
    .badge-glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(247, 183, 49, 0.5);
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .badge-glass:hover {
        background: rgba(247, 183, 49, 0.2);
        border-color: var(--primary-gold);
        transform: scale(1.05) rotate(5deg);
    }

    /* عناوين الأقسام */
    h5 {
        font-weight: 700;
        margin-bottom: 0.8rem;
    }

    /* القوائم غير المرقمة */
    .list-unstyled li {
        margin-bottom: 0.5rem;
        transition: transform 0.2s;
    }

    .list-unstyled li:hover {
        transform: translateX(-5px);
    }

    /* الخط الرئيسي */
    .lead {
        font-size: 1.25rem;
        font-weight: 400;
    }

    /* تحسين المظهر على الشاشات الصغيرة */
    @media (max-width: 768px) {
        .badge-glass {
            width: 60px;
            height: 60px;
        }
        .badge-glass i {
            font-size: 1.5rem !important;
        }
    }
</style>
@endpush