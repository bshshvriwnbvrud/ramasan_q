<?php
// app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * عرض صفحة الدردشة للمستخدم العادي (مع الأدمن)
     */
    public function studentIndex()
    {
        $user = Auth::user();
        // نفترض أن الأدمن هو أول أدمن في النظام (يمكن تحسين ذلك)
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return redirect()->back()->with('error', 'لا يوجد أدمن للتواصل معه حالياً.');
        }

        // جلب الرسائل بين المستخدم والأدمن
        $messages = Message::where(function ($query) use ($user, $admin) {
            $query->where('sender_id', $user->id)->where('receiver_id', $admin->id);
        })->orWhere(function ($query) use ($user, $admin) {
            $query->where('sender_id', $admin->id)->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        // تحديث الرسائل الواردة كمقروءة
        Message::where('receiver_id', $user->id)
            ->where('sender_id', $admin->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('student.messages', compact('messages', 'admin'));
    }

    /**
     * إرسال رسالة جديدة (من المستخدم أو الأدمن)
     */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // إذا كان الطلب AJAX نعيد JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'time' => $message->created_at->format('h:i A'),
                ]
            ]);
        }

        return redirect()->back()->with('success', 'تم إرسال الرسالة.');
    }

    /**
     * استطلاع الرسائل الجديدة (Polling)
     */
    public function poll(Request $request)
    {
        $lastId = $request->get('last_id', 0);
        $user = Auth::user();
        $otherUserId = $request->get('user_id'); // للمحادثات الخاصة بالأدمن

        if ($user->role === 'admin' && $otherUserId) {
            // إذا كان الأدمن يتابع محادثة مع مستخدم معين
            $otherUser = User::find($otherUserId);
            if (!$otherUser) return response()->json(['messages' => []]);

            $messages = Message::where(function ($query) use ($user, $otherUser) {
                $query->where('sender_id', $user->id)->where('receiver_id', $otherUser->id);
            })->orWhere(function ($query) use ($user, $otherUser) {
                $query->where('sender_id', $otherUser->id)->where('receiver_id', $user->id);
            })
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();

            // تحديث القراءة
            Message::whereIn('id', $messages->pluck('id'))
                ->where('receiver_id', $user->id)
                ->where('sender_id', $otherUser->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } else {
            // نفس الكود القديم للطالب
            $admin = User::where('role', 'admin')->first();
            if (!$admin) return response()->json(['messages' => []]);
            $messages = Message::where(function ($query) use ($user, $admin) {
                $query->where('sender_id', $user->id)->where('receiver_id', $admin->id);
            })->orWhere(function ($query) use ($user, $admin) {
                $query->where('sender_id', $admin->id)->where('receiver_id', $user->id);
            })
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();

            Message::whereIn('id', $messages->pluck('id'))
                ->where('receiver_id', $user->id)
                ->where('sender_id', $admin->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        $formatted = $messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'message' => $msg->message,
                'sender_id' => $msg->sender_id,
                'time' => $msg->created_at->format('h:i A'),
            ];
        });

        return response()->json(['messages' => $formatted]);
    }

    /**
     * عرض قائمة المستخدمين الذين لديهم محادثات للأدمن
     */
    public function adminIndex()
    {
        $admin = Auth::user();

        // جلب جميع المستخدمين الذين أرسلوا رسائل لهذا الأدمن (أو استلموا منه)
        $userIds = Message::where('sender_id', $admin->id)
            ->orWhere('receiver_id', $admin->id)
            ->pluck('sender_id')
            ->merge(Message::where('receiver_id', $admin->id)->pluck('sender_id'))
            ->merge(Message::where('sender_id', $admin->id)->pluck('receiver_id'))
            ->unique()
            ->filter(fn($id) => $id != $admin->id);

        $users = User::whereIn('id', $userIds)->get();

        // حساب عدد الرسائل غير المقروءة لكل مستخدم
        foreach ($users as $user) {
            $user->unread_count = Message::where('sender_id', $user->id)
                ->where('receiver_id', $admin->id)
                ->where('is_read', false)
                ->count();
        }

        return view('admin.messages.index', compact('users'));
    }

    /**
     * عرض محادثة مع مستخدم معين للأدمن
     */
    public function adminConversation(User $user)
    {
        $admin = Auth::user();

        // جلب الرسائل بين الأدمن وهذا المستخدم
        $messages = Message::where(function ($query) use ($user, $admin) {
            $query->where('sender_id', $user->id)->where('receiver_id', $admin->id);
        })->orWhere(function ($query) use ($user, $admin) {
            $query->where('sender_id', $admin->id)->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        // تحديث الرسائل غير المقروءة
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $admin->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('admin.messages.conversation', compact('messages', 'user'));
    }
}