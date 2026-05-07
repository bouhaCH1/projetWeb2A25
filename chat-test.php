<?php
// Simple chat test - direct access
session_start();
$_SESSION['user_id'] = 2;
$_SESSION['candidat_id'] = 2;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chat Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #0a0e27; color: #fff; padding: 50px; font-family: Arial; }
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
            z-index: 9999;
        }
        .chat-widget {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 300px;
            height: 400px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.3);
            z-index: 9998;
            display: none;
        }
        .chat-header {
            background: linear-gradient(135deg, #00ffcc, #00ccff);
            padding: 15px;
            border-radius: 15px 15px 0 0;
            color: #0a0e27;
            font-weight: bold;
        }
        .chat-body {
            height: 280px;
            padding: 15px;
            overflow-y: auto;
            background: #f8f9fa;
            color: #333;
        }
        .chat-input {
            padding: 10px;
            border-top: 1px solid #ddd;
            display: flex;
        }
        .chat-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
        }
        .chat-input button {
            margin-left: 10px;
            padding: 10px 15px;
            background: #00ffcc;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1 style="color:#00ffcc">Chat Test Page</h1>
    <p>Si tu vois pas le bouton vert en bas à droite, y'a un problème CSS.</p>

    <!-- Chat Button -->
    <button class="chat-toggle" onclick="toggleChat()">
        <i class="fas fa-comments"></i>
    </button>

    <!-- Chat Widget -->
    <div class="chat-widget" id="chatWidget">
        <div class="chat-header">
            <i class="fas fa-headset"></i> Support
        </div>
        <div class="chat-body" id="chatBody">
            <p><strong>Support:</strong> Bonjour ! Comment puis-je vous aider ?</p>
        </div>
        <div class="chat-input">
            <input type="text" id="msgInput" placeholder="Votre message...">
            <button onclick="sendMsg()">Envoyer</button>
        </div>
    </div>

    <script>
        function toggleChat() {
            const w = document.getElementById('chatWidget');
            w.style.display = w.style.display === 'block' ? 'none' : 'block';
        }

        async function sendMsg() {
            const input = document.getElementById('msgInput');
            const body = document.getElementById('chatBody');
            const text = input.value.trim();

            if(text) {
                // Add user message
                body.innerHTML += `<div style="margin-bottom:10px; text-align:right">
                    <div style="background:#00ffcc; color:#0a0e27; display:inline-block; padding:8px 12px; border-radius:15px">
                        ${text}
                    </div>
                </div>`;
                input.value = '';
                body.scrollTop = body.scrollHeight;

                // Add loading indicator
                const loadingId = 'loading-' + Date.now();
                body.innerHTML += `<p id="${loadingId}"><em>L'IA réfléchit...</em></p>`;
                body.scrollTop = body.scrollHeight;

                try {
                    const formData = new FormData();
                    formData.append('message', text);

                    const response = await fetch('index.php?action=ai_chat', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();
                    
                    // Remove loading
                    document.getElementById(loadingId).remove();

                    if (result.response) {
                        body.innerHTML += `<div style="margin-bottom:10px">
                            <div style="background:#fff; border:1px solid #ddd; color:#333; display:inline-block; padding:8px 12px; border-radius:15px">
                                <strong>Support:</strong> ${result.response}
                            </div>
                        </div>`;
                    } else {
                        body.innerHTML += `<p style="color:red">Erreur: ${result.error || 'Inconnue'}</p>`;
                    }
                } catch (err) {
                    document.getElementById(loadingId).remove();
                    body.innerHTML += `<p style="color:red">Erreur de connexion</p>`;
                }
                body.scrollTop = body.scrollHeight;
            }
        }
    </script>

<?php 
// Test if session works
if(isset($_SESSION['user_id'])) {
    echo "<p style='color:#00ffcc'>✓ Session active: user_id = " . $_SESSION['user_id'] . "</p>";
} else {
    echo "<p style='color:red'>✗ Session non active</p>";
}
?>
</body>
</html>
