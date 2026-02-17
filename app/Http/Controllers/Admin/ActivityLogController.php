<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with('causer')
            ->when($request->get('log_name'), fn($q, $val) => $q->where('log_name', $val))
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.activity_log.index', compact('logs'));
    }
}