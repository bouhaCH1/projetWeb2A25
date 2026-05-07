<?php
// Chat Widget - Include this file in any page where you want the chat
// Usage: include 'View/chat-widget.php';
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : (isset($_SESSION['candidat_id']) ? $_SESSION['candidat_id'] : 0);
$userType = isset($_SESSION['admin']) ? 'admin' : 'candidat';
// Pour test: forcer user_id si pas défini
if ($userId === 0) {
    $userId = 2; // ID test
    $userType = 'candidat';
}
?>
<style>
.chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 350px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.2);
    z-index: 9999;
    overflow: hidden;
    font-family: Arial, sans-serif;
}
.chat-header {
    background: linear-gradient(135deg, #00ffcc, #00ccff);
    padding: 15px;
    color: #0a0e27;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.chat-body {
    height: 300px;
    overflow-y: auto;
    padding: 15px;
    background: #f8f9fa;
}
.chat-message {
    margin-bottom: 10px;
    max-width: 80%;
    padding: 10px 15px;
    border-radius: 15px;
    font-size: 14px;
    line-height: 1.4;
}
.chat-message.sent {
    background: #00ffcc;
    color: #0a0e27;
    margin-left: auto;
    border-bottom-right-radius: 5px;
}
.chat-message.received {
    background: #fff;
    color: #333;
    border-bottom-left-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.chat-time {
    font-size: 11px;
    color: #666;
    margin-top: 5px;
}
.chat-input-area {
    padding: 15px;
    background: #fff;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
}
.chat-input {
    flex: 1;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 25px;
    outline: none;
    font-size: 14px;
}
.chat-send-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00ffcc, #00ccff);
    border: none;
    color: #0a0e27;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
.chat-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00ffcc, #00ccff);
    border: none;
    color: #0a0e27;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}
.chat-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.chat-hidden {
    display: none;
}
</style>

<button class="chat-toggle" id="chatToggle" onclick="toggleChat()">
    <i class="fas fa-comments"></i>
    <span class="chat-badge" id="chatBadge" style="display:none">0</span>
</button>

<div class="chat-widget chat-hidden" id="chatWidget">
    <div class="chat-header">
        <span><i class="fas fa-headset"></i> Support</span>
        <button onclick="toggleChat()" style="background:none;border:none;color:#0a0e27;cursor:pointer;font-size:18px">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="chat-body" id="chatBody">
        <div class="chat-message received">
            Bonjour ! Comment puis-je vous aider ?
            <div class="chat-time"><?php echo date('H:i'); ?></div>
        </div>
    </div>
    <div class="chat-input-area">
        <input type="text" class="chat-input" id="chatInput" placeholder="Écrivez votre message..." onkeypress="if(event.key==='Enter')sendMessage()">
        <button class="chat-send-btn" onclick="sendMessage()">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<script>
const chatUserId = <?php echo $userId; ?>;
const chatUserType = '<?php echo $userType; ?>';
const chatOtherId = chatUserType === 'admin' ? 2 : 1; // Admin ID = 1, or get from context

function toggleChat() {
    const widget = document.getElementById('chatWidget');
    const toggle = document.getElementById('chatToggle');
    if (widget.classList.contains('chat-hidden')) {
        widget.classList.remove('chat-hidden');
        toggle.classList.add('chat-hidden');
        loadMessages();
    } else {
        widget.classList.add('chat-hidden');
        toggle.classList.remove('chat-hidden');
    }
}

function loadMessages() {
    fetch(`index.php?action=getChatMessages&user_id=${chatUserId}&other_id=${chatOtherId}&user_type=${chatUserType}`)
        .then(r => r.json())
        .then(data => {
            const body = document.getElementById('chatBody');
            body.innerHTML = '';
            if (data.messages) {
                data.messages.forEach(msg => {
                    const isSent = msg.sender_id == chatUserId && msg.sender_type === chatUserType;
                    addMessageToChat(msg.message, msg.created_at, isSent);
                });
            }
            body.scrollTop = body.scrollHeight;
        });
}

function addMessageToChat(text, time, isSent) {
    const body = document.getElementById('chatBody');
    const div = document.createElement('div');
    div.className = `chat-message ${isSent ? 'sent' : 'received'}`;
    div.innerHTML = `${text}<div class="chat-time">${time}</div>`;
    body.appendChild(div);
    body.scrollTop = body.scrollHeight;
}

function sendMessage() {
    const input = document.getElementById('chatInput');
    const text = input.value.trim();
    if (!text) return;
    
    const formData = new FormData();
    formData.append('sender_id', chatUserId);
    formData.append('sender_type', chatUserType);
    formData.append('receiver_id', chatOtherId);
    formData.append('message', text);
    
    fetch('index.php?action=sendChatMessage', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            addMessageToChat(text, '<?php echo date('H:i'); ?>', true);
            input.value = '';
        }
    });
}

// Check unread messages every 30 seconds
function checkUnread() {
    fetch(`index.php?action=getUnreadCount&user_id=${chatUserId}&user_type=${chatUserType}`)
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('chatBadge');
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        });
}

// Poll for new messages when chat is open
setInterval(() => {
    const widget = document.getElementById('chatWidget');
    if (!widget.classList.contains('chat-hidden')) {
        loadMessages();
    } else {
        checkUnread();
    }
}, 5000);

checkUnread();
</script>
