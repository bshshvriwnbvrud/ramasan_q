@extends('layouts.app')

@section('title', 'مرحباً بك في المسابقة')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white text-center py-4">
                    <h2 class="mb-0 fw-bold">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        تم التسجيل بنجاح
                    </h2>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-star-fill text-warning display-1"></i>
                    </div>

                    <h4 class="text-center mb-4 fw-bold">مرحباً بك {{ auth()->user()->name }} في مسابقة رمضان!</h4>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        يرجى قراءة التعليمات التالية بعناية قبل البدء:
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-circle p-3 fs-5">1</span>
                                </div>
                                <div>
                                    <h5 class="fw-bold">مواعيد المسابقة</h5>
                                    <p class="text-muted">المسابقة تفتح يومياً من الساعة 9 مساءً حتى 11 مساءً. لا يمكن الدخول قبل أو بعد هذا الوقت.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-circle p-3 fs-5">2</span>
                                </div>
                                <div>
                                    <h5 class="fw-bold">محاولة واحدة فقط</h5>
                                    <p class="text-muted">يمكنك الدخول للاختبار مرة واحدة فقط لكل يوم. تأكد من جاهزيتك قبل البدء.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-circle p-3 fs-5">3</span>
                                </div>
                                <div>
                                    <h5 class="fw-bold">الوقت المحدد</h5>
                                    <p class="text-muted">لكل سؤال وقت محدد (عادة 30 ثانية). إذا انتهى الوقت ينتقل للسؤال التالي تلقائياً.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-circle p-3 fs-5">4</span>
                                </div>
                                <div>
                                    <h5 class="fw-bold">لا رجوع للخلف</h5>
                                    <p class="text-muted">بعد الإجابة على سؤال لا يمكنك العودة إليه. اختر إجابتك بعناية.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-4">حسابك الآن بحاجة إلى موافقة الإدارة (قد تستغرق بضع دقائق). ستتمكن من دخول الاختبارات بعد الموافقة.</p>
                        <a href="{{ route('home') }}" class="btn btn-success btn-lg px-5">
                            <i class="bi bi-house-door-fill me-2"></i>
                            الذهاب إلى الصفحة الرئيسية
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection