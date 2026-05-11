<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Chat | Kasar Samaj Matrimony</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { background: #fdfaf5 !important; overflow: hidden; }
        .chat-container {
            margin-top: 80px;
            height: calc(100vh - 80px);
            display: flex;
            background: #fdfaf5;
            position: relative;
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
        }
        .contact-item:hover, .contact-item.active { background: #fdfaf5; }
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
        }
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
        }
        .file-label {
            cursor: pointer;
            color: var(--primary);
            font-size: 1.5rem;
        }
        #file-input { display: none; }

        /* Mobile Responsiveness */
        @media (max-width: 992px) {
            .chat-container {
                margin-top: 70px;
                height: calc(100vh - 70px);
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
                width: 40px;
                height: 40px;
                background: #fdfaf5;
                border-radius: 50%;
                color: var(--primary);
                text-decoration: none;
                margin-right: 1rem;
                font-size: 1.1rem;
                transition: 0.3s;
            }
            .mobile-back:hover { background: #fff5f5; transform: translateX(-3px); }
            
            .chat-header { padding: 1rem 1.5rem; }
            .messages-area { padding: 1.5rem; }
            .chat-input-area { padding: 1rem !important; }
            .sidebar-header { padding: 1.5rem; }
            .contact-item { padding: 1.2rem 1.5rem; }
            
            .chat-input-area .input-wrapper { gap: 0.5rem !important; }
            .chat-input { padding: 0.8rem 1.2rem; font-size: 0.9rem; }
            .send-btn {
                width: 45px;
                height: 45px;
                padding: 0 !important;
                border-radius: 50% !important;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .send-btn span { display: none; }
            .send-btn i { display: block !important; font-size: 1.1rem; }
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
            <div class="contact-list">
                @foreach($contacts as $contact)
                    <a href="{{ route('chat.index', $contact->id) }}" class="contact-item {{ $activeChatUser && $activeChatUser->id == $contact->id ? 'active' : '' }}">
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
                        <div class="message {{ $msg->sender_id == Auth::id() ? 'sent' : 'received' }}">
                            @if($msg->message)
                                <div>{{ $msg->message }}</div>
                            @endif
                            @if($msg->file_path)
                                @if($msg->file_type == 'image')
                                    <img src="{{ asset('storage/'.$msg->file_path) }}" class="message-file">
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
                        <span onclick="clearFile()" style="cursor: pointer; color: #dc3545; font-size: 1.2rem; padding: 0 5px;">&times;</span>
                    </div>
                    <div class="input-wrapper" style="display: flex; gap: 1rem; align-items: center; width: 100%;">
                        <label for="file-input" class="file-label">📎</label>
                        <input type="file" id="file-input" accept="image/*,application/pdf">
                        <input type="text" id="chat-input" class="chat-input" placeholder="Type your message here..." onkeypress="if(event.key === 'Enter') sendMessage()">
                        <button class="btn-primary send-btn" style="padding: 0.8rem 2rem; border-radius: 30px;" onclick="sendMessage()">
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

    <script>
        const messagesArea = document.getElementById('messages-area');
        const chatInput = document.getElementById('chat-input');
        const fileInput = document.getElementById('file-input');
        const activeUserId = {{ $activeChatUser ? $activeChatUser->id : 'null' }};
        const filePreview = document.getElementById('file-preview');
        const previewImg = document.getElementById('preview-img');
        const previewFileName = document.getElementById('preview-file-name');

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

        function clearFile() {
            fileInput.value = '';
            filePreview.style.display = 'none';
            previewImg.src = '';
        }

        if (messagesArea) {
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }

        function appendOptimisticMessage(message, file) {
            const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            let fileHtml = '';
            
            if (file) {
                if (file.type.startsWith('image/')) {
                    const url = URL.createObjectURL(file);
                    fileHtml = `<img src="${url}" class="message-file" style="opacity: 0.5;">`;
                } else {
                    fileHtml = `<div class="message-file-link" style="opacity: 0.5;">📄 Sending ${file.name}...</div>`;
                }
            }

            const html = `
                <div class="message sent optimistic-msg" style="opacity: 0.7;">
                    ${message ? `<div>${message}</div>` : ''}
                    ${fileHtml}
                    <div style="font-size: 0.65rem; margin-top: 0.5rem; opacity: 0.7; text-align: right; display: flex; align-items: center; justify-content: flex-end; gap: 4px;">
                        ${time}
                        <i class="fas fa-clock" style="font-size: 0.8rem;"></i>
                    </div>
                </div>
            `;
            messagesArea.insertAdjacentHTML('beforeend', html);
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }

        async function sendMessage() {
            const message = chatInput.value.trim();
            const file = fileInput.files[0];
            
            if (!message && !file) return;

            if (file && file.size > 20 * 1024 * 1024) {
                alert('File size exceeds 20MB limit.');
                return;
            }

            // --- OPTIMISTIC UPDATE ---
            appendOptimisticMessage(message, file);
            chatInput.value = '';
            const pendingFile = file; // Keep reference for clearing
            clearFile();

            const formData = new FormData();
            if (message) formData.append('message', message);
            if (pendingFile) formData.append('file', pendingFile);

            try {
                const response = await fetch(`/chat/${activeUserId}/send`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    // Success: fetchMessages will eventually replace the optimistic message with the real one
                    fetchMessages();
                } else {
                    // Remove optimistic message on failure
                    const lastMsg = document.querySelector('.optimistic-msg');
                    if (lastMsg) lastMsg.remove();
                    alert(data.message || 'Failed to send message');
                }
            } catch (err) {
                console.error(err);
                const lastMsg = document.querySelector('.optimistic-msg');
                if (lastMsg) lastMsg.remove();
                alert('Network error. Please try again.');
            }
        }

        async function fetchMessages() {
            if (!activeUserId) return;

            try {
                const response = await fetch(`/chat/${activeUserId}/fetch`);
                const data = await response.json();
                if (data.success) {
                    const currentScroll = messagesArea.scrollTop + messagesArea.clientHeight;
                    const isAtBottom = currentScroll >= messagesArea.scrollHeight - 50;

                    // Keep track of optimistic messages
                    const optimisticMessages = Array.from(document.querySelectorAll('.optimistic-msg'));
                    const serverMessagesContent = data.messages.map(m => m.message);

                    let html = '';
                    data.messages.forEach(msg => {
                        const isSent = msg.sender_id == {{ Auth::id() }};
                        const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        
                        html += `
                            <div class="message ${isSent ? 'sent' : 'received'}">
                                ${msg.message ? `<div>${msg.message}</div>` : ''}
                                ${msg.file_path ? (
                                    msg.file_type === 'image' 
                                    ? `<img src="/storage/${msg.file_path}" class="message-file" onclick="window.open(this.src)">`
                                    : `<a href="/storage/${msg.file_path}" target="_blank" class="message-file-link">📄 View PDF Document</a>`
                                ) : ''}
                                <div style="font-size: 0.65rem; margin-top: 0.5rem; opacity: 0.7; text-align: right; display: flex; align-items: center; justify-content: flex-end; gap: 4px;">
                                    ${time}
                                    ${isSent ? `<i class="fas fa-check-double" style="color: ${msg.is_read ? '#34b7f1' : '#aaa'}; font-size: 0.8rem;"></i>` : ''}
                                </div>
                            </div>
                        `;
                    });
                    
                    messagesArea.innerHTML = html;

                    // Re-append optimistic messages only if they aren't on the server yet
                    optimisticMessages.forEach(msg => {
                        const msgText = msg.querySelector('div:first-child')?.innerText;
                        if (msgText && !serverMessagesContent.includes(msgText)) {
                            messagesArea.appendChild(msg);
                        } else if (!msgText && msg.querySelector('.message-file')) {
                            // It's a file-only message, harder to match, so we just keep it until 
                            // the server returns a file message (approximate check)
                            const serverHasFile = data.messages.some(m => m.file_path && m.sender_id == {{ Auth::id() }});
                            if (!serverHasFile) messagesArea.appendChild(msg);
                        }
                    });
                    
                    if (isAtBottom) {
                        messagesArea.scrollTop = messagesArea.scrollHeight;
                    }
                }
            } catch (err) {
                console.error(err);
            }
        }

        // Polling for real-time feel
        if (activeUserId) {
            setInterval(fetchMessages, 3000);
        }
    </script>

</body>
</html>
