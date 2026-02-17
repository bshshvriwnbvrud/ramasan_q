<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AllowedStudent;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'major' => ['nullable', 'string', 'max:255'],
            'student_no' => ['nullable', 'string', 'max:50', 'unique:users,student_no'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $studentNo = $validated['student_no'] ?? null;

        // قراءة إعداد القبول التلقائي من قاعدة البيانات
        $autoApproveEnabled = Setting::where('key', 'auto_approve_enabled')->value('value');
        $autoApproveEnabled = ($autoApproveEnabled === null) ? true : ($autoApproveEnabled === '1');

        // القبول النهائي:
        // - إذا القبول التلقائي ON => approved مباشرة
        // - إذا OFF => pending
        // - لكن: إذا OFF والطالب كتب student_no موجود في allowed_students => approved
        $autoApproveByList = false;
        if (!$autoApproveEnabled && $studentNo) {
            $autoApproveByList = AllowedStudent::where('student_no', $studentNo)->exists();
        }

        $finalApproved = $autoApproveEnabled || $autoApproveByList;

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'phone' => $validated['phone'],
            'major' => $validated['major'] ?? null,
            'student_no' => $studentNo ?: null,

            'role' => 'student',
            'status' => $finalApproved ? 'approved' : 'pending',
            'approved_at' => $finalApproved ? now() : null,

            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        // بعد التسجيل، نوجه إلى صفحة الترحيب
        return redirect()->route('student.welcome');
        

        // // إذا Pending سيمنعه middleware "approved" من /home ويوجهه إلى /account/pending
        // return redirect()->route('home');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt([
            'email' => strtolower($credentials['email']),
            'password' => $credentials['password'],
        ])) {
            return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة'])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}