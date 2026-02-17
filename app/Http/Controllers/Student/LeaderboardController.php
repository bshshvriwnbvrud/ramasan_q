<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Winner;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $competitionId = $request->get('competition_id');
        $competition = Competition::find($competitionId);

        // نعرض الفائزين إذا كانت النتائج منشورة فقط
        $winners = collect();
        if ($competition && $competition->results_published) {
            $winners = Winner::where('competition_id', $competitionId)
                ->with('user')
                ->orderBy('rank')
                ->get();
        }

        return view('student.leaderboard', compact('competition', 'winners'));
    }
}