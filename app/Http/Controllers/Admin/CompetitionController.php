<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompetitionController extends Controller
{
    public function index()
    {
        $competitions = Competition::orderBy('day_number')->get();
        return view('admin.competitions.index', compact('competitions'));
    }

    public function create()
    {
        return view('admin.competitions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'day_number' => ['required', 'integer', 'min:1', 'max:30', 'unique:competitions,day_number'],
            'title' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'timer_mode' => ['nullable', 'in:uniform,per_question'],
            'uniform_time_sec' => ['nullable', 'integer', 'min:5'],
            'personality_name' => ['nullable', 'string', 'max:255'],
            'personality_description' => ['nullable', 'string'],
            'personality_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'personality_enabled' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('personality_image')) {
            $validated['personality_image'] = $request->file('personality_image')->store('personalities', 'public');
        }

        $validated['is_published'] = false;
        $validated['timer_mode'] = $validated['timer_mode'] ?? 'uniform';
        $validated['uniform_time_sec'] = $validated['uniform_time_sec'] ?? 30;
        $validated['personality_enabled'] = $request->has('personality_enabled');

        Competition::create($validated);

        ActivityLog::create([
            'log_name' => 'competitions',
            'description' => 'أضاف يوم جديد: ' . $validated['day_number'],
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
        ]);

        return redirect()->route('admin.competitions')->with('ok', 'تم إنشاء اليوم بنجاح');
    }

    public function edit(Competition $competition)
    {
        return view('admin.competitions.edit', compact('competition'));
    }

    public function update(Request $request, Competition $competition)
    {
        $validated = $request->validate([
            'day_number' => ['required', 'integer', 'min:1', 'max:30', 'unique:competitions,day_number,' . $competition->id],
            'title' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'timer_mode' => ['nullable', 'in:uniform,per_question'],
            'uniform_time_sec' => ['nullable', 'integer', 'min:5'],
            'personality_name' => ['nullable', 'string', 'max:255'],
            'personality_description' => ['nullable', 'string'],
            'personality_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'personality_enabled' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('personality_image')) {
            if ($competition->personality_image) {
                Storage::disk('public')->delete($competition->personality_image);
            }
            $validated['personality_image'] = $request->file('personality_image')->store('personalities', 'public');
        }

        $validated['timer_mode'] = $validated['timer_mode'] ?? 'uniform';
        $validated['uniform_time_sec'] = $validated['uniform_time_sec'] ?? 30;
        $validated['personality_enabled'] = $request->has('personality_enabled');

        $competition->update($validated);

        ActivityLog::create([
            'log_name' => 'competitions',
            'description' => 'عدل اليوم: ' . $competition->day_number,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
        ]);

        return redirect()->route('admin.competitions')->with('ok', 'تم تحديث اليوم بنجاح');
    }

    public function toggle(Competition $competition)
    {
        $competition->update([
            'is_published' => !$competition->is_published
        ]);

        return back()->with('ok', 'تم تحديث حالة النشر');
    }
}