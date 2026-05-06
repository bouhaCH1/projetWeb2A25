    </div><!-- /.ww-page -->
</div><!-- /.ww-main-wrap -->

</div><!-- /.ww-shell -->

<footer style="margin-left:220px; text-align:center; padding:14px 24px; border-top:1px solid rgba(0,255,204,0.06); background:#080a12;">
    <p style="color:#333; font-size:12px;">© 2026 WorkWave. Tous droits réservés.</p>
</footer>

<!-- ============================================== -->
<!-- FLOATING CHATBOT WIDGET -->
<!-- ============================================== -->
<div id="wwChatbot" style="position:fixed;bottom:20px;right:20px;z-index:9999;font-family:inherit;">
    
    <!-- Chat Button -->
    <button id="chatbotToggle" style="width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#00ffcc,#00b3ff);border:none;box-shadow:0 6px 20px rgba(0,255,204,0.3);color:#000;font-size:24px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:transform 0.2s;">
        💬
    </button>

    <!-- Chat Window -->
    <div id="chatbotWindow" style="display:none;position:absolute;bottom:80px;right:0;width:320px;height:400px;background:#0d1117;border:1px solid rgba(0,255,204,0.2);border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.5);display:flex;flex-direction:column;overflow:hidden;transform-origin:bottom right;transition:transform 0.3s;">
        
        <!-- Header -->
        <div style="background:rgba(0,255,204,0.1);padding:14px;border-bottom:1px solid rgba(0,255,204,0.2);display:flex;justify-content:space-between;align-items:center;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:1.2rem;">🤖</span>
                <div style="color:#fff;font-weight:700;font-size:0.9rem;">Assistant WorkWave</div>
            </div>
            <button id="chatbotClose" style="background:none;border:none;color:#aaa;cursor:pointer;font-size:1rem;">✕</button>
        </div>

        <!-- Messages Area -->
        <div id="chatbotMessages" style="flex:1;padding:14px;overflow-y:auto;display:flex;flex-direction:column;gap:10px;font-size:0.85rem;">
            <!-- Initial Message -->
            <div style="align-self:flex-start;background:rgba(255,255,255,0.05);color:#ddd;padding:10px 14px;border-radius:12px;border-bottom-left-radius:2px;max-width:85%;line-height:1.5;">
                Bonjour ! 👋 Je suis l'assistant IA de WorkWave. Vous pouvez me demander comment utiliser l'application (ex: "Comment activer la 2FA ?" ou "C'est quoi l'analyse IA ?").
            </div>
        </div>

        <!-- Input Area -->
        <div style="padding:10px;border-top:1px solid rgba(255,255,255,0.05);display:flex;gap:8px;background:rgba(0,0,0,0.2);">
            <input type="text" id="chatbotInput" placeholder="Posez votre question..." style="flex:1;padding:10px 12px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:20px;color:#fff;font-size:0.8rem;outline:none;" autocomplete="off">
            <button id="chatbotSend" style="width:36px;height:36px;border-radius:50%;background:#00ffcc;border:none;color:#000;cursor:pointer;display:flex;align-items:center;justify-content:center;">➤</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle (existing)
    const btn = document.getElementById('wwHamburger');
    const sidebar = document.getElementById('wwSidebar');
    if (btn && sidebar) {
        btn.addEventListener('click', () => sidebar.classList.toggle('open'));
    }

    // Chatbot Logic
    const chatbotWindow = document.getElementById('chatbotWindow');
    const chatbotToggle = document.getElementById('chatbotToggle');
    const chatbotClose = document.getElementById('chatbotClose');
    const chatbotMessages = document.getElementById('chatbotMessages');
    const chatbotInput = document.getElementById('chatbotInput');
    const chatbotSend = document.getElementById('chatbotSend');

    // Initially hide window via JS to ensure transitions work smoothly later
    chatbotWindow.style.display = 'none';
    chatbotWindow.style.transform = 'scale(0)';

    function toggleChat() {
        if (chatbotWindow.style.display === 'none') {
            chatbotWindow.style.display = 'flex';
            setTimeout(() => chatbotWindow.style.transform = 'scale(1)', 10);
            chatbotInput.focus();
        } else {
            chatbotWindow.style.transform = 'scale(0)';
            setTimeout(() => chatbotWindow.style.display = 'none', 300);
        }
    }

    chatbotToggle.addEventListener('click', toggleChat);
    chatbotClose.addEventListener('click', toggleChat);

    function appendMessage(text, isUser) {
        const msgDiv = document.createElement('div');
        msgDiv.style.alignSelf = isUser ? 'flex-end' : 'flex-start';
        msgDiv.style.backgroundColor = isUser ? 'rgba(0,255,204,0.15)' : 'rgba(255,255,255,0.05)';
        msgDiv.style.color = isUser ? '#00ffcc' : '#ddd';
        msgDiv.style.padding = '10px 14px';
        msgDiv.style.borderRadius = '12px';
        msgDiv.style.borderBottomRightRadius = isUser ? '2px' : '12px';
        msgDiv.style.borderBottomLeftRadius = isUser ? '12px' : '2px';
        msgDiv.style.maxWidth = '85%';
        msgDiv.style.lineHeight = '1.5';
        msgDiv.style.wordBreak = 'break-word';
        // Parse basic markdown like bold (**text**) and newlines
        let formattedText = text.replace(/\n/g, '<br>');
        formattedText = formattedText.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        msgDiv.innerHTML = formattedText;
        
        chatbotMessages.appendChild(msgDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    function sendMessage() {
        const text = chatbotInput.value.trim();
        if (!text) return;

        appendMessage(text, true);
        chatbotInput.value = '';

        // Typing indicator
        const typingId = 'typing-' + Date.now();
        const typingDiv = document.createElement('div');
        typingDiv.id = typingId;
        typingDiv.style.alignSelf = 'flex-start';
        typingDiv.style.color = '#888';
        typingDiv.style.fontSize = '0.75rem';
        typingDiv.style.fontStyle = 'italic';
        typingDiv.innerText = 'L\'assistant écrit...';
        chatbotMessages.appendChild(typingDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;

        // Send AJAX request
        const formData = new FormData();
        formData.append('message', text);

        fetch('/WorkWave/Controller/index.php?action=ajax_chatbot', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById(typingId).remove();
            appendMessage(data.reply, false);
        })
        .catch(err => {
            document.getElementById(typingId).remove();
            appendMessage("Désolé, je n'ai pas pu joindre le serveur.", false);
        });
    }

    chatbotSend.addEventListener('click', sendMessage);
    chatbotInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') sendMessage();
    });
});
</script>
</body>
</html>
