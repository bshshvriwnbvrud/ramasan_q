@extends('layouts.app')

@section('title', 'إدارة المستخدمين')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-people-fill me-2"></i>إدارة المستخدمين</h2>
        @if(auth()->user()->role == 'admin')
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>إضافة مستخدم جديد
            </a>
        @endif
    </div>

    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- شريط البحث والتبويبات -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form class="row g-3 mb-3" method="GET" action="{{ route('admin.users') }}">
                <div class="col-md-9">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input class="form-control" name="q" value="{{ $q ?? '' }}" placeholder="بحث: اسم / إيميل / هاتف / رقم قيد">
                    </div>
                </div>
                <div class="col-md-3 d-grid">
                    <button class="btn btn-primary" type="submit">بحث</button>
                </div>
            </form>

            <ul class="nav nav-tabs" id="userTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">قيد المراجعة</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">مقبولون</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab">مرفوضون</button>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
        <!-- Pending -->
        <div class="tab-pane fade show active" id="pending" role="tabpanel">
            @include('admin.users.partials.table', ['rows' => $pending ?? [], 'mode' => 'pending'])
            <div class="mt-3">{{ $pending->withQueryString()->links() ?? '' }}</div>
        </div>

        <!-- Approved -->
        <div class="tab-pane fade" id="approved" role="tabpanel">
            @include('admin.users.partials.table', ['rows' => $approved ?? [], 'mode' => 'approved'])
            <div class="mt-3">{{ $approved->withQueryString()->links('pagination::bootstrap-5') ?? '' }}</div>
        </div>

        <!-- Rejected -->
        <div class="tab-pane fade" id="rejected" role="tabpanel">
            @include('admin.users.partials.table', ['rows' => $rejected ?? [], 'mode' => 'rejected'])
            <div class="mt-3">{{ $rejected->withQueryString()->links('pagination::bootstrap-5') ?? '' }}</div>
        </div>
    </div>
</div>
@endsection