<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\User;
use App\Models\Attempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'student')->count();
        $pendingUsers = User::where('status', 'pending')->count();
        $totalCompetitions = Competition::count();
        $totalAttempts = Attempt::count();

        // آخر 10 محاولات مكتملة
        $recentAttempts = Attempt::with(['user', 'competition'])
            ->where('status', 'submitted')
            ->orderBy('submitted_at', 'desc')
            ->limit(10)
            ->get();

        // الطلاب الذين يختبرون الآن (آخر 10 دقائق)
        $nowTesting = Attempt::with(['user', 'competition'])
            ->where('status', 'in_progress')
            ->where('started_at', '>=', now()->subMinutes(10))
            ->orderBy('started_at', 'desc')
            ->get();

        // إحصائيات كل يوم
        $dailyStats = Competition::select('id', 'day_number', 'title')
            ->withCount('attempts')
            ->orderBy('day_number')
            ->get();

        // أفضل النتائج لليوم الحالي إن وجد
        $todayCompetition = Competition::whereDate('starts_at', '<=', now())
            ->whereDate('ends_at', '>=', now())
            ->first();

        $topScores = [];
        if ($todayCompetition) {
            $topScores = Attempt::where('competition_id', $todayCompetition->id)
                ->where('status', 'submitted')
                ->orderBy('score', 'desc')
                ->orderBy('submitted_at', 'asc')
                ->with('user')
                ->take(10)
                ->get();
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'pendingUsers',
            'totalCompetitions',
            'totalAttempts',
            'recentAttempts',
            'nowTesting',
            'dailyStats',
            'todayCompetition',
            'topScores'
        ));
    }
}