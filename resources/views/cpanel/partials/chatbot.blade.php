{{-- Widget de Chatbot Dialogflow --}}
<style>
    /* ===== CHATBOT WIDGET ===== */
    #chatbot-widget {
        position: fixed;
        bottom: 28px;
        right: 28px;
        z-index: 9999;
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    /* Botón flotante */
    #chatbot-toggle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.45);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }
    #chatbot-toggle:hover {
        transform: scale(1.1);
        box-shadow: 0 12px 35px rgba(99, 102, 241, 0.6);
    }
    #chatbot-toggle svg {
        width: 28px;
        height: 28px;
        fill: white;
        transition: transform 0.3s ease;
    }
    #chatbot-toggle.open svg.icon-chat { display: none; }
    #chatbot-toggle.open svg.icon-close { display: block !important; }
    #chatbot-toggle svg.icon-close { display: none; }

    /* Burbuja de notificación */
    #chatbot-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #ef4444;
        color: white;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse-badge 2s infinite;
    }
    @keyframes pulse-badge {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    /* Ventana del chat */
    #chatbot-window {
        position: absolute;
        bottom: 75px;
        right: 0;
        width: 360px;
        height: 500px;
        background: #0f0f1a;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.08);
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transform: scale(0.85) translateY(20px);
        opacity: 0;
        pointer-events: none;
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform-origin: bottom right;
    }
    #chatbot-window.open {
        transform: scale(1) translateY(0);
        opacity: 1;
        pointer-events: all;
    }

    /* Header */
    .chat-header {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }
    .chat-header-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .chat-header-info h4 {
        color: white;
        font-size: 15px;
        font-weight: 700;
        margin: 0;
        line-height: 1;
    }
    .chat-header-info span {
        color: rgba(255,255,255,0.75);
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 3px;
    }
    .chat-header-info span::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #4ade80;
        display: inline-block;
        animation: blink 1.5s infinite;
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    /* Mensajes */
    #chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 16px 14px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        scrollbar-width: thin;
        scrollbar-color: #2d2d4e transparent;
    }
    #chat-messages::-webkit-scrollbar { width: 4px; }
    #chat-messages::-webkit-scrollbar-track { background: transparent; }
    #chat-messages::-webkit-scrollbar-thumb { background: #2d2d4e; border-radius: 4px; }

    .chat-msg {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        max-width: 85%;
        animation: fadeInUp 0.3s ease;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .chat-msg.bot { align-self: flex-start; }
    .chat-msg.user { align-self: flex-end; flex-direction: row-reverse; }

    .chat-bubble {
        padding: 10px 14px;
        border-radius: 16px;
        font-size: 13.5px;
        line-height: 1.5;
        word-break: break-word;
    }
    .chat-msg.bot .chat-bubble {
        background: #1e1e35;
        color: #e2e2f0;
        border-bottom-left-radius: 4px;
        border: 1px solid rgba(255,255,255,0.06);
    }
    .chat-msg.user .chat-bubble {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border-bottom-right-radius: 4px;
    }
    .bot-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    /* Typing indicator */
    .typing-indicator {
        display: flex;
        gap: 4px;
        align-items: center;
        padding: 10px 14px;
        background: #1e1e35;
        border-radius: 16px;
        border-bottom-left-radius: 4px;
        width: fit-content;
    }
    .typing-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #6366f1;
        animation: typing 1.2s infinite;
    }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    @keyframes typing {
        0%, 100% { transform: translateY(0); opacity: 0.4; }
        50% { transform: translateY(-5px); opacity: 1; }
    }

    /* Input */
    .chat-footer {
        padding: 12px 14px;
        background: #0f0f1a;
        border-top: 1px solid rgba(255,255,255,0.06);
        display: flex;
        gap: 8px;
        align-items: center;
        flex-shrink: 0;
    }
    #chat-input {
        flex: 1;
        background: #1e1e35;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 10px 14px;
        color: #e2e2f0;
        font-size: 13.5px;
        outline: none;
        transition: border-color 0.2s;
        resize: none;
        height: 42px;
        max-height: 100px;
        font-family: inherit;
    }
    #chat-input:focus {
        border-color: #6366f1;
    }
    #chat-input::placeholder { color: #555577; }
    #chat-send-btn {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    #chat-send-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 14px rgba(99,102,241,0.5);
    }
    #chat-send-btn svg {
        width: 18px;
        height: 18px;
        fill: white;
    }
    #chat-send-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

    /* Responsive */
    @media (max-width: 420px) {
        #chatbot-window { width: calc(100vw - 40px); right: -14px; }
    }
</style>

<!-- Widget HTML -->
<div id="chatbot-widget">
    <!-- Botón flotante -->
    <button id="chatbot-toggle" title="Abrir asistente virtual">
        <div id="chatbot-badge">1</div>
        <!-- Icono chat -->
        <svg class="icon-chat" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6zm8 5H6v-2h8zm4-6H6V6h12z"/>
        </svg>
        <!-- Icono cerrar -->
        <svg class="icon-close" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
        </svg>
    </button>

    <!-- Ventana del chat -->
    <div id="chatbot-window">
        <!-- Header -->
        <div class="chat-header">
            <div class="chat-header-avatar">🤖</div>
            <div class="chat-header-info">
                <h4>Asistente ITSSMT</h4>
                <span>En línea ahora</span>
            </div>
        </div>

        <!-- Mensajes -->
        <div id="chat-messages">
            <!-- Mensaje de bienvenida dinámico -->
            <div class="chat-msg bot">
                <div class="bot-icon">🤖</div>
                <div class="chat-bubble">
                    @auth
                        @php
                            $rolesMap = [1 => 'Administrador', 2 => 'Estudiante', 4 => 'Docente'];
                            $userRole = $rolesMap[auth()->user()->id_tipo] ?? 'Usuario';
                        @endphp
                        ¡Hola, {{ auth()->user()->nombre }}! 👋 Soy el asistente virtual. ¿En qué puedo ayudarte hoy con tu acceso de <strong>{{ $userRole }}</strong>?
                    @else
                        ¡Hola! 👋 Soy el asistente virtual del ITSSMT. ¿Cómo te llamas o en qué puedo ayudarte hoy?
                    @endauth
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="chat-footer">
            <textarea
                id="chat-input"
                placeholder="Escribe tu mensaje..."
                rows="1"
                maxlength="500"
            ></textarea>
            <button id="chat-send-btn" title="Enviar">
                <svg viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    const toggle      = document.getElementById('chatbot-toggle');
    const window_     = document.getElementById('chatbot-window');
    const messagesEl  = document.getElementById('chat-messages');
    const input       = document.getElementById('chat-input');
    const sendBtn     = document.getElementById('chat-send-btn');
    const badge       = document.getElementById('chatbot-badge');

    // ID de sesión único por pestaña
    const sessionId = 'sess_' + Math.random().toString(36).substr(2, 12);

    // ─── Abrir / cerrar ──────────────────────────────────────────
    toggle.addEventListener('click', () => {
        toggle.classList.toggle('open');
        window_.classList.toggle('open');
        badge.style.display = 'none';
        if (window_.classList.contains('open')) {
            input.focus();
        }
    });

    // ─── Auto-resize textarea ────────────────────────────────────
    input.addEventListener('input', () => {
        input.style.height = '42px';
        input.style.height = Math.min(input.scrollHeight, 100) + 'px';
    });

    // ─── Enter para enviar (Shift+Enter = nueva línea) ───────────
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
    sendBtn.addEventListener('click', sendMessage);

    // ─── Agregar burbuja de mensaje ──────────────────────────────
    function addMessage(text, type) {
        const wrapper = document.createElement('div');
        wrapper.className = `chat-msg ${type}`;

        if (type === 'bot') {
            const icon = document.createElement('div');
            icon.className = 'bot-icon';
            icon.textContent = '🤖';
            wrapper.appendChild(icon);
        }

        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble';
        bubble.textContent = text;
        wrapper.appendChild(bubble);

        messagesEl.appendChild(wrapper);
        scrollToBottom();
        return wrapper;
    }

    // ─── Typing indicator ────────────────────────────────────────
    function showTyping() {
        const wrapper = document.createElement('div');
        wrapper.className = 'chat-msg bot';
        wrapper.id = 'typing-indicator';

        const icon = document.createElement('div');
        icon.className = 'bot-icon';
        icon.textContent = '🤖';

        const dots = document.createElement('div');
        dots.className = 'typing-indicator';
        for (let i = 0; i < 3; i++) {
            const d = document.createElement('div');
            d.className = 'typing-dot';
            dots.appendChild(d);
        }

        wrapper.appendChild(icon);
        wrapper.appendChild(dots);
        messagesEl.appendChild(wrapper);
        scrollToBottom();
    }

    function hideTyping() {
        const el = document.getElementById('typing-indicator');
        if (el) el.remove();
    }

    function scrollToBottom() {
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    // ─── Enviar mensaje ──────────────────────────────────────────
    async function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        // Mostrar mensaje del usuario
        addMessage(text, 'user');
        input.value = '';
        input.style.height = '42px';
        sendBtn.disabled = true;

        // Mostrar typing
        showTyping();

        try {
            const response = await fetch('{{ route("chatbot.mensaje") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    message: text,
                    session_id: sessionId,
                }),
            });

            const data = await response.json();
            hideTyping();
            addMessage(
                data.reply || 'No pude obtener una respuesta. Intenta de nuevo.',
                'bot'
            );
        } catch (err) {
            hideTyping();
            addMessage('Error de conexión. Verifica tu internet e intenta de nuevo.', 'bot');
        } finally {
            sendBtn.disabled = false;
            input.focus();
        }
    }
})();
</script>
