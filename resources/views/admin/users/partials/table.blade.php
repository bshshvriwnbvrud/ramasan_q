@if(isset($rows) && count($rows) > 0)
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>البريد</th>
                <th>الهاتف</th>
                <th>التخصص</th>
                <th>رقم القيد</th>
                <th>الدور</th>
                <th>الحالة</th>
                <th>تاريخ التسجيل</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->major ?? '—' }}</td>
                    <td>{{ $user->student_no ?? '—' }}</td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge bg-danger">مدير</span>
                        @elseif($user->role == 'supervisor')
                            <span class="badge bg-warning text-dark">مشرف</span>
                        @elseif($user->role == 'editor')
                            <span class="badge bg-info">محرر</span>
                        @else
                            <span class="badge bg-secondary">طالب</span>
                        @endif
                    </td>
                    <td>
                        @if($user->status == 'approved')
                            <span class="badge bg-success">مقبول</span>
                        @elseif($user->status == 'pending')
                            <span class="badge bg-warning text-dark">قيد المراجعة</span>
                        @else
                            <span class="badge bg-danger">مرفوض</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            @if($mode !== 'approved')
                                <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success" title="قبول" onclick="return confirm('قبول هذا المستخدم؟')">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            @endif

                            @if($mode !== 'rejected')
                                <form method="POST" action="{{ route('admin.users.reject', $user) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger" title="رفض" onclick="return confirm('رفض هذا المستخدم؟')">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            @endif

                            @if(auth()->user()->role == 'admin')
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="تعديل">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endif

                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info" title="عرض">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="text-center text-muted py-4">
        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
        <p>لا يوجد مستخدمين في هذا القسم.</p>
    </div>
@endif