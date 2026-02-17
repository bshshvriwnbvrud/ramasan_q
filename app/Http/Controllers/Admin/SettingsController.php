<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        $autoApprove = Setting::where('key', 'auto_approve_enabled')->value('value') === '1';
        return view('admin.settings', compact('autoApprove'));
    }

    public function update(Request $request)
    {
        $enabled = $request->has('auto_approve_enabled') ? '1' : '0';

        Setting::updateOrCreate(
            ['key' => 'auto_approve_enabled'],
            ['value' => $enabled]
        );

        return back()->with('ok', 'تم حفظ الإعدادات');
    }
}