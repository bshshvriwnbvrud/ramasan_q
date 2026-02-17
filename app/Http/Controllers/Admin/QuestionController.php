<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Competition;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionsImport;
use App\Exports\QuestionsExport;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $competitionId = $request->get('competition_id');
        $competitions = Competition::orderBy('day_number')->get();

        $questions = Question::when($competitionId, function ($query) use ($competitionId) {
            return $query->whereHas('competitions', fn($q) => $q->where('competition_id', $competitionId));
        })->paginate(20);

        return view('admin.questions.index', compact('questions', 'competitions', 'competitionId'));
    }

    public function create()
    {
        $competitions = Competition::orderBy('day_number')->get();
        return view('admin.questions.create', compact('competitions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'choice_a' => 'required|string',
            'choice_b' => 'required|string',
            'choice_c' => 'required|string',
            'choice_d' => 'required|string',
            'correct_choice' => 'required|in:A,B,C,D',
            'time_sec' => 'nullable|integer|min:5',
            'is_personality' => 'sometimes|boolean',
            'personality_name' => 'required_if:is_personality,true|nullable|string|max:255',
            'personality_description' => 'required_if:is_personality,true|nullable|string',
            'personality_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'competitions' => 'nullable|array',
            'competitions.*' => 'exists:competitions,id',
        ]);

        if ($request->hasFile('personality_image')) {
            $validated['personality_image'] = $request->file('personality_image')->store('personalities', 'public');
        }

        $question = Question::create($validated);

        if ($request->has('competitions')) {
            $syncData = [];
            foreach ($request->competitions as $index => $compId) {
                $syncData[$compId] = ['sort_order' => $index + 1];
            }
            $question->competitions()->sync($syncData);
        }

        ActivityLog::create([
            'log_name' => 'questions',
            'description' => 'أضاف سؤال جديد: ' . $question->id,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'properties' => ['question_id' => $question->id],
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'تم إضافة السؤال بنجاح.');
    }

    public function edit(Question $question)
    {
        $competitions = Competition::orderBy('day_number')->get();
        $selectedCompetitions = $question->competitions->pluck('id')->toArray();
        return view('admin.questions.edit', compact('question', 'competitions', 'selectedCompetitions'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'choice_a' => 'required|string',
            'choice_b' => 'required|string',
            'choice_c' => 'required|string',
            'choice_d' => 'required|string',
            'correct_choice' => 'required|in:A,B,C,D',
            'time_sec' => 'nullable|integer|min:5',
            'is_personality' => 'sometimes|boolean',
            'personality_name' => 'required_if:is_personality,true|nullable|string|max:255',
            'personality_description' => 'required_if:is_personality,true|nullable|string',
            'personality_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'competitions' => 'nullable|array',
            'competitions.*' => 'exists:competitions,id',
        ]);

        if ($request->hasFile('personality_image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($question->personality_image) {
                Storage::disk('public')->delete($question->personality_image);
            }
            $validated['personality_image'] = $request->file('personality_image')->store('personalities', 'public');
        }

        $question->update($validated);

        if ($request->has('competitions')) {
            $syncData = [];
            foreach ($request->competitions as $index => $compId) {
                $syncData[$compId] = ['sort_order' => $index + 1];
            }
            $question->competitions()->sync($syncData);
        } else {
            $question->competitions()->sync([]);
        }

        ActivityLog::create([
            'log_name' => 'questions',
            'description' => 'عدل سؤال: ' . $question->id,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'properties' => ['question_id' => $question->id],
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'تم تحديث السؤال بنجاح.');
    }

    public function destroy(Question $question)
    {
        if ($question->personality_image) {
            Storage::disk('public')->delete($question->personality_image);
        }

        $question->delete();

        ActivityLog::create([
            'log_name' => 'questions',
            'description' => 'حذف سؤال: ' . $question->id,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'properties' => ['question_id' => $question->id],
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'تم حذف السؤال.');
    }

    public function importForm()
    {
        return view('admin.questions.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new QuestionsImport, $request->file('file'));

        ActivityLog::create([
            'log_name' => 'questions',
            'description' => 'استورد أسئلة من ملف',
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'properties' => ['file' => $request->file('file')->getClientOriginalName()],
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'تم استيراد الأسئلة بنجاح.');
    }

    public function export()
    {
        ActivityLog::create([
            'log_name' => 'questions',
            'description' => 'صدر الأسئلة إلى Excel',
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
        ]);

        return Excel::download(new QuestionsExport, 'questions.xlsx');
    }

    // استيراد إلى يوم محدد
    public function importToCompetitionForm()
    {
        $competitions = Competition::orderBy('day_number')->get();
        return view('admin.questions.import_to_competition', compact('competitions'));
    }

    public function importToCompetition(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'competition_id' => 'required|exists:competitions,id',
        ]);

        $competition = Competition::findOrFail($request->competition_id);

        $rows = Excel::toArray(new QuestionsImport, $request->file('file'));
        $rows = $rows[0] ?? [];

        $sortOrder = $competition->questions()->count() + 1;

        foreach ($rows as $row) {
            if (empty($row['text']) || empty($row['choice_a']) || empty($row['choice_b']) ||
                empty($row['choice_c']) || empty($row['choice_d']) || empty($row['correct_choice'])) {
                continue;
            }

            $question = Question::create([
                'text' => $row['text'],
                'choice_a' => $row['choice_a'],
                'choice_b' => $row['choice_b'],
                'choice_c' => $row['choice_c'],
                'choice_d' => $row['choice_d'],
                'correct_choice' => strtoupper($row['correct_choice']),
                'time_sec' => $row['time_sec'] ?? null,
                'is_personality' => false,
            ]);

            $competition->questions()->attach($question->id, ['sort_order' => $sortOrder++]);
        }

        ActivityLog::create([
            'log_name' => 'questions',
            'description' => 'استورد أسئلة لليوم ' . $competition->day_number,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'properties' => [
                'competition_id' => $competition->id,
                'file' => $request->file('file')->getClientOriginalName(),
            ],
        ]);

        return redirect()->route('admin.questions.index')
            ->with('success', 'تم استيراد الأسئلة وربطها باليوم ' . $competition->day_number . ' بنجاح.');
    }
}