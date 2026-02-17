<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Winner;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class WinnerController extends Controller
{
    public function index(Competition $competition)
    {
        $winners = $competition->winners()->with('user')->orderBy('rank')->get();
        return view('admin.winners.index', compact('competition', 'winners'));
    }

    /**
     * عرض صفحة اختيار الفائزين يدويًا (جميع المحاولات مرتبة)
     */
    public function select(Competition $competition)
    {
        // جلب جميع المحاولات المكتملة مرتبة حسب الدرجة (تنازلي) ثم وقت الإنهاء (تصاعدي)
        $attempts = $competition->attempts()
            ->where('status', 'submitted')
            ->with('user')
            ->orderBy('score', 'desc')
            ->orderBy('submitted_at', 'asc')
            ->get();

        return view('admin.winners.select', compact('competition', 'attempts'));
    }

    public function store(Request $request, Competition $competition)
    {
        $request->validate([
            'winners' => 'required|array|min:1',
            'winners.*.user_id' => 'required|exists:users,id',
            'winners.*.rank' => 'required|integer|min:1|distinct',
            'winners.*.note' => 'nullable|string',
        ]);

        // حذف الفائزين السابقين لهذه المسابقة
        $competition->winners()->delete();

        foreach ($request->winners as $winnerData) {
            Winner::create([
                'competition_id' => $competition->id,
                'user_id' => $winnerData['user_id'],
                'rank' => $winnerData['rank'],
                'note' => $winnerData['note'] ?? null,
            ]);
        }

        ActivityLog::create([
            'log_name' => 'winners',
            'description' => 'حدد فائزي اليوم ' . $competition->day_number,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'properties' => ['competition_id' => $competition->id],
        ]);

        return redirect()->route('admin.competitions.winners.index', $competition)
            ->with('success', 'تم حفظ الفائزين بنجاح.');
    }

    public function publish(Competition $competition)
    {
        $competition->update(['results_published' => true]);

        ActivityLog::create([
            'log_name' => 'winners',
            'description' => 'نشر نتائج اليوم ' . $competition->day_number,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
        ]);

        return redirect()->route('admin.competitions.winners.index', $competition)
            ->with('success', 'تم نشر النتائج بنجاح.');
    }
}