<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Chat | Kasar Community Matrimony</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js'])
    
    <!-- Hotwire Turbo -->
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017-umd.js"></script>

    <style>
        body { background: #fdfaf5 !important; overflow: hidden; }
        .chat-container {
            position: fixed;
            top: 80px;
            bottom: 0;
            left: 0;
            right: 0;
            height: calc(100vh - 80px);
            height: calc(100dvh - 80px);
            display: flex;
            background: #fdfaf5;
            z-index: 10;
        }
        .chat-sidebar {
            width: 350px;
            background: white;
            border-right: 1px solid #eee;
            display: flex;
            flex-direction: column;
        }
        .sidebar-header {
            padding: 2rem;
            border-bottom: 1px solid #eee;
        }
        .contact-list {
            flex-grow: 1;
            overflow-y: auto;
        }
        .contact-item {
            display: flex;
            align-items: center;
            padding: 1.5rem 2rem;
            cursor: pointer;
            transition: 0.3s;
            border-bottom: 1px solid #fafafa;
            text-decoration: none;
            color: inherit;
            position: relative;
        }
        .contact-item:hover, .contact-item.active { background: #fdfaf5; }
        .contact-item.active { border-left: 4px solid var(--primary); }
        .contact-item.has-new-msg::after {
            content: '';
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            background: #e74c3c;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(231, 76, 60, 0.5);
        }
        
        .contact-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            margin-right: 1rem;
            position: relative;
        }
        .online-dot {
            width: 12px;
            height: 12px;
            background: #28a745;
            border: 2px solid white;
            border-radius: 50%;
            position: absolute;
            bottom: 2px;
            right: 2px;
            display: none;
        }
        .online-dot.active { display: block; }
        .contact-info h4 { margin-bottom: 0.2rem; font-size: 1rem; color: var(--primary); }
        .contact-info p { font-size: 0.8rem; color: #888; }

        .chat-window {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background: #fff;
        }
        .chat-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .messages-area {
            flex-grow: 1;
            padding: 2rem;
            overflow-y: auto;
            background: #fdfaf5;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .message {
            max-width: 70%;
            padding: 1rem 1.5rem;
            border-radius: 20px;
            font-size: 0.95rem;
            position: relative;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        .message.sent {
            align-self: flex-end;
            background: var(--primary);
            color: white;
            border-bottom-right-radius: 2px;
        }
        .message.received {
            align-self: flex-start;
            background: white;
            color: #333;
            border-bottom-left-radius: 2px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        img.message-file {
            max-width: 300px;
            max-height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 0.5rem;
            display: block;
            cursor: pointer;
        }
        .message-file-link {
            display: block;
            margin-top: 0.5rem;
            padding: 0.5rem;
            background: rgba(0,0,0,0.05);
            border-radius: 8px;
            text-decoration: none;
            color: inherit;
        }
        .chat-input-area {
            padding: 1.5rem 2rem;
            background: white;
            border-top: 1px solid #eee;
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .chat-input {
            flex-grow: 1;
            padding: 1rem 1.5rem;
            border: 1px solid #eee;
            border-radius: 30px;
            background: #f9f9f9;
            outline: none;
        }
        .chat-input:focus { border-color: var(--primary); background: white; }
        
        .file-label {
            cursor: pointer;
            color: var(--primary);
            font-size: 1.5rem;
            transition: 0.3s;
        }
        .file-label:hover { transform: scale(1.1); }
        #file-input { display: none; }

        /* Mobile Responsiveness */
        @media (max-width: 992px) {
            .chat-container {
                top: 70px;
                height: calc(100vh - 70px);
                position: fixed;
                top: 70px;
                left: 0; right: 0; bottom: 0;
                height: calc(100dvh - 70px);
            }
            .chat-sidebar {
                width: 100%;
                display: {{ $activeChatUser ? 'none' : 'flex' }};
                border-right: none;
            }
            .chat-window {
                width: 100%;
                display: {{ $activeChatUser ? 'flex' : 'none' }};
            }
            .mobile-back {
                display: flex !important;
                align-items: center;
                justify-content: center;
                width: 40px; height: 40px;
                background: #fdfaf5;
                border-radius: 50%;
                color: var(--primary);
                text-decoration: none;
                margin-right: 1rem;
            }
        }
    </style>
</head>
<body>
    @include('partials.recovery-banner')
    @include('partials.header')

    <div class="chat-container">
        <!-- Sidebar -->
        <div class="chat-sidebar">
            <div class="sidebar-header">
                <h3 style="color: var(--primary);">My Messages</h3>
            </div>
            <div class="contact-list" id="contact-list">
                @foreach($contacts as $contact)
                    <a href="{{ route('chat.index', $contact->id) }}" 
                       class="contact-item {{ $activeChatUser && $activeChatUser->id == $contact->id ? 'active' : '' }}"
                       data-contact-id="{{ $contact->id }}">
                        <div class="contact-photo" style="background-image: url('{{ $contact->profile->photo1 ? asset('storage/'.$contact->profile->photo1) : 'https://ui-avatars.com/api/?name='.urlencode($contact->name) }}');">
                            <div class="online-dot {{ $contact->isOnline() ? 'active' : '' }}"></div>
                        </div>
                        <div class="contact-info">
                            <h4>{{ $contact->name }}</h4>
                            <p>{{ $contact->profile->occupation }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Chat Window -->
        <div class="chat-window">
            @if($activeChatUser)
                <div class="chat-header">
                    <div style="display: flex; align-items: center;">
                        <a href="{{ route('chat.index') }}" class="mobile-back" style="display: none;">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <div class="contact-photo" style="background-image: url('{{ $activeChatUser->profile->photo1 ? asset('storage/'.$activeChatUser->profile->photo1) : 'https://ui-avatars.com/api/?name='.urlencode($activeChatUser->name) }}'); width: 40px; height: 40px;">
                            <div class="online-dot {{ $activeChatUser->isOnline() ? 'active' : '' }}"></div>
                        </div>
                        <div style="margin-left: 1rem;">
                            <h4 style="color: var(--primary); margin: 0;">{{ $activeChatUser->name }}</h4>
                            <p style="font-size: 0.75rem; color: {{ $activeChatUser->isOnline() ? '#28a745' : '#888' }}; margin: 0;">
                                {{ $activeChatUser->isOnline() ? 'Online' : ($activeChatUser->last_seen_at ? 'Last seen ' . $activeChatUser->last_seen_at->diffForHumans() : 'Offline') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="messages-area" id="messages-area">
                    @foreach($messages as $msg)
                        <div class="message {{ $msg->sender_id == Auth::id() ? 'sent' : 'received' }}" data-msg-id="{{ $msg->id }}">
                            @if($msg->message)
                                <div>{{ $msg->message }}</div>
                            @endif
                            @if($msg->file_path)
                                @if($msg->file_type == 'image')
                                    <img src="{{ asset('storage/'.$msg->file_path) }}" class="message-file" onclick="window.open(this.src)">
                                @else
                                    <div class="message-file">
                                        <a href="{{ asset('storage/'.$msg->file_path) }}" target="_blank" style="color: inherit;">📄 View PDF Document</a>
                                    </div>
                                @endif
                            @endif
                            <div style="font-size: 0.65rem; margin-top: 0.5rem; opacity: 0.7; text-align: right; display: flex; align-items: center; justify-content: flex-end; gap: 4px;">
                                {{ $msg->created_at->format('h:i A') }}
                                @if($msg->sender_id == Auth::id())
                                    <i class="fas fa-check-double" style="color: {{ $msg->is_read ? '#34b7f1' : '#aaa' }}; font-size: 0.8rem;"></i>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="chat-input-area" style="flex-direction: column; align-items: stretch;">
                    <div id="file-preview" style="display: none; padding: 10px; background: #f8f9fa; border-bottom: 1px solid #eee; align-items: center; gap: 10px; position: relative;">
                        <img id="preview-img" src="" style="max-height: 60px; border-radius: 5px; display: none;">
                        <div id="preview-file-name" style="font-size: 0.8rem; color: #666; flex-grow: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"></div>
                        <span onclick="window.clearFile()" style="cursor: pointer; color: #dc3545; font-size: 1.2rem; padding: 0 5px;">&times;</span>
                    </div>
                    <div class="input-wrapper" style="display: flex; gap: 1rem; align-items: center; width: 100%;">
                        <label for="file-input" class="file-label">📎</label>
                        <input type="file" id="file-input" accept="image/*,application/pdf">
                        <input type="text" id="chat-input" class="chat-input" placeholder="Type your message here..." onkeypress="if(event.key === 'Enter') window.sendMessage()">
                        <button class="btn-primary send-btn" id="send-btn" style="padding: 0.8rem 2rem; border-radius: 30px;" onclick="window.sendMessage()">
                            <span>Send</span>
                            <i class="fas fa-paper-plane" style="display: none;"></i>
                        </button>
                    </div>
                </div>
            @else
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #888;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">💬</div>
                    <h3>Select a contact to start chatting</h3>
                    <p>Only accepted connections can message each other.</p>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.3.0/pusher.min.js"></script>
    <script>
        // Use a persistent object to store app state across Turbo navigations
        // If user context changed, reset state and leave old channel
        if (window.chatAppState && window.chatAppState.currentUserId != {{ Auth::id() }}) {
            if (window.Echo) window.Echo.leave(`chat.${window.chatAppState.currentUserId}`);
            window.chatAppState = null;
        }

        window.chatAppState = window.chatAppState || {
            activeUserId: null,
            currentUserId: {{ Auth::id() }},
            renderedMessageIds: new Set(),
            isEchoInitialized: false,
            messageHandler: null
        };

        (function() {
            const state = window.chatAppState;
            state.activeUserId = {{ $activeChatUser ? $activeChatUser->id : 'null' }};
            
            const messagesArea = document.getElementById('messages-area');
            const chatInput = document.getElementById('chat-input');
            const fileInput = document.getElementById('file-input');
            const filePreview = document.getElementById('file-preview');
            const previewImg = document.getElementById('preview-img');
            const previewFileName = document.getElementById('preview-file-name');

            // Initialize rendered IDs from current DOM
            state.renderedMessageIds = new Set();
            if (messagesArea) {
                messagesArea.querySelectorAll('[data-msg-id]').forEach(el => {
                    state.renderedMessageIds.add(el.dataset.msgId);
                });
                messagesArea.scrollTop = messagesArea.scrollHeight;
            }

            // Expose core functions to window for HTML event handlers
            window.clearFile = function() {
                if (fileInput) fileInput.value = '';
                if (filePreview) filePreview.style.display = 'none';
                if (previewImg) previewImg.src = '';
            };

            window.sendMessage = async function() {
                const message = chatInput.value.trim();
                const file = fileInput.files ? fileInput.files[0] : null;
                
                if (!message && !file) return;

                if (file && file.size > 20 * 1024 * 1024) {
                    alert('File size exceeds 20MB limit.');
                    return;
                }

                // Optimistic UI
                const tempId = 'temp_' + Date.now();
                renderMessage({
                    id: tempId,
                    message: message,
                    sender_id: state.currentUserId,
                    created_at: new Date().toISOString(),
                    is_optimistic: true,
                    file_type: file ? (file.type.startsWith('image/') ? 'image' : 'pdf') : null,
                    file_blob: file ? URL.createObjectURL(file) : null
                });

                chatInput.value = '';
                chatInput.focus();
                const pendingFile = file;
                window.clearFile();

                const formData = new FormData();
                if (message) formData.append('message', message);
                if (pendingFile) formData.append('file', pendingFile);

                try {
                    const response = await fetch(`/chat/${state.activeUserId}/send`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                        body: formData
                    });
                    const data = await response.json();
                    
                    if (data.success) {
                        // Replace temp message with server message if needed, or just let fetch/echo handle it
                        // For now, we'll just remove the optimistic tag or wait for refresh
                        const tempEl = document.querySelector(`[data-msg-id="${tempId}"]`);
                        if (tempEl && data.message) {
                            tempEl.dataset.msgId = data.message.id;
                            state.renderedMessageIds.add(data.message.id.toString());
                            tempEl.style.opacity = '1';
                            tempEl.querySelector('.fa-clock')?.classList.replace('fa-clock', 'fa-check-double');
                        }
                    } else {
                        document.querySelector(`[data-msg-id="${tempId}"]`)?.remove();
                        alert(data.message || 'Failed to send');
                    }
                } catch (err) {
                    console.error(err);
                    document.querySelector(`[data-msg-id="${tempId}"]`)?.remove();
                }
            };

            async function fetchMessages() {
                if (!state.activeUserId) return;
                try {
                    const response = await fetch(`/chat/${state.activeUserId}/fetch`);
                    const data = await response.json();
                    if (data.success) {
                        data.messages.forEach(msg => renderMessage(msg));
                    }
                } catch (err) { console.error('Fetch error:', err); }
            }

            function renderMessage(msg, isOptimistic = false) {
                if (!messagesArea) return;
                
                // Strict deduplication: check both in-memory set and DOM
                if (state.renderedMessageIds.has(msg.id.toString()) || 
                    document.querySelector(`[data-msg-id="${msg.id}"]`)) {
                    return;
                }

                const isSent = msg.sender_id == state.currentUserId;
                const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                
                let fileHtml = '';
                if (msg.file_path || msg.file_blob) {
                    const url = msg.file_blob || `/storage/${msg.file_path}`;
                    if (msg.file_type === 'image') {
                        fileHtml = `<img src="${url}" class="message-file" onclick="window.open(this.src)">`;
                    } else {
                        fileHtml = `<a href="${url}" target="_blank" class="message-file-link">📄 View PDF Document</a>`;
                    }
                }

                const html = `
                    <div class="message ${isSent ? 'sent' : 'received'}" data-msg-id="${msg.id}" style="${isOptimistic ? 'opacity: 0.7;' : ''}">
                        ${msg.message ? `<div>${msg.message}</div>` : ''}
                        ${fileHtml}
                        <div style="font-size: 0.65rem; margin-top: 0.5rem; opacity: 0.7; text-align: right; display: flex; align-items: center; justify-content: flex-end; gap: 4px;">
                            ${time}
                            ${isSent ? (isOptimistic ? '<i class="fas fa-clock"></i>' : `<i class="fas fa-check-double" style="color: ${msg.is_read ? '#34b7f1' : '#aaa'};"></i>`) : ''}
                        </div>
                    </div>
                `;

                messagesArea.insertAdjacentHTML('beforeend', html);
                state.renderedMessageIds.add(msg.id.toString());
                messagesArea.scrollTop = messagesArea.scrollHeight;
            }

            function handleIncomingMessage(e) {
                const msg = e.message;
                
                // If chatting with sender, render it
                if (state.activeUserId && msg.sender_id == state.activeUserId) {
                    renderMessage(msg);
                } else {
                    // Update sidebar notification
                    const item = document.querySelector(`.contact-item[data-contact-id="${msg.sender_id}"]`);
                    if (item && !item.classList.contains('active')) {
                        item.classList.add('has-new-msg');
                    }
                }
            }

            // Register the current handler to the global proxy
            state.messageHandler = handleIncomingMessage;

            // WebSocket Initialization (Global Singleton)
            function initEcho() {
                if (typeof window.Echo === 'undefined') {
                    setTimeout(initEcho, 500);
                    return;
                }

                if (state.isEchoInitialized) return;

                console.log('Initializing Global Chat Echo Listener for user:', state.currentUserId);
                window.Echo.private(`chat.${state.currentUserId}`)
                    .listen('.message.sent', (e) => {
                        console.log('Real-time message received:', e);
                        if (typeof state.messageHandler === 'function') {
                            state.messageHandler(e);
                        }
                    })
                    .error((error) => {
                        console.error('Echo Private Channel Error:', error);
                    });
                
                state.isEchoInitialized = true;
            }

            initEcho();

            // File input preview logic
            if (fileInput) {
                fileInput.onchange = function() {
                    const file = fileInput.files[0];
                    if (file) {
                        filePreview.style.display = 'flex';
                        previewFileName.innerText = file.name;
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = e => {
                                previewImg.src = e.target.result;
                                previewImg.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        } else {
                            previewImg.style.display = 'none';
                        }
                    }
                };
            }

            // Keyboard handling for mobile
            if (window.visualViewport) {
                const handleResize = () => {
                    const container = document.querySelector('.chat-container');
                    if (window.innerWidth <= 992 && container) {
                        const isKeyboardOpen = window.visualViewport.height < window.innerHeight * 0.8;
                        container.style.top = isKeyboardOpen ? '0px' : '70px';
                        container.style.height = `${window.visualViewport.height - (isKeyboardOpen ? 0 : 70)}px`;
                        if (messagesArea) messagesArea.scrollTop = messagesArea.scrollHeight;
                    }
                };
                window.visualViewport.addEventListener('resize', handleResize);
            }

            // Turbo cache cleanup
            document.addEventListener('turbo:before-cache', () => {
                // Remove optimistic messages or temporary states before caching
                document.querySelectorAll('.message[data-msg-id^="temp_"]').forEach(el => el.remove());
            }, { once: true });

        })();
    </script>
</body>
</html>
