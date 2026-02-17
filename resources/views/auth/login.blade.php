<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل دخول - المسابقة الرمضانية</title>
    
    <!-- Bootstrap 5 RTL + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts - Tajawal & Amiri -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- AOS CSS -->
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
            --error-red: #ff4d4d;
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Islamic Pattern Overlay */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path d="M50 0 L60 40 L100 50 L60 60 L50 100 L40 60 L0 50 L40 40 Z" fill="rgba(255,215,0,0.03)"/></svg>');
            background-size: 80px 80px;
            opacity: 0.4;
            z-index: 0;
            pointer-events: none;
        }

        /* Dynamic Stars Background */
        .stars-container {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
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

        /* Hanging Lanterns */
        .lantern-wrapper {
            position: absolute;
            z-index: 5;
            filter: drop-shadow(0 0 15px var(--primary-gold));
            animation: swing 4s ease-in-out infinite alternate;
            transform-origin: top center;
        }

        .lantern-wrapper svg {
            width: 50px;
            height: 75px;
        }

        .lantern-1 { top: 0; left: 10%; animation-delay: 0s; }
        .lantern-2 { top: 0; right: 10%; animation-delay: 1s; }

        @keyframes swing {
            0% { transform: rotate(-3deg); }
            100% { transform: rotate(3deg); }
        }

        /* Glassmorphism Login Card */
        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 40px;
            padding: 3rem 2.5rem;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), 
                        inset 0 0 20px rgba(255, 255, 255, 0.05);
            position: relative;
            z-index: 10;
            margin: 2rem auto;
        }

        h3 {
            font-family: 'Amiri', serif;
            font-weight: 700;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 2rem;
            background: linear-gradient(to bottom, #fff 20%, var(--primary-gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }

        /* Premium Form Styling */
        .form-floating {
            margin-bottom: 1.2rem;
        }

        .form-floating input {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 20px !important;
            color: white !important;
            height: 65px;
            padding: 1rem 1.2rem;
            transition: all 0.3s ease;
        }

        .form-floating input:focus {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: var(--primary-gold) !important;
            box-shadow: 0 0 15px rgba(247, 183, 49, 0.2) !important;
        }

        .form-floating label {
            color: rgba(255, 255, 255, 0.6) !important;
            padding-right: 1.2rem;
        }

        .form-floating input:focus ~ label,
        .form-floating input:not(:placeholder-shown) ~ label {
            color: var(--primary-gold) !important;
            transform: scale(0.85) translateY(-1rem) translateX(0.5rem);
        }

        /* Error Messages */
        .error-alert {
            background: rgba(255, 77, 77, 0.15);
            border: 1px solid rgba(255, 77, 77, 0.3);
            border-radius: 15px;
            color: #ffb3b3;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            list-style: none;
        }

        .error-alert li {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Login Button */
        .btn-premium {
            background: linear-gradient(135deg, var(--primary-gold), #d49a1e);
            color: var(--dark-blue) !important;
            border: none;
            border-radius: 20px;
            height: 60px;
            font-weight: 700;
            font-size: 1.2rem;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(212, 154, 30, 0.2);
        }

        .btn-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(212, 154, 30, 0.4);
            background: linear-gradient(135deg, var(--secondary-gold), var(--primary-gold));
        }

        .shine {
            position: absolute;
            top: 0; left: -100%;
            width: 50%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.5s;
        }

        .btn-premium:hover .shine {
            left: 150%;
            transition: 0.8s;
        }

        /* Footer Link */
        .register-footer {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
        }

        .register-footer a {
            color: var(--primary-gold);
            text-decoration: none;
            font-weight: 700;
            margin-right: 5px;
            transition: all 0.3s;
        }

        .register-footer a:hover {
            color: var(--secondary-gold);
            text-shadow: 0 0 10px rgba(247, 183, 49, 0.4);
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-card { padding: 2.5rem 1.5rem; }
            h3 { font-size: 2rem; }
            .lantern-wrapper svg { width: 40px; height: 60px; }
        }
    </style>
</head>
<body>

    <!-- Animated Stars -->
    <div class="stars-container" id="stars"></div>

    <!-- Hanging Lanterns -->
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

    <div class="login-card" data-aos="zoom-in" data-aos-duration="800">
        <h3>
            <i class="bi bi-person-lock me-2"></i>تسجيل الدخول
        </h3>

        @if ($errors->any())
            <div class="error-alert">
                <ul class="mb-0 ps-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle-fill"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-floating">
                <input type="email" name="email" class="form-control" id="email" placeholder="البريد الإلكتروني" value="{{ old('email') }}" required>
                <label for="email"><i class="bi bi-envelope-at ms-1"></i> البريد الإلكتروني</label>
            </div>

            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="password" placeholder="كلمة المرور" required>
                <label for="password"><i class="bi bi-shield-lock ms-1"></i> كلمة المرور</label>
            </div>

            <button type="submit" class="btn-premium">
                <span>دخول</span>
                <i class="bi bi-arrow-left-short fs-4"></i>
                <div class="shine"></div>
            </button>

            <div class="register-footer">
                ليس لديك حساب؟ <a href="{{ route('register') }}">أنشئ حسابك الآن</a>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({ once: true });

        // Create Dynamic Stars
        const starsContainer = document.getElementById('stars');
        const starCount = 60;

        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.className = 'star-particle';
            const size = Math.random() * 2 + 1;
            star.style.width = `${size}px`;
            star.style.height = `${size}px`;
            star.style.left = `${Math.random() * 100}%`;
            star.style.top = `${Math.random() * 100}%`;
            star.style.setProperty('--duration', `${Math.random() * 3 + 2}s`);
            star.style.animationDelay = `${Math.random() * 5}s`;
            starsContainer.appendChild(star);
        }
    </script>
</body>
</html>
