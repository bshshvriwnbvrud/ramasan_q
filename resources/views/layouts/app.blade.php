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

    <!-- Google Fonts - Tajawal & Amiri -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    <!-- AOS CSS (optional, but included for consistency) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-gold: #f7b731;
            --secondary-gold: #ffd966;
            --dark-blue: #0b1a33;
            --mid-blue: #1a3a5f;
            --light-blue: #2b4c7c;
            --glass-bg: rgba(255, 255, 255, 0.07);
            --glass-border: rgba(255, 255, 255, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: radial-gradient(circle at center, var(--mid-blue) 0%, var(--dark-blue) 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            color: white;
            transition: background-color 0.3s ease;
        }

        /* Islamic Pattern Overlay */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path d="M50 0 L60 40 L100 50 L60 60 L50 100 L40 60 L0 50 L40 40 Z" fill="rgba(255,215,0,0.03)"/></svg>');
            background-size: 80px 80px;
            opacity: 0.4;
            z-index: -1;
            pointer-events: none;
        }

        /* Dynamic Stars */
        .stars-container {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background: transparent;
            pointer-events: none;
        }

        .star-particle {
            position: absolute;
            background: white;
            border-radius: 50%;
            opacity: 0.5;
            animation: twinkle var(--duration) infinite ease-in-out;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); box-shadow: 0 0 10px white; }
        }

        /* Moon */
        .moon-glow {
            position: fixed;
            top: 5%;
            right: 5%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(247, 212, 74, 0.15) 0%, transparent 70%);
            z-index: -1;
            pointer-events: none;
        }

        .moon-crescent {
            position: fixed;
            top: 40px;
            right: 40px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            box-shadow: -20px 10px 0 0 #f7d44a;
            transform: rotate(-15deg);
            filter: drop-shadow(0 0 15px rgba(247, 212, 74, 0.6));
            animation: floatMoon 8s infinite ease-in-out;
            z-index: -1;
        }

        @keyframes floatMoon {
            0%, 100% { transform: translateY(0) rotate(-15deg); }
            50% { transform: translateY(-15px) rotate(-10deg); }
        }

        /* Lanterns */
        .lantern-wrapper {
            position: fixed;
            z-index: 5;
            filter: drop-shadow(0 0 15px var(--primary-gold));
            animation: swing 4s ease-in-out infinite alternate;
            transform-origin: top center;
            pointer-events: none;
        }

        .lantern-wrapper svg {
            width: 60px;
            height: 90px;
        }

        .lantern-1 { top: 0; left: 10%; animation-delay: 0s; }
        .lantern-2 { top: 0; right: 15%; animation-delay: 1s; }
        .lantern-3 { top: 0; left: 30%; animation-delay: 0.5s; opacity: 0.6; transform: scale(0.8); }

        @keyframes swing {
            0% { transform: rotate(-3deg); }
            100% { transform: rotate(3deg); }
        }

        /* Glass Navbar */
        .navbar {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-bottom: 1px solid var(--glass-border) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .navbar .navbar-brand,
        .navbar .nav-link {
            color: white !important;
            font-weight: 500;
            transition: color 0.2s;
        }

        .navbar .nav-link:hover {
            color: var(--primary-gold) !important;
        }

        .navbar .dropdown-menu {
            background: rgba(10, 25, 41, 0.8);
            backdrop-filter: blur(25px);
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
            color: var(--primary-gold);
            transform: translateX(-5px);
        }

        /* Dark mode adjustments */
        [data-bs-theme="dark"] body {
            background: radial-gradient(circle at center, #0f1a2e, #030712);
        }

        [data-bs-theme="dark"] .navbar .dropdown-menu {
            background: rgba(0, 0, 0, 0.6);
        }

        [data-bs-theme="dark"] .admin-sidebar {
            background: rgba(0, 0, 0, 0.3) !important;
        }

        /* Admin Sidebar (Glass) */
        .admin-sidebar {
            min-height: calc(100vh - 76px);
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-left: 1px solid var(--glass-border);
            padding: 1.5rem 0;
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
        }

        .admin-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 0.9rem 1.8rem;
            margin: 0.3rem 0;
            border-radius: 0 40px 40px 0;
            font-weight: 600;
            transition: all 0.3s;
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
            color: var(--primary-gold);
            border-color: rgba(247, 183, 49, 0.3);
            border-right-color: transparent;
        }

        .admin-sidebar .nav-link:hover i {
            transform: scale(1.1) translateX(-3px);
        }

        .admin-sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(247, 183, 49, 0.25), transparent);
            color: var(--primary-gold);
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

        /* Buttons */
        .btn {
            border-radius: 50px;
            padding: 0.6rem 1.8rem;
            font-weight: 600;
            transition: all 0.3s;
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(5px);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-primary {
            background: rgba(13, 110, 253, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .btn-primary:hover {
            background: rgba(13, 110, 253, 0.6);
        }

        .btn-success {
            background: rgba(25, 135, 84, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .btn-warning {
            background: rgba(247, 183, 49, 0.3);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-warning:hover {
            background: rgba(247, 183, 49, 0.6);
            color: var(--dark-blue);
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

        /* Glass Cards (used in pages) */
        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            color: white;
            transition: all 0.3s;
        }

        .card:hover {
            border-color: var(--primary-gold);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        /* Timer (if used) */
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

        /* Progress bar */
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

        /* Responsive */
        @media (max-width: 768px) {
            .timer-container { font-size: 1.5rem; padding: 0.4rem 1.5rem; }
            .lantern-3 { display: none; }
            .lantern-wrapper svg { width: 40px; height: 60px; }
        }

        /* General animations */
        main, .container-fluid {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Badges */
        .badge {
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 500;
            background: rgba(255, 255, 255, 0.1);
        }

        .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Animated Stars -->
    <div class="stars-container" id="stars"></div>

    <!-- Moon and Lanterns -->
    <div class="moon-glow"></div>
    <div class="moon-crescent"></div>

    <div class="lantern-wrapper lantern-1">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2V4M12 20V22M12 4C9 4 7 6 7 9C7 11.5 9 13.5 10 14.5V17H14V14.5C15 13.5 17 11.5 17 9C17 6 15 4 12 4Z" stroke="#f7b731" stroke-width="1.5" stroke-linecap="round"/>
            <circle cx="12" cy="9" r="2" fill="#f7b731">
                <animate attributeName="opacity" values="0.4;1;0.4" dur="2s" repeatCount="indefinite" />
            </circle>
        </svg>
    </div>
    <div class="lantern-wrapper lantern-2">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2V4M12 20V22M12 4C9 4 7 6 7 9C7 11.5 9 13.5 10 14.5V17H14V14.5C15 13.5 17 11.5 17 9C17 6 15 4 12 4Z" stroke="#f7b731" stroke-width="1.5" stroke-linecap="round"/>
            <circle cx="12" cy="9" r="2" fill="#f7b731">
                <animate attributeName="opacity" values="0.4;1;0.4" dur="2s" repeatCount="indefinite" />
            </circle>
        </svg>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg py-3 sticky-top">
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
                    <!-- عنا dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            عنا
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('about') }}#college">الكلية</a></li>
                            <li><a class="dropdown-item" href="{{ route('about') }}#about-competition">عن المسابقة</a></li>
                            <li><a class="dropdown-item" href="{{ route('about') }}#developers">المطورون</a></li>
                        </ul>
                    </li>
                    <!-- تعليمات dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            تعليمات
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('instructions') }}#how-to-use">كيفية استخدام الموقع</a></li>
                            <li><a class="dropdown-item" href="{{ route('instructions') }}#test-method">طريقة الاختبار</a></li>
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

    <!-- Main Content with Admin Sidebar (same logic as before) -->
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({ once: true, mirror: false });

        // Dynamic Stars
        (function() {
            const starsContainer = document.getElementById('stars');
            if (starsContainer) {
                const starCount = 80;
                for (let i = 0; i < starCount; i++) {
                    const star = document.createElement('div');
                    star.className = 'star-particle';
                    
                    const size = Math.random() * 3 + 1;
                    const posX = Math.random() * 100;
                    const posY = Math.random() * 100;
                    const duration = Math.random() * 3 + 2;
                    const delay = Math.random() * 5;

                    star.style.width = `${size}px`;
                    star.style.height = `${size}px`;
                    star.style.left = `${posX}%`;
                    star.style.top = `${posY}%`;
                    star.style.setProperty('--duration', `${duration}s`);
                    star.style.animationDelay = `${delay}s`;

                    starsContainer.appendChild(star);
                }
            }
        })();

        // Toastr options
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-left",
            rtl: true,
            timeOut: 5000,
        };

        // Dark mode toggle
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