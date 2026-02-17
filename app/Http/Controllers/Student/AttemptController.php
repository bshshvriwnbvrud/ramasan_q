<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use App\Models\AttemptAnswer;
use App\Models\Competition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AttemptController extends Controller
{
    public function start(Competition $competition, Request $request)
    {
        $user = $request->user();
        $now = now();

        if (!$competition->is_published) {
            abort(404);
        }

        if (!($now->between($competition->starts_at, $competition->ends_at))) {
            return back()->with('err', 'المسابقة غير متاحة الآن');
        }

        $attempt = Attempt::where('competition_id', $competition->id)
            ->where('user_id', $user->id)
            ->first();

        if ($attempt && $attempt->status !== 'in_progress') {
            return redirect()->route('attempt.result', $attempt);
        }

        if (!$attempt) {
            $attempt = DB::transaction(function () use ($competition, $user, $request) {
                $a = Attempt::create([
                    'user_id' => $user->id,
                    'competition_id' => $competition->id,
                    'status' => 'in_progress',
                    'started_at' => now(),
                    'current_index' => 1,
                    'current_question_started_at' => now(),
                    'ip_address' => $request->ip(),
                    'user_agent' => substr((string)$request->userAgent(), 0, 1000),
                ]);

                // جلب جميع أسئلة المسابقة مرتبة حسب sort_order الأصلي
                $allQuestions = $competition->questions()->get();

                // فصل الأسئلة إلى عادية وشخصية
                $normalQuestions = $allQuestions->filter(fn($q) => !$q->is_personality);
                $personalityQuestions = $allQuestions->filter(fn($q) => $q->is_personality);

                // ترتيب الأسئلة: العادية أولاً (حسب sort_order)، ثم الشخصية (حسب sort_order فيما بينها)
                $orderedQuestions = $normalQuestions->values()->merge($personalityQuestions->values());

                $i = 1;
                foreach ($orderedQuestions as $q) {
                    AttemptAnswer::create([
                        'attempt_id' => $a->id,
                        'question_id' => $q->id,
                        'question_index' => $i,
                        'selected_choice' => null,
                        'is_correct' => false,
                        'was_late' => false,
                        'answered_at' => null,
                    ]);
                    $i++;
                }

                return $a;
            });
        }

        return redirect()->route('attempt.show', $attempt);
    }

    public function show(Attempt $attempt, Request $request)
    {
        $user = $request->user();
        if ($attempt->user_id !== $user->id) abort(403);

        $attempt->load('competition');
        $competition = $attempt->competition;
        $now = now();

        if ($now->gt($competition->ends_at) && $attempt->status === 'in_progress') {
            $this->finalizeAttempt($attempt, 'timeout');
            return redirect()->route('attempt.result', $attempt);
        }

        if ($attempt->status !== 'in_progress') {
            return redirect()->route('attempt.result', $attempt);
        }

        // عدد الأسئلة بناءً على عدد سجلات AttemptAnswer لهذه المحاولة
        $total = $attempt->answers()->count();

        if ($attempt->current_index > $total) {
            $this->finalizeAttempt($attempt, 'submitted');
            return redirect()->route('attempt.result', $attempt);
        }

        // جلب السؤال الحالي باستخدام الـ question_index المخزن
        $answer = AttemptAnswer::where('attempt_id', $attempt->id)
            ->where('question_index', $attempt->current_index)
            ->first();

        if (!$answer) {
            // هذا لا يجب أن يحدث، ولكن للسلامة
            return redirect()->route('attempt.result', $attempt)->with('error', 'حدث خطأ في ترتيب الأسئلة');
        }

        $question = $answer->question; // تأكد من وجود علاقة question في موديل AttemptAnswer
        if (!$question) {
            $this->finalizeAttempt($attempt, 'submitted');
            return redirect()->route('attempt.result', $attempt);
        }

        $sec = $this->questionTimeSec($competition, $question);

        $startedAt = $attempt->current_question_started_at ?? $attempt->started_at ?? now();
        $elapsed = $startedAt->diffInSeconds($now);
        $remaining = $sec - $elapsed;

        if ($remaining <= 0) {
            $this->markBlankAndNext($attempt, $question->id);
            return redirect()->route('attempt.show', $attempt);
        }

        $showAnswer = !is_null($answer->selected_choice) || $answer->was_late;
        $isCorrect = $answer->is_correct;

        // تحديد إذا كان هذا السؤال هو سؤال شخصية (بناءً على حقل is_personality في جدول questions)
        $isPersonality = (bool)$question->is_personality;

        // تجهيز بيانات الشخصية من السؤال نفسه
        $personalityData = null;
        if ($isPersonality && $question->personality_name) {
            $personalityData = [
                'name' => $question->personality_name,
                'description' => $question->personality_description,
                'image' => $question->personality_image ? Storage::url($question->personality_image) : null,
            ];
        }

        return view('student.attempt', [
            'attempt' => $attempt,
            'competition' => $competition,
            'question' => $question,
            'current' => $attempt->current_index,
            'total' => $total,
            'remaining' => $remaining,
            'isPersonality' => $isPersonality,
            'showAnswer' => $showAnswer,
            'isCorrect' => $isCorrect,
            'personality' => $personalityData,
        ]);
    }

    public function answer(Attempt $attempt, Request $request)
    {
        $user = $request->user();
        if ($attempt->user_id !== $user->id) abort(403);

        $attempt->load('competition');
        $competition = $attempt->competition;

        if ($attempt->status !== 'in_progress') {
            return redirect()->route('attempt.result', $attempt);
        }

        $total = $attempt->answers()->count();
        if ($attempt->current_index > $total) {
            $this->finalizeAttempt($attempt, 'submitted');
            return redirect()->route('attempt.result', $attempt);
        }

        $answer = AttemptAnswer::where('attempt_id', $attempt->id)
            ->where('question_index', $attempt->current_index)
            ->first();

        if (!$answer) {
            return redirect()->route('attempt.result', $attempt)->with('error', 'خطأ في الإجابة');
        }

        $question = $answer->question;

        $validated = $request->validate([
            'selected_choice' => ['required', 'in:A,B,C,D'],
            'confirm' => ['required', 'in:yes'],
        ]);

        $sec = $this->questionTimeSec($competition, $question);
        $startedAt = $attempt->current_question_started_at ?? $attempt->started_at ?? now();
        $elapsed = $startedAt->diffInSeconds(now());
        if ($elapsed >= $sec) {
            $this->markBlankAndNext($attempt, $question->id);
            return redirect()->route('attempt.show', $attempt);
        }

        $isCorrect = ($validated['selected_choice'] === $question->correct_choice);

        // تحديث الإجابة
        $answer->update([
            'selected_choice' => $validated['selected_choice'],
            'is_correct' => $isCorrect,
            'was_late' => false,
            'answered_at' => now(),
        ]);

        $attempt->update([
            'current_index' => $attempt->current_index + 1,
            'current_question_started_at' => now(),
        ]);

        return redirect()->route('attempt.show', $attempt);
    }

    public function result(Attempt $attempt, Request $request)
    {
        $user = $request->user();
        if ($attempt->user_id !== $user->id) abort(403);

        $attempt->load('competition');

        if ($attempt->status === 'in_progress') {
            return redirect()->route('attempt.show', $attempt);
        }

        $competition = $attempt->competition;
        $personality = null;
        if ($competition->personality_enabled && $competition->personality_image) {
            $personality = [
                'name' => $competition->personality_name,
                'description' => $competition->personality_description,
                'image' => Storage::url($competition->personality_image),
            ];
        }

        return view('student.result', compact('attempt', 'personality'));
    }

    private function questionTimeSec($competition, $question): int
    {
        if ($competition->timer_mode === 'per_question') {
            return (int) ($question->time_sec ?? 30);
        }
        return (int) ($competition->uniform_time_sec ?? 30);
    }

    private function markBlankAndNext(Attempt $attempt, int $questionId): void
    {
        AttemptAnswer::where('attempt_id', $attempt->id)
            ->where('question_index', $attempt->current_index)
            ->update([
                'selected_choice' => null,
                'is_correct' => false,
                'was_late' => true,
                'answered_at' => null,
            ]);

        $attempt->update([
            'current_index' => $attempt->current_index + 1,
            'current_question_started_at' => now(),
        ]);
    }

    private function finalizeAttempt(Attempt $attempt, string $status): void
    {
        $answers = $attempt->answers()->get();

        $correct = $answers->where('is_correct', true)->count();
        $blank = $answers->whereNull('selected_choice')->count();
        $wrong = $answers->count() - $correct - $blank;

        $attempt->update([
            'status' => $status,
            'submitted_at' => now(),
            'score' => $correct,
            'correct_count' => $correct,
            'wrong_count' => $wrong,
            'blank_count' => $blank,
        ]);
    }

    public function resetForUser(Competition $competition, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        Attempt::where('competition_id', $competition->id)
            ->where('user_id', $user->id)
            ->delete();

        activity()->causedBy(auth()->user())
            ->performedOn($competition)
            ->log('أعاد فتح الاختبار للمستخدم ' . $user->id);

        return redirect()->route('admin.competitions.attempts', $competition)
            ->with('success', 'تم إعادة فتح الاختبار للمستخدم.');
    }
}