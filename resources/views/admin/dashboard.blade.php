@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="container-fluid py-4">
    <!-- رأس الصفحة مع زر التحديث -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="font-family: 'Amiri', serif; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.3);" data-aos="fade-down">
            <i class="bi bi-grid-3x3-gap-fill me-2" style="color: var(--primary-gold);"></i>لوحة التحكم
        </h2>
        <button class="btn btn-outline-gold btn-sm" id="refreshDashboard" data-aos="fade-down">
            <i class="bi bi-arrow-repeat me-2"></i>تحديث الصفحة
        </button>
    </div>

    <!-- بطاقات الإحصائيات -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
            <div class="card stat-card h-100 border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">إجمالي المستخدمين</h6>
                            <h3 class="mb-0 text-white">{{ $totalUsers }}</h3>
                        </div>
                        <i class="bi bi-people-fill fs-1" style="color: var(--primary-gold); opacity: 0.6;"></i>
                    </div>
                    <small class="text-white-50">{{ $pendingUsers }} في انتظار الموافقة</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
            <div class="card stat-card h-100 border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">المسابقات</h6>
                            <h3 class="mb-0 text-white">{{ $totalCompetitions }}</h3>
                        </div>
                        <i class="bi bi-calendar2-week-fill fs-1" style="color: var(--primary-gold); opacity: 0.6;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
            <div class="card stat-card h-100 border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">إجمالي المحاولات</h6>
                            <h3 class="mb-0 text-white">{{ $totalAttempts }}</h3>
                        </div>
                        <i class="bi bi-clock-history fs-1" style="color: var(--primary-gold); opacity: 0.6;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
            <div class="card stat-card h-100 border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">يختبرون الآن</h6>
                            <h3 class="mb-0 text-white" id="nowTestingCount">{{ $nowTesting->count() }}</h3>
                        </div>
                        <i class="bi bi-person-workspace fs-1" style="color: var(--primary-gold); opacity: 0.6;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- صف الجداول مع تحسين responsive -->
    <div class="row">
        <!-- آخر المحاولات -->
        <div class="col-lg-6 mb-4" data-aos="fade-left">
            <div class="card glass-card h-100">
                <div class="card-header bg-transparent fw-bold text-white" style="border-bottom: 1px solid var(--glass-border);">
                    <i class="bi bi-clock-history me-2" style="color: var(--primary-gold);"></i>آخر 10 محاولات مكتملة
                </div>
                <div class="card-body p-0 p-md-3">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="sticky-top" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(5px);">
                                <tr>
                                    <th class="text-white-50">المستخدم</th>
                                    <th class="text-white-50">اليوم</th>
                                    <th class="text-white-50">الدرجة</th>
                                    <th class="text-white-50">الوقت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAttempts as $attempt)
                                    <tr>
                                        <td class="text-white">{{ $attempt->user->name }}</td>
                                        <td class="text-white">{{ $attempt->competition->day_number }}</td>
                                        <td class="text-white">{{ $attempt->score }}</td>
                                        <td class="text-white-50" data-bs-toggle="tooltip" title="{{ $attempt->submitted_at->format('Y-m-d H:i:s') }}">
                                            {{ $attempt->submitted_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: var(--primary-gold);"></i>
                                            <h5 class="text-white-50">لا توجد محاولات</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- المختبرون الآن -->
        <div class="col-lg-6 mb-4" data-aos="fade-right">
            <div class="card glass-card h-100">
                <div class="card-header bg-transparent fw-bold text-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--glass-border);">
                    <div>
                        <i class="bi bi-person-workspace me-2" style="color: var(--primary-gold);"></i>يختبرون الآن
                    </div>
                    <span class="badge bg-warning text-dark" id="nowTestingBadge">{{ $nowTesting->count() }}</span>
                </div>
                <div class="card-body p-0 p-md-3">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="sticky-top" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(5px);">
                                <tr>
                                    <th class="text-white-50">المستخدم</th>
                                    <th class="text-white-50">اليوم</th>
                                    <th class="text-white-50">بدأ في</th>
                                </tr>
                            </thead>
                            <tbody id="nowTestingTableBody">
                                @forelse($nowTesting as $attempt)
                                    <tr>
                                        <td class="text-white">{{ $attempt->user->name }}</td>
                                        <td class="text-white">{{ $attempt->competition->day_number }}</td>
                                        <td class="text-white-50" data-bs-toggle="tooltip" title="{{ $attempt->started_at->format('Y-m-d H:i:s') }}">
                                            {{ $attempt->started_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <i class="bi bi-emoji-neutral fs-1 d-block mb-3" style="color: var(--primary-gold);"></i>
                                            <h5 class="text-white-50">لا يوجد أحد يختبر الآن</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الرسم البياني مع زر التحميل -->
    <div class="row">
        <div class="col-12 mb-4" data-aos="fade-up">
            <div class="card glass-card">
                <div class="card-header bg-transparent fw-bold text-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--glass-border);">
                    <h5 class="mb-0 text-white"><i class="bi bi-bar-chart-steps me-2" style="color: var(--primary-gold);"></i>عدد المشاركات لكل يوم</h5>
                    <button class="btn btn-sm btn-outline-gold" id="downloadChart">
                        <i class="bi bi-download"></i>
                    </button>
                </div>
                <div class="card-body">
                    <canvas id="dailyChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- أفضل نتائج اليوم الحالي -->
    @if($todayCompetition)
    <div class="row">
        <div class="col-12" data-aos="fade-up">
            <div class="card glass-card">
                <div class="card-header bg-transparent d-flex flex-wrap justify-content-between align-items-center text-white" style="border-bottom: 1px solid var(--glass-border);">
                    <h5 class="mb-0 text-white"><i class="bi bi-trophy-fill me-2" style="color: var(--primary-gold);"></i>أفضل نتائج اليوم {{ $todayCompetition->day_number }}</h5>
                    <a href="{{ route('admin.competitions.winners.index', $todayCompetition) }}" class="btn-premium btn-primary-gold btn-sm mt-2 mt-sm-0">
                        <i class="bi bi-gear me-2"></i>إدارة الفائزين
                    </a>
                </div>
                <div class="card-body p-0 p-md-3">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th class="text-white-50">#</th>
                                    <th class="text-white-50">الاسم</th>
                                    <th class="text-white-50">الدرجة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topScores as $index => $attempt)
                                    <tr>
                                        <td class="text-white">{{ $index + 1 }}</td>
                                        <td class="text-white">{{ $attempt->user->name }}</td>
                                        <td class="text-white">{{ $attempt->score }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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

    /* بطاقة إحصائية زجاجية */
    .stat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        color: white;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary-gold);
        box-shadow: 0 15px 30px rgba(247, 183, 49, 0.2);
    }

    /* البطاقات الزجاجية العامة */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        color: white;
        transition: border-color 0.3s;
    }

    .glass-card:hover {
        border-color: var(--primary-gold);
    }

    /* الجداول */
    .table {
        --bs-table-color: white;
        --bs-table-bg: transparent;
        --bs-table-border-color: rgba(255,255,255,0.1);
        --bs-table-striped-bg: rgba(255,255,255,0.05);
        --bs-table-hover-bg: rgba(247, 183, 49, 0.1);
    }

    .table th, .table td {
        padding: 1rem 0.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    /* تثبيت رأس الجدول */
    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* شريط تمرير مخصص */
    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: var(--primary-gold);
        border-radius: 10px;
    }

    /* الأزرار المميزة */
    .btn-premium {
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .btn-primary-gold {
        background: linear-gradient(135deg, var(--primary-gold), #d49a1e);
        color: var(--dark-blue) !important;
        box-shadow: 0 10px 20px rgba(212, 154, 30, 0.3);
    }

    .btn-primary-gold:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(212, 154, 30, 0.5);
    }

    .btn-outline-gold {
        border: 2px solid var(--primary-gold);
        color: white;
        background: transparent;
        transition: all 0.3s;
    }
    .btn-outline-gold:hover {
        background: var(--primary-gold);
        color: var(--dark-blue);
    }

    /* تحسين ألوان النصوص */
    .text-white-50 {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    /* تنسيق الرسم البياني */
    canvas {
        background: transparent;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // تفعيل tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(el => new bootstrap.Tooltip(el));
    });

    // الرسم البياني
    const dailyStats = @json($dailyStats);
    const chart = new Chart(document.getElementById('dailyChart'), {
        type: 'bar',
        data: {
            labels: dailyStats.map(item => 'يوم ' + item.day_number),
            datasets: [{
                label: 'عدد المحاولات',
                data: dailyStats.map(item => item.attempts_count || 0),
                backgroundColor: 'rgba(247, 183, 49, 0.7)',
                borderRadius: 8,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { backgroundColor: 'rgba(0,0,0,0.8)' }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(255,255,255,0.1)' },
                    ticks: { color: 'rgba(255,255,255,0.7)' }
                },
                y: {
                    grid: { color: 'rgba(255,255,255,0.1)' },
                    ticks: { color: 'rgba(255,255,255,0.7)' }
                }
            }
        }
    });

    // تحميل الرسم البياني كصورة
    document.getElementById('downloadChart').addEventListener('click', function() {
        const link = document.createElement('a');
        link.download = 'daily-stats.png';
        link.href = document.getElementById('dailyChart').toDataURL('image/png');
        link.click();
    });

    // زر تحديث الصفحة
    document.getElementById('refreshDashboard').addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>جاري التحديث...';
        setTimeout(() => location.reload(), 300);
    });
</script>
@endpush