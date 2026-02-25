{{-- resources/views/admin/messages/conversation.blade.php --}}
@extends('layouts.app')

@section('title', 'المحادثة مع ' . $user->name)

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff&size=50" class="rounded-circle me-3" width="50" height="50" alt="{{ $user->name }}">
            <div>
                <h2 class="fw-bold mb-0" style="font-family: 'Amiri', serif; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                    <i class="bi bi-chat-dots-fill me-2" style="color: var(--primary-gold);"></i>محادثة مع {{ $user->name }}
                </h2>
                <small class="text-white-50">{{ $user->email }}</small>
            </div>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-gold btn-sm mt-2 mt-sm-0">
            <i class="bi bi-arrow-right me-1"></i>عودة للقائمة
        </a>
    </div>

    <div class="card glass-card border-0" data-aos="fade-up">
        <div class="card-header bg-transparent d-flex align-items-center" style="border-bottom: 1px solid var(--glass-border);">
            <i class="bi bi-person-circle fs-4 me-2" style="color: var(--primary-gold);"></i>
            <span class="text-white">{{ $user->name }}</span>
        </div>

        <div class="card-body p-0" style="height: 450px; overflow-y: auto;" id="messageContainer">
            @forelse($messages as $msg)
                <div class="message-wrapper {{ $msg->sender_id == Auth::id() ? 'outgoing' : 'incoming' }}" data-message-id="{{ $msg->id }}">
                    <div class="message-bubble {{ $msg->sender_id == Auth::id() ? 'outgoing-bubble' : 'incoming-bubble' }}">
                        <div class="message-text">{{ $msg->message }}</div>
                        <div class="message-time">{{ $msg->created_at->format('h:i A') }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-messages">
                    <i class="bi bi-chat-square-dots-fill"></i>
                    <h5>لا توجد رسائل بعد</h5>
                    <p class="text-white-50">ابدأ بكتابة ردك الآن</p>
                </div>
            @endforelse
        </div>

        <div class="card-footer bg-transparent" style="border-top: 1px solid var(--glass-border);">
            <form id="messageForm" class="position-relative">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                <div class="input-group">
                    <textarea name="message" id="messageInput" class="form-control message-input" placeholder="اكتب ردك هنا..." rows="1" maxlength="500" required></textarea>
                    <button type="submit" class="btn btn-primary-gold" id="sendButton">
                        <span class="spinner-border spinner-border-sm d-none" id="sendSpinner" role="status" aria-hidden="true"></span>
                        <i class="bi bi-send-fill" id="sendIcon"></i>
                    </button>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-white-50">
                        <i class="bi bi-info-circle me-1"></i>اضغط Enter للإرسال
                    </small>
                    <small class="char-counter" id="charCounter">0/500</small>
                </div>
            </form>
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

    #messageContainer {
        scroll-behavior: smooth;
        padding: 1.5rem;
    }

    .message-wrapper {
        margin-bottom: 1.5rem;
        display: flex;
        width: 100%;
    }

    .message-wrapper.outgoing {
        justify-content: flex-end;
    }

    .message-wrapper.incoming {
        justify-content: flex-start;
    }

    .message-bubble {
        max-width: 70%;
        padding: 1rem 1.5rem;
        border-radius: 25px;
        position: relative;
        word-wrap: break-word;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .outgoing-bubble {
        background: linear-gradient(135deg, var(--primary-gold), #d49a1e);
        color: var(--dark-blue);
        border-bottom-left-radius: 5px;
    }

    .incoming-bubble {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        color: white;
        border-bottom-right-radius: 5px;
    }

    .message-text {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 0.5rem;
    }

    .message-time {
        font-size: 0.7rem;
        opacity: 0.7;
        text-align: left;
    }

    .empty-messages {
        text-align: center;
        padding: 4rem 2rem;
        color: white;
    }
    .empty-messages i {
        font-size: 4rem;
        color: var(--primary-gold);
        margin-bottom: 1rem;
    }

    .message-input {
        background: rgba(255,255,255,0.1);
        border: 1px solid var(--glass-border);
        color: white;
        border-radius: 50px !important;
        padding: 1rem 1.5rem;
        resize: none;
        transition: all 0.3s;
    }
    .message-input:focus {
        background: rgba(255,255,255,0.15);
        border-color: var(--primary-gold);
        box-shadow: 0 0 0 0.25rem rgba(247, 183, 49, 0.25);
        color: white;
    }
    .message-input::placeholder {
        color: rgba(255,255,255,0.5);
    }

    .btn-primary-gold {
        background: linear-gradient(135deg, var(--primary-gold), #d49a1e);
        color: var(--dark-blue) !important;
        border: none;
        border-radius: 50px;
        padding: 0 2rem;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-primary-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(212, 154, 30, 0.4);
    }
    .btn-primary-gold:disabled {
        opacity: 0.6;
        transform: none;
    }

    .btn-outline-gold {
        border: 2px solid var(--primary-gold);
        color: white;
        background: transparent;
        transition: all 0.3s;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
    }
    .btn-outline-gold:hover {
        background: var(--primary-gold);
        color: var(--dark-blue);
    }

    .char-counter {
        color: var(--primary-gold);
        font-size: 0.8rem;
    }
    .char-counter.warning {
        color: #ffc107;
    }
    .char-counter.danger {
        color: #dc3545;
    }

    .input-group {
        flex-wrap: nowrap;
    }
    .input-group > :not(:first-child) {
        margin-right: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messageContainer');
        const form = document.getElementById('messageForm');
        const input = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        const sendSpinner = document.getElementById('sendSpinner');
        const sendIcon = document.getElementById('sendIcon');
        const charCounter = document.getElementById('charCounter');
        const maxLength = 500;
        const adminId = {{ Auth::id() }};
        const userId = {{ $user->id }};
        let lastMessageId = {{ $messages->last()->id ?? 0 }};
        let pollingTimer = null;
        let isPolling = false;

        // التمرير إلى أسفل
        container.scrollTop = container.scrollHeight;

        // عداد الأحرف
        input.addEventListener('input', function() {
            const length = this.value.length;
            charCounter.textContent = `${length}/${maxLength}`;

            if (length > maxLength * 0.9) {
                charCounter.classList.add('danger');
                charCounter.classList.remove('warning');
            } else if (length > maxLength * 0.7) {
                charCounter.classList.add('warning');
                charCounter.classList.remove('danger');
            } else {
                charCounter.classList.remove('warning', 'danger');
            }
        });

        // إرسال الرسالة عبر AJAX
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const message = input.value.trim();
            if (!message) return;

            sendButton.disabled = true;
            sendSpinner.classList.remove('d-none');
            sendIcon.classList.add('d-none');

            const formData = new FormData(form);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route("admin.messages.send") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const newMessage = data.message;
                    addMessageToContainer(newMessage, 'outgoing');
                    lastMessageId = newMessage.id;
                    input.value = '';
                    charCounter.textContent = `0/${maxLength}`;
                    charCounter.classList.remove('warning', 'danger');
                }
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                sendButton.disabled = false;
                sendSpinner.classList.add('d-none');
                sendIcon.classList.remove('d-none');
            });
        });

        // دالة إضافة رسالة مع منع التكرار
        function addMessageToContainer(message, type) {
            if (document.querySelector(`[data-message-id="${message.id}"]`)) {
                return;
            }

            const wrapper = document.createElement('div');
            wrapper.className = `message-wrapper ${type}`;
            wrapper.dataset.messageId = message.id;
            wrapper.innerHTML = `
                <div class="message-bubble ${type === 'outgoing' ? 'outgoing-bubble' : 'incoming-bubble'}">
                    <div class="message-text">${escapeHtml(message.message)}</div>
                    <div class="message-time">${message.time}</div>
                </div>
            `;
            container.appendChild(wrapper);
            container.scrollTop = container.scrollHeight;
        }

        // دالة الهروب من HTML
        function escapeHtml(unsafe) {
            return unsafe.replace(/[&<>"']/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                if (m === '"') return '&quot;';
                if (m === "'") return '&#039;';
                return m;
            });
        }

        // Polling مع تمرير user_id
        function pollMessages() {
            if (isPolling) return;
            isPolling = true;

            fetch('{{ route("messages.poll") }}?last_id=' + lastMessageId + '&user_id=' + userId, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.messages && data.messages.length) {
                    data.messages.forEach(msg => {
                        const type = msg.sender_id == adminId ? 'outgoing' : 'incoming';
                        addMessageToContainer(msg, type);
                        if (msg.id > lastMessageId) {
                            lastMessageId = msg.id;
                        }
                    });
                }
            })
            .catch(err => console.warn('Polling error:', err))
            .finally(() => {
                isPolling = false;
                pollingTimer = setTimeout(pollMessages, 5000);
            });
        }

        pollMessages();

        window.addEventListener('beforeunload', function() {
            if (pollingTimer) clearTimeout(pollingTimer);
        });

        // إرسال بالضغط على Enter (مع الاحتفاظ بـ Shift+Enter للسطر الجديد)
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                form.dispatchEvent(new Event('submit'));
            }
        });
    });
</script>
@endpush