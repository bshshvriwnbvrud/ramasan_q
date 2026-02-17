@extends('layouts.app')

@section('title', 'إعدادات النظام')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    <h2 class="fw-bold mb-4"><i class="bi bi-gear-fill me-2"></i>إعدادات النظام</h2>

    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch"
                           id="auto_approve_enabled" name="auto_approve_enabled"
                           {{ $autoApprove ? 'checked' : '' }}>
                    <label class="form-check-label fw-medium" for="auto_approve_enabled">
                        تفعيل القبول التلقائي
                    </label>
                    <div class="form-text">إذا كان مفعلاً، أي طالب يسجل يتم قبوله مباشرة. إذا كان معطلاً، يصبح قيد المراجعة.</div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>حفظ الإعدادات
                </button>
            </form>
        </div>
    </div>
</div>
@endsection