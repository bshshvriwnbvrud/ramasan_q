<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل جديد - مسابقة رمضان</title>
    <!-- Bootstrap Icons & RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts - Tajawal -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* خلفية متحركة - نجوم وهلال */
        .stars, .twinkling, .clouds {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            display: block;
        }

        .stars {
            background: #000 url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIj48Y2lyY2xlIGN4PSI2IiBjeT0iMTQiIHI9IjEiIGZpbGw9IndoaXRlIiAvPjxjaXJjbGUgY3g9IjE2MCIgY3k9IjYwIiByPSIxIiBmaWxsPSJ3aGl0ZSIgLz48Y2lyY2xlIGN4PSI0MCIgY3k9IjIxMCIgcj0iMSIgZmlsbD0id2hpdGUiIC8+PC9zdmc+');
            background-size: 200px 200px;
            animation: starsAnim 200s linear infinite;
            opacity: 0.5;
        }

        .twinkling {
            background: transparent url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIj48Y2lyY2xlIGN4PSIxMDAiIGN5PSI1MCIgcj0iMiIgZmlsbD0iI2ZmZmZmZiIgZmlsdGVyPSJ1cmwoI2ZpbHRlci1mYWRlKSIvPjwvc3ZnPg==');
            background-size: 200px 200px;
            animation: twinklingAnim 4s linear infinite;
            opacity: 0.5;
        }

        @keyframes starsAnim {
            from { transform: translateY(0px); }
            to { transform: translateY(-2000px); }
        }

        @keyframes twinklingAnim {
            0% { opacity: 0.2; }
            50% { opacity: 0.8; }
            100% { opacity: 0.2; }
        }

        /* فانوس متحرك */
        .lantern {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 60px;
            height: 80px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23f7b731"><path d="M12 2C8 2 4 5 4 9c0 4 8 13 8 13s8-9 8-13c0-4-4-7-8-7z"/></svg>') no-repeat center;
            background-size: contain;
            animation: swing 3s infinite ease-in-out;
            filter: drop-shadow(0 0 10px rgba(247, 183, 49, 0.5));
            z-index: 10;
        }

        .lantern.right {
            left: auto;
            right: 20px;
            transform: scaleX(-1);
        }

        @keyframes swing {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
            100% { transform: rotate(0deg); }
        }

        /* بطاقة التسجيل */
        .register-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 40px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            width: 100%;
            max-width: 600px;
            margin: 20px;
            position: relative;
            z-index: 20;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h3 {
            font-weight: 900;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }

        h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #f7b731, transparent);
            border-radius: 3px;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating input {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            color: white;
            padding: 1rem 1.5rem;
            height: auto;
            transition: all 0.3s;
        }

        .form-floating input:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: #f7b731;
            box-shadow: 0 0 15px rgba(247, 183, 49, 0.5);
            outline: none;
        }

        .form-floating input::placeholder {
            color: rgba(255, 255, 255, 0.7);
            opacity: 1;
        }

        .form-floating label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            padding-right: 1.5rem;
        }

        .form-floating input:focus ~ label,
        .form-floating input:not(:placeholder-shown) ~ label {
            transform: scale(0.85) translateY(-1.5rem) translateX(0.15rem);
            color: #f7b731;
        }

        .btn-register {
            background: #f7b731;
            color: #1e3c72;
            border: none;
            border-radius: 50px;
            padding: 0.9rem 2rem;
            font-weight: 700;
            font-size: 1.2rem;
            width: 100%;
            transition: all 0.3s;
            margin-top: 1rem;
            box-shadow: 0 5px 15px rgba(247, 183, 49, 0.3);
        }

        .btn-register:hover {
            background: #ffd966;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(247, 183, 49, 0.5);
        }

        .btn-register i {
            margin-left: 8px;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .login-link a {
            color: #f7b731;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-link a:hover {
            color: #ffd966;
            text-decoration: underline;
        }

        .error-message {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            border-radius: 30px;
            color: white;
            padding: 0.8rem 1.5rem;
            margin-bottom: 1.5rem;
            list-style-type: none;
        }

        .error-message ul {
            margin: 0;
            padding: 0;
        }

        .error-message li {
            list-style: none;
        }

        /* استجابة للهواتف */
        @media (max-width: 576px) {
            .register-card {
                padding: 1.8rem;
                margin: 15px;
            }
            h3 {
                font-size: 1.8rem;
            }
            .btn-register {
                font-size: 1rem;
                padding: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- خلفية متحركة -->
    <div class="stars"></div>
    <div class="twinkling"></div>
    <!-- فوانيس -->
    <div class="lantern"></div>
    <div class="lantern right"></div>

    <div class="register-card">
        <h3 class="text-center">
            <i class="bi bi-person-plus-fill me-2"></i>تسجيل جديد
        </h3>

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="form-floating">
                <input type="text" name="name" class="form-control" id="name" placeholder="الاسم" value="{{ old('name') }}" required>
                <label for="name"><i class="bi bi-person-fill ms-2"></i>الاسم</label>
            </div>

            <div class="form-floating">
                <input type="email" name="email" class="form-control" id="email" placeholder="البريد الإلكتروني" value="{{ old('email') }}" required>
                <label for="email"><i class="bi bi-envelope-fill ms-2"></i>البريد الإلكتروني</label>
            </div>

            <div class="form-floating">
                <input type="text" name="phone" class="form-control" id="phone" placeholder="رقم الهاتف" value="{{ old('phone') }}" required>
                <label for="phone"><i class="bi bi-telephone-fill ms-2"></i>رقم الهاتف</label>
            </div>

            <div class="form-floating">
                <input type="text" name="major" class="form-control" id="major" placeholder="التخصص (اختياري)" value="{{ old('major') }}">
                <label for="major"><i class="bi bi-book-fill ms-2"></i>التخصص (اختياري)</label>
            </div>

            <div class="form-floating">
                <input type="text" name="student_no" class="form-control" id="student_no" placeholder="رقم القيد (اختياري)" value="{{ old('student_no') }}">
                <label for="student_no"><i class="bi bi-upc-scan ms-2"></i>رقم القيد (اختياري)</label>
            </div>

            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="password" placeholder="كلمة المرور" required>
                <label for="password"><i class="bi bi-lock-fill ms-2"></i>كلمة المرور</label>
            </div>

            <div class="form-floating">
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="تأكيد كلمة المرور" required>
                <label for="password_confirmation"><i class="bi bi-lock-fill ms-2"></i>تأكيد كلمة المرور</label>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-check-circle"></i>تسجيل
            </button>

            <div class="login-link">
                لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل دخول</a>
            </div>
        </form>
    </div>
</body>
</html>