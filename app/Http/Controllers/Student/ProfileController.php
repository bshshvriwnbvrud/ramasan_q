<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ProfileEditRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $pendingRequest = ProfileEditRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        return view('student.profile', compact('user', 'pendingRequest'));
    }

    public function edit()
    {
        $user = Auth::user();
        $pendingRequest = ProfileEditRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingRequest) {
            return redirect()->route('student.profile')
                ->with('error', 'لديك طلب تعديل قيد المراجعة بالفعل.');
        }

        return view('student.profile_edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'major' => 'nullable|string|max:255',
            'student_no' => 'nullable|string|max:50|unique:users,student_no,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // التحقق من وجود طلب سابق
        $existing = ProfileEditRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->route('student.profile')
                ->with('error', 'لديك طلب تعديل قيد المراجعة بالفعل.');
        }

        // إنشاء طلب تعديل جديد
        ProfileEditRequest::create([
            'user_id' => $user->id,
            'old_data' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'major' => $user->major,
                'student_no' => $user->student_no,
            ],
            'new_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'major' => $request->major,
                'student_no' => $request->student_no,
            ],
            'status' => 'pending',
        ]);

        return redirect()->route('student.profile')
            ->with('success', 'تم إرسال طلب التعديل بنجاح. بانتظار موافقة الإدارة.');
    }
}