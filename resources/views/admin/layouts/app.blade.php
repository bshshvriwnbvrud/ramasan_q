<!doctype html>
<html lang="ar" dir="rtl" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <!-- Bootstrap 5 RTL + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Google Fonts - Tajawal -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --ramadan-gold: #f7b731;
            --ramadan-gold-light: #ffd966;
            --ramadan-night: #1e2a47;
            --ramadan-deep-blue: #0b1a33;
            --glass-bg-light: rgba(255, 255, 255, 0.15);
            --glass-bg-dark: rgba(30, 30, 47, 0.6);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        /* خلفية متحركة - تعديل لتكون أغمق قليلاً لتحسين تباين النص */
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(145deg, #0a1929 0%, #1a2f4a 100%);
            transition: background-color 0.3s ease, color 0.3s ease;
            position: relative;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
            color: #fff;
        }

        .stars, .twinkling {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            display: block;
            pointer-events: none;
            z-index: -1;
        }

        .stars {
            background: #000 url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIj48Y2lyY2xlIGN4PSI2IiBjeT0iMTQiIHI9IjEiIGZpbGw9IndoaXRlIiAvPjxjaXJjbGUgY3g9IjE2MCIgY3k9IjYwIiByPSIxIiBmaWxsPSJ3aGl0ZSIgLz48Y2lyY2xlIGN4PSI0MCIgY3k9IjIxMCIgcj0iMSIgZmlsbD0id2hpdGUiIC8+PC9zdmc+');
            background-size: 200px 200px;
            animation: starsAnim 200s linear infinite;
            opacity: 0.4;
        }

        .twinkling {
            background: transparent url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIj48Y2lyY2xlIGN4PSIxMDAiIGN5PSI1MCIgcj0iMiIgZmlsbD0iI2ZmZmZmZiIgZmlsdGVyPSJ1cmwoI2ZpbHRlci1mYWRlKSIvPjwvc3ZnPg==');
            background-size: 200px 200px;
            animation: twinklingAnim 4s linear infinite;
            opacity: 0.3;
        }

        @keyframes starsAnim {
            from { transform: translateY(0); }
            to { transform: translateY(-2000px); }
        }

        @keyframes twinklingAnim {
            0% { opacity: 0.1; }
            50% { opacity: 0.5; }
            100% { opacity: 0.1; }
        }

        /* فوانيس متحركة - تعديل الشفافية لتكون أقل بروزاً */
        .lantern {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 60px;
            height: 80px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23f7b731"><path d="M12 2C8 2 4 5 4 9c0 4 8 13 8 13s8-9 8-13c0-4-4-7-8-7z"/></svg>') no-repeat center;
            background-size: contain;
            animation: swing 4s infinite ease-in-out;
            filter: drop-shadow(0 0 8px rgba(247, 183, 49, 0.3));
            z-index: 10;
            pointer-events: none;
            opacity: 0.7;
        }

        .lantern.right {
            left: auto;
            right: 20px;
            transform: scaleX(-1);
        }

        @keyframes swing {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(3deg); }
            75% { transform: rotate(-3deg); }
            100% { transform: rotate(0deg); }
        }

        /* الشريط العلوي - شفاف بالكامل مع تأثير زجاجي */
        .navbar {
            background: var(--glass-bg-light) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .navbar .navbar-brand,
        .navbar .nav-link {
            color: white !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            font-weight: 500;
            transition: color 0.2s;
        }

        .navbar .nav-link:hover {
            color: var(--ramadan-gold) !important;
        }

        .navbar .dropdown-menu {
            background: rgba(10, 25, 41, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            margin-top: 10px;
            padding: 0.5rem;
        }

        .navbar .dropdown-item {
            color: white;
            border-radius: 15px;
            padding: 0.7rem 1.5rem;
            transition: all 0.2s;
        }

        .navbar .dropdown-item:hover {
            background: rgba(247, 183, 49, 0.2);
            color: var(--ramadan-gold);
            transform: translateX(-5px);
        }

        /* الوضع الليلي للشريط */
        [data-bs-theme="dark"] .navbar {
            background: var(--glass-bg-dark) !important;
        }

        [data-bs-theme="dark"] .navbar .dropdown-menu {
            background: rgba(20, 20, 30, 0.9);
        }

        /* تخصيص باقي العناصر */
        [data-bs-theme="dark"] .card {
            background: var(--glass-bg-dark);
            border-color: rgba(255, 255, 255, 0.1);
        }

        [data-bs-theme="dark"] .table {
            --bs-table-color: #f8f9fa;
            --bs-table-bg: transparent;
            --bs-table-border-color: rgba(255, 255, 255, 0.1);
            --bs-table-striped-bg: rgba(255, 255, 255, 0.05);
        }

        /* تحسينات عامة للعناصر */
        .btn {
            border-radius: 50px;
            padding: 0.6rem 1.8rem;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            backdrop-filter: blur(5px);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-primary {
            background: rgba(13, 110, 253, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-primary:hover {
            background: rgba(13, 110, 253, 1);
        }

        .btn-success {
            background: rgba(25, 135, 84, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-warning {
            background: rgba(247, 183, 49, 0.8);
            color: #0b1a33;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.5);
            color: white;
            background: transparent;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: white;
        }

        .card {
            border-radius: 25px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            backdrop-filter: blur(12px);
            background: var(--glass-bg-light);
            color: white;
        }

        .card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transform: translateY(-5px);
            border-color: rgba(247, 183, 49, 0.3);
        }

        .timer-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 60px;
            padding: 0.6rem 2.2rem;
            color: white;
            font-size: 2.2rem;
            font-weight: bold;
            display: inline-block;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
        }

        /* تحسين العرض على الهواتف */
        @media (max-width: 768px) {
            .timer-container {
                font-size: 1.5rem;
                padding: 0.4rem 1.5rem;
            }
            h1 { font-size: 2rem; }
            .lantern {
                width: 40px;
                height: 60px;
                opacity: 0.5;
            }
        }

        /* شريط التقدم */
        .progress {
            height: 12px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
        }
        .progress-bar {
            background: linear-gradient(90deg, #f7b731, #ffd966);
            border-radius: 20px;
        }

        /* الشريط الجانبي للأدمن - شفاف بالكامل */
        .admin-sidebar {
            min-height: calc(100vh - 76px);
            background: var(--glass-bg-light);
            backdrop-filter: blur(12px);
            border-left: 1px solid var(--glass-border);
            padding: 1.5rem 0;
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
        }

        [data-bs-theme="dark"] .admin-sidebar {
            background: var(--glass-bg-dark);
        }

        .admin-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 0.9rem 1.8rem;
            margin: 0.3rem 0;
            border-radius: 0 40px 40px 0;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
            border: 1px solid transparent;
            border-right: none;
        }

        .admin-sidebar .nav-link i {
            font-size: 1.2rem;
            margin-left: 0.8rem;
            transition: transform 0.2s;
        }

        .admin-sidebar .nav-link:hover {
            background: linear-gradient(90deg, rgba(247, 183, 49, 0.15), transparent);
            color: var(--ramadan-gold);
            border-color: rgba(247, 183, 49, 0.3);
            border-right-color: transparent;
        }

        .admin-sidebar .nav-link:hover i {
            transform: scale(1.1) translateX(-3px);
        }

        .admin-sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(247, 183, 49, 0.25), transparent);
            color: var(--ramadan-gold);
            border-color: rgba(247, 183, 49, 0.5);
            border-right-color: transparent;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(247, 183, 49, 0.2);
        }

        .admin-sidebar .nav-link.active::before {
            content: "🌙";
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            opacity: 0.5;
        }

        /* الوضع الليلي للشريط الجانبي */
        [data-bs-theme="dark"] .admin-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
        }

        [data-bs-theme="dark"] .admin-sidebar .nav-link:hover,
        [data-bs-theme="dark"] .admin-sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(255, 217, 102, 0.2), transparent);
            color: #ffd966;
        }

        /* أنيميشن للمحتوى */
        main, .container-fluid {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* تحسين ظهور النصوص في البطاقات */
        .text-muted {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        /* تخصيص شارات الحالة */
        .badge {
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 500;
        }

        .badge.bg-success {
            background: rgba(25, 135, 84, 0.7) !important;
        }
        .badge.bg-warning {
            background: rgba(247, 183, 49, 0.7) !important;
            color: #0b1a33 !important;
        }
        .badge.bg-secondary {
            background: rgba(108, 117, 125, 0.7) !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- خلفية متحركة -->
    <div class="stars"></div>
    <div class="twinkling"></div>

    <!-- فوانيس -->
    <div class="lantern"></div>
    <div class="lantern right"></div>

    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg shadow-sm py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-moon-stars-fill text-warning me-2"></i>
                مسابقة رمضان
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- قسم عنا (منسدل) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            عنا
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">الكلية</a></li>
                            <li><a class="dropdown-item" href="#">عن المسابقة</a></li>
                            <li><a class="dropdown-item" href="#">المطورون</a></li>
                        </ul>
                    </li>

                    <!-- قسم تعليمات (منسدل) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            تعليمات
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">كيفية استخدام الموقع</a></li>
                            <li><a class="dropdown-item" href="#">طريقة الاختبار</a></li>
                        </ul>
                    </li>

                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">الرئيسية</a>
                        </li>
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">لوحة التحكم</a>
                            </li>
                        @endif
                        @if(auth()->user()->isSupervisor())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('supervisor.dashboard') }}">لوحة المشرف</a>
                            </li>
                        @endif
                        @if(auth()->user()->isEditor())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('editor.questions.index') }}">إدارة الأسئلة</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-5 me-1"></i>
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('student.profile') }}">
                                        <i class="bi bi-person-badge me-2"></i>الملف الشخصي
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <i class="bi bi-box-arrow-right me-2"></i>تسجيل خروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">تسجيل دخول</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">تسجيل جديد</a>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <button class="btn btn-link nav-link" id="darkModeToggle">
                            <i class="bi bi-sun-fill" id="darkModeIcon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- المحتوى الرئيسي مع الشريط الجانبي للأدمن (الشرط الأصلي) -->
    @if(auth()->check() && auth()->user()->isAdmin() && !request()->routeIs('admin.dashboard') && !request()->routeIs('admin.*.create') && !request()->routeIs('admin.*.edit') && !request()->routeIs('admin.*.import') && !request()->routeIs('admin.*.suggest'))
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-lg-2 p-0 admin-sidebar">
                    @include('admin.layouts.sidebar')
                </div>
                <div class="col-md-9 col-lg-10 p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    @else
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-left",
            "rtl": true,
            "timeOut": "5000",
        };
    </script>
    <!-- Dark mode toggle محسن -->
    <script>
        (function() {
            const html = document.documentElement;
            const icon = document.getElementById('darkModeIcon');
            const storedTheme = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            const setTheme = (theme) => {
                html.setAttribute('data-bs-theme', theme);
                localStorage.setItem('theme', theme);
                if (icon) {
                    icon.className = theme === 'dark' ? 'bi bi-moon-stars-fill' : 'bi bi-sun-fill';
                }
            };

            const initialTheme = storedTheme || (systemDark ? 'dark' : 'light');
            setTheme(initialTheme);

            document.getElementById('darkModeToggle')?.addEventListener('click', () => {
                const current = html.getAttribute('data-bs-theme');
                setTheme(current === 'dark' ? 'light' : 'dark');
            });
        })();
    </script>
    <!-- Flash messages -->
    @if(session('success'))
        <script>toastr.success("{{ session('success') }}");</script>
    @endif
    @if(session('error'))
        <script>toastr.error("{{ session('error') }}");</script>
    @endif
    @if(session('info'))
        <script>toastr.info("{{ session('info') }}");</script>
    @endif
    @if(session('warning'))
        <script>toastr.warning("{{ session('warning') }}");</script>
    @endif
    @stack('scripts')
</body>
</html>