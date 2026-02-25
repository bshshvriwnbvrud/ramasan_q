{{-- resources/views/admin/messages/index.blade.php --}}
@extends('layouts.app')

@section('title', 'الاستفسارات - قائمة المستخدمين')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4" data-aos="fade-down">
        <h2 class="fw-bold mb-0" style="font-family: 'Amiri', serif; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
            <i class="bi bi-chat-dots-fill me-2" style="color: var(--primary-gold);"></i>الاستفسارات
        </h2>
        <span class="badge bg-warning text-dark me-3 px-3 py-2 rounded-pill">قائمة المحادثات</span>
    </div>

    <div class="card glass-card border-0" data-aos="fade-up">
        <div class="card-body p-0 p-md-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="sticky-top" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(5px);">
                        <tr>
                            <th class="text-white-50">المستخدم</th>
                            <th class="text-white-50">آخر نشاط</th>
                            <th class="text-white-50">غير مقروء</th>
                            <th class="text-white-50"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff&size=40" class="rounded-circle me-2" width="40" height="40" alt="{{ $user->name }}">
                                        <div>
                                            <span class="text-white fw-bold">{{ $user->name }}</span>
                                            <br>
                                            <small class="text-white-50">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $lastMsg = App\Models\Message::where(function($q) use ($user) {
                                            $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
                                        })->latest()->first();
                                    @endphp
                                    @if($lastMsg)
                                        <span class="text-white-50" data-bs-toggle="tooltip" title="{{ $lastMsg->created_at->format('Y-m-d H:i:s') }}">
                                            {{ $lastMsg->created_at->diffForHumans() }}
                                        </span>
                                    @else
                                        <span class="text-white-50">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->unread_count > 0)
                                        <span class="badge bg-danger rounded-pill px-3 py-2">{{ $user->unread_count }}</span>
                                    @else
                                        <span class="text-white-50">0</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.messages.conversation', $user) }}" class="btn btn-primary-gold btn-sm">
                                        <i class="bi bi-chat-text me-1"></i>عرض المحادثة
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-3" style="color: var(--primary-gold);"></i>
                                    <h5 class="text-white-50">لا توجد أي محادثات بعد</h5>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        overflow: hidden;
    }

    .table {
        --bs-table-color: white;
        --bs-table-bg: transparent;
        --bs-table-border-color: rgba(255,255,255,0.1);
        --bs-table-striped-bg: rgba(255,255,255,0.05);
        --bs-table-hover-bg: rgba(247, 183, 49, 0.1);
    }

    .table th, .table td {
        padding: 1rem 0.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .btn-primary-gold {
        background: linear-gradient(135deg, var(--primary-gold), #d49a1e);
        color: var(--dark-blue) !important;
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-primary-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(212, 154, 30, 0.4);
    }

    .text-white-50 {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    /* شريط تمرير مخصص */
    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: var(--primary-gold);
        border-radius: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // تفعيل tooltips
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(el => new bootstrap.Tooltip(el));
    });
</script>
@endpush