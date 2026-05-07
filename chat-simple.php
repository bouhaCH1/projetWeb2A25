<?php
session_start();
$_SESSION['user_id'] = 2;
$_SESSION['candidat_id'] = 2;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chat Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background:#0a0e27; color:#fff; padding:50px; font-family:Arial;">
    <h1 style="color:#00ffcc">Test Chat</h1>
    <p>Bouton chat en bas à droite:</p>

    <!-- BOUTON CHAT -->
    <button id="chatBtn" onclick="toggleChat()" style="
        position:fixed;
        bottom:20px;
        right:20px;
        width:60px;
        height:60px;
        border-radius:50%;
        background:linear-gradient(135deg,#00ffcc,#00ccff);
        border:none;
        color:#0a0e27;
        font-size:24px;
        cursor:pointer;
        z-index:9999;
        box-shadow:0 5px 15px rgba(0,0,0,0.3);
    ">
        <i class="fas fa-comments"></i>
    </button>

    <!-- FENETRE CHAT -->
    <div id="chatWindow" style="
        position:fixed;
        bottom:90px;
        right:20px;
        width:350px;
        height:450px;
        background:#fff;
        border-radius:15px;
        box-shadow:0 10px 30px rgba(0,0,0,0.3);
        z-index:9998;
        display:none;
        overflow:hidden;
    ">
        <!-- Header -->
        <div style="background:linear-gradient(135deg,#00ffcc,#00ccff); padding:15px; color:#0a0e27; font-weight:bold; display:flex; justify-content:space-between; align-items:center;">
            <span><i class="fas fa-headset"></i> Support</span>
            <button onclick="toggleChat()" style="background:none;border:none;font-size:18px;cursor:pointer;">×</button>
        </div>
        
        <!-- Messages -->
        <div id="chatMessages" style="height:320px; padding:15px; overflow-y:auto; background:#f8f9fa; color:#333;">
            <div style="background:#fff; padding:10px 15px; border-radius:15px; margin-bottom:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                <strong>Support:</strong> Bonjour ! Comment puis-je vous aider ?
                <div style="font-size:11px;color:#666;margin-top:5px;"><?php echo date('H:i'); ?></div>
            </div>
        </div>
        
        <!-- Input -->
        <div style="padding:10px; border-top:1px solid #eee; display:flex; gap:10px;">
            <input type="text" id="msgInput" placeholder="Votre message..." style="flex:1; padding:10px 15px; border:1px solid #ddd; border-radius:25px; outline:none;" onkeypress="if(event.key==='Enter')sendMessage()">
            <button onclick="sendMessage()" style="width:40px;height:40px;border-radius:50%;background:#00ffcc;border:none;cursor:pointer;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <script>
        function toggleChat() {
            const w = document.getElementById('chatWindow');
            w.style.display = w.style.display === 'block' ? 'none' : 'block';
        }
        
        function sendMessage() {
            const input = document.getElementById('msgInput');
            const messages = document.getElementById('chatMessages');
            const text = input.value.trim();
            
            if (!text) return;
            
            // Envoyer au serveur
            const formData = new FormData();
            formData.append('sender_id', 2);
            formData.append('sender_type', 'candidat');
            formData.append('receiver_id', 1);
            formData.append('message', text);
            
            fetch('index.php?action=sendChatMessage', {
                method: 'POST',
                body: formData
            });
            
            // Afficher localement
            const div = document.createElement('div');
            div.style.cssText = 'background:#00ffcc; color:#0a0e27; padding:10px 15px; border-radius:15px; margin-bottom:10px; margin-left:auto; max-width:80%; border-bottom-right-radius:5px;';
            div.innerHTML = '<strong>Vous:</strong> ' + text + '<div style="font-size:11px;color:#0a0e27;margin-top:5px;"><?php echo date('H:i'); ?></div>';
            messages.appendChild(div);
            messages.scrollTop = messages.scrollHeight;
            
            input.value = '';
        }
        
        // Charger messages existants
        function loadMessages() {
            fetch('index.php?action=getChatMessages&user_id=2&other_id=1&user_type=candidat')
                .then(r => r.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        const messages = document.getElementById('chatMessages');
                        messages.innerHTML = '';
                        data.messages.forEach(msg => {
                            const isMe = msg.sender_id == 2;
                            const div = document.createElement('div');
                            div.style.cssText = isMe 
                                ? 'background:#00ffcc; color:#0a0e27; padding:10px 15px; border-radius:15px; margin-bottom:10px; margin-left:auto; max-width:80%; border-bottom-right-radius:5px;'
                                : 'background:#fff; color:#333; padding:10px 15px; border-radius:15px; margin-bottom:10px; max-width:80%; border-bottom-left-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,0.1);';
                            div.innerHTML = '<strong>' + (isMe ? 'Vous' : 'Support') + ':</strong> ' + msg.message + '<div style="font-size:11px;color:#666;margin-top:5px;">' + msg.created_at + '</div>';
                            messages.appendChild(div);
                        });
                        messages.scrollTop = messages.scrollHeight;
                    }
                });
        }
        
        // Charger au démarrage
        loadMessages();
        
        // Rafraîchir toutes les 5 secondes
        setInterval(loadMessages, 5000);
    </script>
</body>
</html>
