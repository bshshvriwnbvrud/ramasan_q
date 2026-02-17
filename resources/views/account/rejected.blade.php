<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>مرفوض</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
  <div class="container py-5" style="max-width: 720px;">
    <div class="card p-4 shadow-sm">
      <h3 class="mb-2 text-danger">تم رفض الحساب ❌</h3>
      <p class="text-muted mb-4">إذا تعتقد أن هناك خطأ، تواصل مع الإدارة.</p>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-dark">تسجيل خروج</button>
      </form>
    </div>
  </div>
</body>
</html>