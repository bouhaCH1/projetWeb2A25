<?php
// Demo page with chat widget
session_start();
$_SESSION['candidat_id'] = 2; // Simulate logged in candidat
$_SESSION['user_id'] = 2;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chat Demo - Work Wave</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #0a0e27;
            color: #fff;
            padding: 50px;
            text-align: center;
        }
        h1 {
            color: #00ffcc;
        }
        .info {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: 30px auto;
        }
    </style>
</head>
<body>
    <h1><i class="fas fa-comments"></i> Chat Support Demo</h1>
    <p>Cliquez sur le bouton vert en bas à droite pour ouvrir le chat.</p>
    
    <div class="info">
        <h3>API Endpoints créés :</h3>
        <ul style="text-align:left; line-height:2;">
            <li><code>POST index.php?action=sendChatMessage</code> - Envoyer message</li>
            <li><code>GET index.php?action=getChatMessages</code> - Récupérer messages</li>
            <li><code>GET index.php?action=getUnreadCount</code> - Messages non lus</li>
        </ul>
    </div>
    
    <div class="info">
        <h3>Installation :</h3>
        <ol style="text-align:left;">
            <li>Importer <code>Controller/sql/chat_messages.sql</code> dans MySQL</li>
            <li>Inclure <code>include 'View/chat-widget.php';</code> dans n'importe quelle page</li>
            <li>Assurez-vous que session user_id est défini</li>
        </ol>
    </div>

<?php include __DIR__ . '/../chat-widget.php'; ?>
</body>
</html>
