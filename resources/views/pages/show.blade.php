<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Kasar Community Matrimony</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Hotwire Turbo -->
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017-umd.js"></script>

    <style>
        .page-content {
            padding: 120px 5% 5rem;
            background: transparent;
            min-height: 80vh;
        }
        .content-card {
            background: white;
            padding: 4rem;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            line-height: 1.8;
            color: #444;
            max-width: 1200px;
            margin: 0 auto;
        }
        .content-card h1 {
            color: var(--primary);
            font-family: 'Playfair Display', serif;
            margin-bottom: 2.5rem;
            font-size: 2.8rem;
            border-bottom: 3px solid var(--secondary);
            display: inline-block;
            padding-bottom: 0.8rem;
        }
        .content-card p { margin-bottom: 1.5rem; }

        @media (max-width: 768px) {
            .page-content { padding: 100px 12px 3rem !important; }
            .content-card { padding: 1.8rem !important; border-radius: 16px !important; }
            .content-card h1 { font-size: 1.8rem !important; margin-bottom: 1.5rem !important; }
            .content-body { font-size: 0.95rem !important; }
        }
    </style>
</head>
<body>
    @include('partials.recovery-banner')

    @include('partials.header')

    <div class="page-content">
        <div class="content-card">
            <h1>{{ $title }}</h1>
            <div class="content-body">
                {!! nl2br(e($content)) !!}
            </div>
        </div>
    </div>

    @include('partials.footer')

    @if(auth()->check() && isset($title) && $title === 'Help Center')
    <div class="chatbot-widget">
        <div class="chatbot-toggle" onclick="toggleChat()">
            <span id="chat-icon">💬</span>
        </div>
        <div class="chatbot-window" id="chatbot-window">
            <div class="chatbot-header">
                <div style="width: 10px; height: 10px; background: #2ecc71; border-radius: 50%;"></div>
                <h4>Kasar Professional Assistant</h4>
            </div>
            
            <div style="background: #fff8f0; padding: 0.8rem; border-bottom: 1px solid #eee; font-size: 0.85rem;">
                <label style="display: block; margin-bottom: 5px; color: var(--primary); font-weight: 700;">Select a quick query:</label>
                <select id="query-dropdown" onchange="askDropdownQuery()" style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid #ddd; outline: none;">
                    <option value="">-- Choose a question --</option>
                    @foreach($faqs as $faq)
                        <option value="{{ $faq->question }}">{{ $faq->question }}</option>
                    @endforeach
                </select>
            </div>

            <div class="chatbot-messages" id="chatbot-messages">
                <div class="chatbot-msg bot">Greetings! I am the professional support assistant for Kasar Community Matrimony. How may I assist you with your queries today?</div>
            </div>
            <div id="chatbot-typing" class="chatbot-typing-indicator" style="padding: 0 1rem;">Assistant is composing...</div>
            <div class="chatbot-input">
                <input type="text" id="chatbot-chat-input" placeholder="Type your inquiry here..." onkeypress="if(event.key === 'Enter') sendMessage()">
                <button onclick="sendMessage()">Inquire</button>
            </div>
        </div>
    </div>

    <script>
        window.toggleChat = function() {
            const chatWin = document.getElementById('chatbot-window');
            chatWin.classList.toggle('active');
            document.getElementById('chat-icon').innerText = chatWin.classList.contains('active') ? '✕' : '💬';
        }

        window.askDropdownQuery = function() {
            const dropdown = document.getElementById('query-dropdown');
            const selected = dropdown.value;
            if (selected) {
                document.getElementById('chatbot-chat-input').value = selected;
                window.sendMessage();
                dropdown.value = ''; // Reset
            }
        }

        window.sendMessage = async function() {
            const input = document.getElementById('chatbot-chat-input');
            const container = document.getElementById('chatbot-messages');
            const typing = document.getElementById('chatbot-typing');
            const text = input.value.trim();

            if (!text) return;

            // Add user message
            const userMsg = document.createElement('div');
            userMsg.className = 'chatbot-msg user';
            userMsg.innerText = text;
            container.appendChild(userMsg);
            input.value = '';
            container.scrollTop = container.scrollHeight;

            // Show typing
            typing.style.display = 'block';

            try {
                const response = await fetch(`/api/chatbot?q=${encodeURIComponent(text)}`);
                const data = await response.json();
                
                setTimeout(() => {
                    typing.style.display = 'none';
                    const botMsg = document.createElement('div');
                    botMsg.className = 'chatbot-msg bot';
                    botMsg.innerHTML = `<strong>Assistant:</strong><br>${data.answer}`;
                    container.appendChild(botMsg);
                    container.scrollTop = container.scrollHeight;
                }, 1000);
            } catch (err) {
                typing.style.display = 'none';
            }
        }
    </script>
    @endif

</body>
</html>
