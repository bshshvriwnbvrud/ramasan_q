<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // لو مش مسجل دخول
        if (!$user) {
            return redirect()->route('login');
        }

        // الأدمن مسموح له دائمًا
        if ($user->role === 'admin') {
            return $next($request);
        }

        // الطالب لازم يكون approved
        if ($user->status === 'approved') {
            return $next($request);
        }

        if ($user->status === 'rejected') {
            return redirect()->route('account.rejected');
        }

        // pending
        return redirect()->route('account.pending');
    }
}