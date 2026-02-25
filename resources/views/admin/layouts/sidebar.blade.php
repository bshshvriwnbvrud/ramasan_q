<div class="nav flex-column nav-pills admin-sidebar-nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i> لوحة التحكم
    </a>
    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
        <i class="bi bi-people me-2"></i> المستخدمين
    </a>
    <a href="{{ route('admin.competitions') }}" class="nav-link {{ request()->routeIs('admin.competitions*') && !request()->routeIs('admin.competitions.winners*') ? 'active' : '' }}">
        <i class="bi bi-calendar2-week me-2"></i> أيام رمضان
    </a>
    <a href="{{ route('admin.questions.index') }}" class="nav-link {{ request()->routeIs('admin.questions*') ? 'active' : '' }}">
        <i class="bi bi-patch-question me-2"></i> الأسئلة
    </a>
    <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
        <i class="bi bi-gear me-2"></i> الإعدادات
    </a>
    <a href="{{ route('admin.activity_log.index') }}" class="nav-link {{ request()->routeIs('admin.activity_log*') ? 'active' : '' }}">
        <i class="bi bi-clock-history me-2"></i> سجل النشاطات
    </a>
    <a href="{{ route('admin.profile_requests.index') }}" class="nav-link {{ request()->routeIs('admin.profile_requests*') ? 'active' : '' }}">
        <i class="bi bi-person-check me-2"></i> طلبات تعديل البيانات
    </a>
    <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
        <i class="bi bi-chat-dots me-2"></i>الاستفسارات
    </a>
</div>

<style>
/* تحسين الشريط الجانبي ليتناسب مع التصميم الرمضاني */
.admin-sidebar-nav .nav-link {
    color: #333;
    padding: 0.8rem 1.5rem;
    margin: 0.2rem 0;
    border-radius: 0 30px 30px 0; /* منحني من اليمين */
    font-weight: 500;
    transition: all 0.2s;
    background: transparent;
    position: relative;
    overflow: hidden;
}

/* تأثير الخلفية الذهبية عند التحويم */
.admin-sidebar-nav .nav-link:hover {
    background: linear-gradient(90deg, rgba(247, 183, 49, 0.2), transparent);
    color: #b16f0e;
}

/* الرابط النشط */
.admin-sidebar-nav .nav-link.active {
    background: linear-gradient(90deg, #f7b731, #ffd966);
    color: #1e2a47 !important;
    font-weight: 700;
    box-shadow: 0 5px 15px rgba(247, 183, 49, 0.3);
}

/* أيقونة صغيرة للقسم النشط */
.admin-sidebar-nav .nav-link.active::before {
    content: "🕌";
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.9rem;
    opacity: 0.6;
}

/* أيقونة عامة للروابط (اختياري) */
.admin-sidebar-nav .nav-link i {
    font-size: 1.2rem;
    width: 1.8rem;
    display: inline-block;
    transition: transform 0.2s;
}

.admin-sidebar-nav .nav-link:hover i {
    transform: scale(1.1);
}

/* الوضع الليلي */
[data-bs-theme="dark"] .admin-sidebar-nav .nav-link {
    color: #e0e0e0;
}
[data-bs-theme="dark"] .admin-sidebar-nav .nav-link:hover {
    background: linear-gradient(90deg, rgba(255, 217, 102, 0.2), transparent);
    color: #ffd966;
}
[data-bs-theme="dark"] .admin-sidebar-nav .nav-link.active {
    background: linear-gradient(90deg, #b8860b, #daa520);
    color: #121212 !important;
}
</style>