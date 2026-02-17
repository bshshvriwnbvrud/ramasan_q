<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileEditRequest;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ProfileRequestController extends Controller
{
    public function index()
    {
        $requests = ProfileEditRequest::with(['user', 'processor'])
            ->orderByRaw("FIELD(status, 'pending') DESC")
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.profile_requests.index', compact('requests'));
    }

    public function show(ProfileEditRequest $profileRequest)
    {
        $profileRequest->load(['user', 'processor']);
        return view('admin.profile_requests.show', compact('profileRequest'));
    }

    public function approve(ProfileEditRequest $profileRequest)
    {
        if ($profileRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'هذا الطلب تم معالجته مسبقاً.');
        }

        $user = $profileRequest->user;

        // تحديث بيانات المستخدم
        $user->update($profileRequest->new_data);

        // تحديث حالة الطلب
        $profileRequest->update([
            'status' => 'approved',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        // تسجيل النشاط
        ActivityLog::create([
            'log_name' => 'profile_requests',
            'description' => 'وافق على طلب تعديل بيانات المستخدم ' . $user->name,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'properties' => ['request_id' => $profileRequest->id],
        ]);

        return redirect()->route('admin.profile_requests.index')
            ->with('success', 'تمت الموافقة على طلب التعديل.');
    }

    public function reject(Request $request, ProfileEditRequest $profileRequest)
    {
        if ($profileRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'هذا الطلب تم معالجته مسبقاً.');
        }

        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $profileRequest->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note,
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        ActivityLog::create([
            'log_name' => 'profile_requests',
            'description' => 'رفض طلب تعديل بيانات المستخدم ' . $profileRequest->user->name,
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'properties' => ['request_id' => $profileRequest->id],
        ]);

        return redirect()->route('admin.profile_requests.index')
            ->with('success', 'تم رفض الطلب.');
    }
}