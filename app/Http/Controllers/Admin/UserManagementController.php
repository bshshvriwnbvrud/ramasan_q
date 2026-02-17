<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));

        // جميع المستخدمين (كل الأدوار) مع التصفية
        $pending = User::query()
            ->where('status', 'pending')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%")
                    ->orWhere('student_no', 'like', "%$q%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $approved = User::query()
            ->where('status', 'approved')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%")
                    ->orWhere('student_no', 'like', "%$q%");
                });
            })
            ->orderBy('approved_at', 'desc')
            ->paginate(20, ['*'], 'approved_page');

        $rejected = User::query()
            ->where('status', 'rejected')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%")
                    ->orWhere('student_no', 'like', "%$q%");
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(20, ['*'], 'rejected_page');

        return view('admin.users.index', compact('pending', 'approved', 'rejected', 'q'));
    }
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'major' => 'nullable|string|max:255',
            'student_no' => 'nullable|string|max:50|unique:users,student_no',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,supervisor,editor,student',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'phone' => $validated['phone'],
            'major' => $validated['major'] ?? null,
            'student_no' => $validated['student_no'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
            'approved_at' => $validated['status'] === 'approved' ? now() : null,
        ]);

        ActivityLog::create([
            'log_name' => 'users',
            'description' => 'أضاف مستخدم جديد: ' . $user->name,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'properties' => ['user_id' => $user->id],
        ]);

        return redirect()->route('admin.users')->with('success', 'تم إضافة المستخدم بنجاح.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'major' => 'nullable|string|max:255',
            'student_no' => 'nullable|string|max:50|unique:users,student_no,' . $user->id,
            'role' => 'required|in:admin,supervisor,editor,student',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $oldData = $user->only(['name', 'email', 'phone', 'major', 'student_no', 'role', 'status']);

        $user->update($validated);

        if ($validated['status'] === 'approved' && $oldData['status'] !== 'approved') {
            $user->update(['approved_at' => now()]);
        }

        ActivityLog::create([
            'log_name' => 'users',
            'description' => 'عدل بيانات المستخدم: ' . $user->name,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'properties' => [
                'old' => $oldData,
                'new' => $validated,
            ],
        ]);

        return redirect()->route('admin.users')->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    public function approve(User $user)
    {
        if ($user->role !== 'student') return back();

        $user->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        ActivityLog::create([
            'log_name' => 'users',
            'description' => 'قبل المستخدم: ' . $user->name,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
        ]);

        return back()->with('ok', 'تم قبول المستخدم');
    }

    public function reject(User $user)
    {
        if ($user->role !== 'student') return back();

        $user->update([
            'status' => 'rejected',
            'approved_at' => null,
        ]);

        ActivityLog::create([
            'log_name' => 'users',
            'description' => 'رفض المستخدم: ' . $user->name,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
        ]);

        return back()->with('ok', 'تم رفض المستخدم');
    }
}