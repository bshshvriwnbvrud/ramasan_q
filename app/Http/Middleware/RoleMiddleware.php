<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // الأدمن لديه صلاحية الوصول لكل شيء
        if ($user->role === 'admin') {
            return $next($request);
        }

        // التحقق من أن دور المستخدم موجود في قائمة الأدوار المسموح بها
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة.');
    }
}