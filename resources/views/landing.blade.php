<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>المسابقة الرمضانية - تجربة إيمانية متكاملة</title>
    
    <!-- Bootstrap 5 RTL + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts - Tajawal & Amiri for Calligraphy feel -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- AOS JS -->
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
            background: transparent;
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

        /* Improved Moon */
        .moon-glow {
            position: absolute;
            top: 5%;
            right: 5%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(247, 212, 74, 0.15) 0%, transparent 70%);
            z-index: 1;
            pointer-events: none;
        }

        .moon-crescent {
            position: absolute;
            top: 40px;
            right: 40px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            box-shadow: -20px 10px 0 0 #f7d44a;
            transform: rotate(-15deg);
            filter: drop-shadow(0 0 15px rgba(247, 212, 74, 0.6));
            animation: floatMoon 8s infinite ease-in-out;
        }

        @keyframes floatMoon {
            0%, 100% { transform: translateY(0) rotate(-15deg); }
            50% { transform: translateY(-15px) rotate(-10deg); }
        }

        /* Elegant Lanterns */
        .lantern-wrapper {
            position: absolute;
            z-index: 5;
            filter: drop-shadow(0 0 15px var(--primary-gold));
            animation: swing 4s ease-in-out infinite alternate;
            transform-origin: top center;
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

        /* Glassmorphism Card */
        .main-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 40px;
            padding: 3.5rem 2rem;
            max-width: 650px;
            width: 90%;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), 
                        inset 0 0 20px rgba(255, 255, 255, 0.05);
            position: relative;
            z-index: 10;
            margin: 2rem auto;
        }

        .main-card::after {
            content: "";
            position: absolute;
            top: -2px; left: -2px; right: -2px; bottom: -2px;
            background: linear-gradient(135deg, var(--glass-border), transparent, var(--glass-border));
            border-radius: 40px;
            z-index: -1;
        }

        /* Profile Image Section */
        .profile-container {
            position: relative;
            display: inline-block;
            margin-bottom: 2.5rem;
        }

        .profile-image {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-gold);
            padding: 6px;
            background: linear-gradient(145deg, var(--dark-blue), var(--mid-blue));
            box-shadow: 0 0 30px rgba(247, 183, 49, 0.4);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .profile-container:hover .profile-image {
            transform: scale(1.05) rotate(3deg);
            box-shadow: 0 0 50px rgba(247, 183, 49, 0.6);
        }

        .profile-decoration {
            position: absolute;
            top: -10px; right: -10px;
            font-size: 2.5rem;
            filter: drop-shadow(0 0 10px gold);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 1; }
        }

        /* Typography */
        h1 {
            font-family: 'Amiri', serif;
            font-weight: 700;
            font-size: 3.8rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(to bottom, #fff 20%, var(--primary-gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }

        .subtitle {
            font-size: 1.4rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 3rem;
            line-height: 1.6;
        }

        .highlight {
            color: var(--primary-gold);
            font-weight: 700;
            position: relative;
        }

        /* Premium Buttons */
        .btn-group-custom {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-premium {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.2rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 200px;
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

        .btn-outline-gold {
            background: transparent;
            color: white !important;
            border: 2px solid var(--primary-gold);
        }

        .btn-outline-gold:hover {
            background: var(--primary-gold);
            color: var(--dark-blue) !important;
            transform: translateY(-5px);
        }

        /* Footer Logos */
        .footer-section {
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-logo {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid var(--primary-gold);
            padding: 3px;
            background: white;
            transition: transform 0.3s ease;
        }

        .footer-logo:hover {
            transform: rotate(360deg) scale(1.1);
        }

        .ramadan-kareem-text {
            font-family: 'Amiri', serif;
            font-size: 1.2rem;
            color: var(--secondary-gold);
            opacity: 0.8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h1 { font-size: 2.8rem; }
            .subtitle { font-size: 1.1rem; }
            .main-card { padding: 2.5rem 1.5rem; }
            .btn-premium { width: 100%; }
            .moon-glow { transform: scale(0.6); top: -20px; right: -20px; }
            .lantern-3 { display: none; }
        }

        /* Shine Effect */
        .shine {
            position: absolute;
            top: 0; left: -100%;
            width: 50%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-premium:hover .shine {
            left: 150%;
            transition: 0.8s;
        }
    </style>
</head>
<body>

    <!-- Animated Stars -->
    <div class="stars-container" id="stars"></div>

    <!-- Background Elements -->
    <div class="moon-glow"></div>
    <div class="moon-crescent"></div>

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

    <div class="main-card" data-aos="zoom-in" data-aos-duration="1000">
        <!-- Profile Image -->
        <div class="profile-container" data-aos="fade-down" data-aos-delay="200">
            <img src="{{ asset('images/abdulmalik.jpg') }}" alt="الشعار" class="profile-image">
            <div class="profile-decoration">✨</div>
        </div>

        <!-- Content -->
        <h1 data-aos="fade-up" data-aos-delay="400">المسابقة الرمضانية</h1>
        
        <p class="subtitle" data-aos="fade-up" data-aos-delay="600">
            رمضان محطة العطاء والتقوى، ترحب بكم <br> 
            <span class="highlight">في موسمها الثاني</span> لعام 1447هـ
        </p>

        <!-- Action Buttons -->
        <div class="btn-group-custom" data-aos="fade-up" data-aos-delay="800">
            <a href="{{ route('register') }}" class="btn-premium btn-primary-gold">
                <i class="bi bi-person-plus-fill me-2"></i>
                <span>إنشاء حساب جديد</span>
                <div class="shine"></div>
            </a>
            <a href="{{ route('login') }}" class="btn-premium btn-outline-gold">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                <span>تسجيل الدخول</span>
                <div class="shine"></div>
            </a>
        </div>

        <!-- Footer -->
        <div class="footer-section" data-aos="fade-up" data-aos-delay="1000">
            <img src="{{ asset('images/logo-right.png') }}" alt="Logo" class="footer-logo">
            <div class="ramadan-kareem-text">
                <i class="bi bi-stars me-1"></i>
                رمضان مبارك وكل عام وأنتم بخير
            </div>
            <img src="{{ asset('images/logo-left.png') }}" alt="Logo" class="footer-logo">
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            mirror: false
        });

        // Create Dynamic Stars
        const starsContainer = document.getElementById('stars');
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
    </script>
</body>
</html>
