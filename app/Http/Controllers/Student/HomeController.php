<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Winner;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $now = now();

        $days = Competition::query()
            ->where('is_published', true)
            ->orderBy('day_number')
            ->get()
            ->map(function ($c) use ($now) {
                $status = 'upcoming';

                if ($now->between($c->starts_at, $c->ends_at)) {
                    $status = 'open';
                } elseif ($now->gt($c->ends_at)) {
                    $status = 'closed';
                }

                return [
                    'id' => $c->id,
                    'day_number' => $c->day_number,
                    'title' => $c->title,
                    'starts_at' => $c->starts_at,
                    'ends_at' => $c->ends_at,
                    'status' => $status,
                    'results_published' => (bool) $c->results_published,
                ];
            });

        return view('student.home', compact('days'));
    }
}