<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>قيد المراجعة</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
  <div class="container py-5" style="max-width: 720px;">
    <div class="card p-4 shadow-sm">
      <h3 class="mb-2">حسابك قيد المراجعة ⏳</h3>
      <p class="text-muted mb-4">تم استلام بياناتك، وسيتم قبول حسابك من الإدارة قريبًا.</p>

      <div class="small text-muted">
        بياناتك:
        <div>الاسم: <b>{{ auth()->user()->name }}</b></div>
        <div>الإيميل: <b>{{ auth()->user()->email }}</b></div>
        <div>الهاتف: <b>{{ auth()->user()->phone }}</b></div>
        <div>رقم القيد: <b>{{ auth()->user()->student_no ?? '—' }}</b></div>
      </div>

      <form class="mt-4" method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-dark">تسجيل خروج</button>
      </form>
    </div>
  </div>
</body>
</html>