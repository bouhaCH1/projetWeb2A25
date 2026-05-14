<?php

session_start();

require_once __DIR__ . '/UserController.php';
require_once __DIR__ . '/missionController.php';
require_once __DIR__ . '/ManagerController.php';
require_once __DIR__ . '/PortfolioController.php';
if (file_exists(__DIR__ . '/ClientController.php')) {
    require_once __DIR__ . '/ClientController.php';
}

$action = $_GET['action'] ?? 'home';
$controller = new UserController();

switch ($action) {
    case 'portfolio':
        (new PortfolioController())->handle($_GET['r'] ?? 'home');
        break;

    case 'register':
        $controller->showRegister();
        break;
    case 'register_submit':
        $controller->register();
        break;
    case 'login':
        $controller->showLogin();
        break;
    case 'login_submit':
        $controller->login();
        break;
    case 'login_2fa':
        $controller->showLogin2FA();
        break;
    case 'login_2fa_submit':
        $controller->processLogin2FA();
        break;
    case 'send_2fa_code':
        $controller->send2FACode();
        break;
    case 'forgot_password':
        $controller->showForgotPassword();
        break;
    case 'forgot_password_submit':
        $controller->processForgotPassword();
        break;
    case 'reset_password':
        $controller->showResetPassword();
        break;
    case 'reset_password_submit':
        $controller->processResetPassword();
        break;

    case 'profile':
        $controller->showProfile();
        break;
    case 'profile_update':
        $controller->updateProfile();
        break;
    case 'security':
        $controller->showSecurity();
        break;
    case 'export_data':
        $controller->exportData();
        break;
    case 'verify_identity':
        $controller->showVerifyIdentity();
        break;
    case 'verify_identity_submit':
        $controller->processVerifyIdentity();
        break;
    case 'toggle_2fa':
        $controller->toggle2FA();
        break;
    case 'delete_account':
        $controller->selfDeleteAccount();
        break;
    case 'ai_analyze':
        $controller->showAnalyzeProfile();
        break;
    case 'ai_analyze_submit':
        $controller->analyzeProfile();
        break;
    case 'maps_api':
        // Google Maps API proxy for location-based job search
        $location = trim($_GET['location'] ?? 'Tunis');
        $apiKey = 'YOUR_GOOGLE_MAPS_API_KEY'; // Replace with real key
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($location) . "&key=$apiKey";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($ch);
        curl_close($ch);
        header('Content-Type: application/json');
        echo $resp ?: json_encode(['status' => 'error', 'message' => 'Maps API error']);
        exit;
    case 'salary_api':
        // Salary data API for compensation insights
        $jobTitle = trim($_GET['job_title'] ?? 'developer');
        $location = trim($_GET['location'] ?? 'Tunis');
        $url = "https://api.apilayer.com/salary/salary?job_title=" . urlencode($jobTitle) . "&location=" . urlencode($location);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['apikey: YOUR_SALARY_API_KEY']);
        $resp = curl_exec($ch);
        curl_close($ch);
        header('Content-Type: application/json');
        echo $resp ?: json_encode(['status' => 'error', 'message' => 'Salary API error']);
        exit;
    case 'linkedin_import':
        // LinkedIn profile import simulation
        $controller->showLinkedInImport();
        break;
    case 'linkedin_import_submit':
        $controller->processLinkedInImport();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'dashboard_seeker':
        $controller = new UserController();
        $stats = $controller->getDashboardStats();
        require_once __DIR__ . '/../View/user/dashboard_seeker.php';
        break;
    case 'dashboard_employer':
        $controller = new UserController();
        $stats = $controller->getDashboardStats();
        require_once __DIR__ . '/../View/user/dashboard_employer.php';
        break;
    case 'interview_scheduling':
        require_once __DIR__ . '/../View/user/interview_scheduling.php';
        break;
    case 'ai_job_matching':
        require_once __DIR__ . '/../View/user/ai_job_matching.php';
        break;
    case 'ai_parse_resume':
        $aiController = new AIController();
        $resumeText = $_POST['resume_text'] ?? '';
        $result = $aiController->parseResume($resumeText);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_job_match':
        $aiController = new AIController();
        $userId = (int) $_SESSION['user_id'];
        $jobId = (int) ($_POST['job_id'] ?? 0);
        $result = $aiController->calculateJobMatch($userId, $jobId);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_career_recommendations':
        $aiController = new AIController();
        $userId = (int) $_SESSION['user_id'];
        $result = $aiController->getCareerRecommendations($userId);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_salary_analysis':
        $aiController = new AIController();
        $userId = (int) $_SESSION['user_id'];
        $jobId = (int) ($_POST['job_id'] ?? 0);
        $result = $aiController->getSalaryAnalysis($userId, $jobId);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_interview_coach':
        require_once __DIR__ . '/../View/user/ai_interview_coach.php';
        break;
    case 'ai_user_management':
        require_once __DIR__ . '/../View/admin/ai_user_management.php';
        break;
    case 'ai_user_management_simple':
        require_once __DIR__ . '/../View/admin/ai_user_management_simple.php';
        break;
    case 'ai_user_segmentation':
        require_once __DIR__ . '/AdminAIController.php';
        $aiController = new AdminAIController();
        $result = $aiController->getUserSegmentation();
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_journey_mapping':
        require_once __DIR__ . '/AdminAIController.php';
        $aiController = new AdminAIController();
        $result = $aiController->getUserJourneyMapping();
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_fraud_detection':
        require_once __DIR__ . '/AdminAIController.php';
        $aiController = new AdminAIController();
        $result = $aiController->getFraudDetection();
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_satisfaction_prediction':
        require_once __DIR__ . '/AdminAIController.php';
        $aiController = new AdminAIController();
        $result = $aiController->getUserSatisfactionPrediction();
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_admin_recommendations':
        require_once __DIR__ . '/AdminAIController.php';
        $aiController = new AdminAIController();
        $result = $aiController->getAdminRecommendations();
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'job_search':
        require_once __DIR__ . '/../View/user/enhanced_job_search.php';
        break;
    case 'admin_login':
        $controller->showAdminLogin();
        break;
    case 'admin_login_submit':
        $controller->adminLogin();
        break;
    case 'admin_dashboard':
        $controller->adminDashboard();
        break;
    case 'admin_users':
        $controller->adminListUsers();
        break;
    case 'admin_add_user':
        $controller->adminShowAddUser();
        break;
    case 'admin_add_user_submit':
        $controller->adminAddUser();
        break;
    case 'admin_edit_user':
        $controller->adminEditUser();
        break;
    case 'admin_update_user':
        $controller->adminUpdateUser();
        break;
    case 'admin_delete_user':
        $controller->adminDeleteUser();
        break;
    case 'admin_toggle_user':
        $controller->adminToggleUserStatus();
        break;
    case 'admin_toggle_verify':
        $controller->adminToggleVerification();
        break;

    // --- Admin Mission Routes ---
    case 'admin_missions':
        $missionController = new MissionController();
        $missionController->index();
        break;
    case 'admin_mission_create':
        $missionController = new MissionController();
        $missionController->create();
        break;
    case 'admin_mission_edit':
        $missionController = new MissionController();
        $missionController->edit();
        break;
    case 'admin_mission_delete':
        $missionController = new MissionController();
        $missionController->delete();
        break;
    case 'admin_mission_candidatures':
        $missionController = new MissionController();
        $missionController->candidatures();
        break;
    case 'admin_mission_delete_candidature':
        $missionController = new MissionController();
        $missionController->deleteCandidature();
        break;

    // --- Ayoub's API Integrations (Events, Resources, Payments) ---
    case 'admin_events':
        require_once __DIR__ . '/EventController.php';
        $eventCtrl = new EventController();
        $eventCtrl->adminEvents();
        break;
    case 'user_events':
        require_once __DIR__ . '/EventController.php';
        $eventCtrl = new EventController();
        $eventCtrl->showUserEvents();
        break;
    case 'save_payment':
        require_once __DIR__ . '/EventController.php';
        $eventCtrl = new EventController();
        $eventCtrl->savePayment();
        break;

    // --- Event CRUD ---
    case 'form_event':
        require_once __DIR__ . '/EventController.php';
        (new EventController())->formEvent();
        break;
    case 'save_event':
        require_once __DIR__ . '/EventController.php';
        (new EventController())->saveEvent();
        break;
    case 'delete_event':
        require_once __DIR__ . '/EventController.php';
        (new EventController())->deleteEvent();
        break;

    // --- Resource CRUD ---
    case 'form_resource':
        require_once __DIR__ . '/EventController.php';
        (new EventController())->formResource();
        break;
    case 'save_resource':
        require_once __DIR__ . '/EventController.php';
        (new EventController())->saveResource();
        break;
    case 'delete_resource':
        require_once __DIR__ . '/EventController.php';
        (new EventController())->deleteResource();
        break;
    case 'ajax_chatbot':
        header('Content-Type: application/json');
        $msg = trim($_POST['message'] ?? '');
        if (!$msg) {
            echo json_encode(['reply' => 'Comment puis-je vous aider ?']);
            exit;
        }

        $msgLower = mb_strtolower($msg, 'UTF-8');
        $reply = "Je ne suis pas sûr de comprendre. Pouvez-vous reformuler ? Je peux vous aider avec votre **profil**, la **2FA**, les **Missions**, les **Candidatures**, les **Événements**, le **Matériel**, ou l'**Analyse IA**.";

        // ===== MISSIONS =====
        if (preg_match('/\b(créer|creer|publier|nouvelle|ajouter|poster).*(mission)/i', $msgLower) ||
            preg_match('/\b(mission).*(créer|creer|publier|nouvelle|ajouter|poster)/i', $msgLower)) {
            $reply = "Pour **publier une mission** :\n1. Allez dans **'Missions'** dans le menu de gauche.\n2. Cliquez sur le bouton **'Publier'** (icône +).\n3. Remplissez le titre, la description, le budget, les dates et les compétences requises.\n4. Utilisez le bouton **'Analyser avec l'IA'** pour détecter automatiquement la catégorie, le niveau et les compétences ! 🤖\n5. Cliquez sur **'Enregistrer'** pour publier votre mission.";
        } elseif (preg_match('/\b(postuler|candidater|appliquer|apply).*(mission)?/i', $msgLower) ||
                  preg_match('/\b(comment).*(postuler)/i', $msgLower)) {
            $reply = "Pour **postuler à une mission** :\n1. Allez dans **'Missions'** dans le menu.\n2. Parcourez les missions disponibles.\n3. Cliquez sur **'Postuler'** sur la mission qui vous intéresse.\n4. Remplissez le formulaire (nom, email, téléphone, motivation).\n5. Vous pouvez aussi joindre votre **CV** (PDF, DOC, max 5MB).\n6. Soumettez et attendez la réponse de l'employeur ! 📩";
        } elseif (preg_match('/\b(mes missions|mes.mission|gérer.mission|gerer.mission|supprimer.mission|modifier.mission)/i', $msgLower)) {
            $reply = "Pour **gérer vos missions publiées** :\n1. Allez dans **'Missions'** puis cliquez sur **'Mes Missions'**.\n2. Vous verrez toutes vos missions avec leur statut (Ouverte, En cours, Terminée).\n3. Cliquez sur **'Modifier'** ✏️ pour éditer une mission.\n4. Cliquez sur l'icône **Supprimer** 🗑️ pour effacer une mission.\n\n⚠️ La suppression d'une mission supprime aussi toutes ses candidatures !";
        } elseif (preg_match('/\b(candidature|candidatures|mes candidatures|voir candidature)/i', $msgLower) &&
                  !preg_match('/\b(postuler|appliquer)/i', $msgLower)) {
            $reply = "Pour **voir vos candidatures** :\n1. Allez dans **'Missions'** dans le menu.\n2. Cliquez sur **'Candidatures'** dans la page.\n3. Vous pouvez filtrer par email pour retrouver vos candidatures.\n4. Les statuts possibles sont :\n   - 🟡 **En attente** : l'employeur n'a pas encore répondu.\n   - ✅ **Acceptée** : félicitations, vous avez été retenu !\n   - ❌ **Refusée** : votre candidature n'a pas été retenue.";
        } elseif (preg_match('/\b(statut|status|ouverte|en cours|terminee|terminée)/i', $msgLower) &&
                  preg_match('/\b(mission)/i', $msgLower)) {
            $reply = "Les **statuts d'une mission** signifient :\n- 🟢 **Ouverte** : la mission est disponible, vous pouvez postuler.\n- 🔵 **En cours** : la mission est déjà en cours d'exécution.\n- ⚫ **Terminée** : la mission est clôturée.\n\nSeules les missions **Ouvertes** acceptent de nouvelles candidatures.";
        } elseif (preg_match('/\b(ia|analyser|classifier|catégorie|categorie|niveau|compétence|competence).*(mission)/i', $msgLower) ||
                  preg_match('/\b(mission).*(ia|analyser|classifier)/i', $msgLower)) {
            $reply = "Le bouton **'Analyser avec l'IA'** 🤖 dans le formulaire de création de mission :\n1. Remplissez d'abord le **titre** et la **description** de la mission.\n2. Cliquez sur **'Analyser avec l'IA'**.\n3. L'IA va automatiquement détecter :\n   - 📂 La **catégorie** (Développement, Design, Marketing...)\n   - 📊 Le **niveau** requis (Débutant, Expert...)\n   - 🛠️ Les **compétences** clés nécessaires.\n4. Vous pouvez modifier ces suggestions avant d'enregistrer.";
        } elseif (preg_match('/\b(prédiction|prediction|forecast|demande|candidature.attendue)/i', $msgLower)) {
            $reply = "La **Prédiction de Demande IA** 📈 estime combien de candidatures votre mission recevra :\n1. Dans le formulaire de création, choisissez une **catégorie** et un **niveau**.\n2. Cliquez sur **'Prédire la demande'**.\n3. L'IA analyse vos données historiques et retourne :\n   - 🔢 Le **nombre estimé** de candidatures.\n   - 📊 Le **niveau de confiance** (élevé / moyen / faible).\n   - 💡 Une **explication** du résultat.";
        } elseif (preg_match('/\b(budget|prix|tarif|combien|euro|paiement).*(mission)/i', $msgLower) ||
                  preg_match('/\b(mission).*(budget|prix|tarif)/i', $msgLower)) {
            $reply = "Le **budget d'une mission** représente la rémunération proposée en euros (€) pour le freelancer.\n- Il doit être un **nombre positif** (ex: 500, 1500).\n- Maximum autorisé : **1 000 000 €**.\n- Il est affiché sur la carte de la mission pour aider les candidats à évaluer l'offre. 💰";
        } elseif (preg_match('/\b(mission|missions)\b/i', $msgLower)) {
            $reply = "La section **Missions** vous permet de :\n- 📋 **Voir** toutes les missions disponibles.\n- ✍️ **Publier** une nouvelle mission (si vous êtes employeur).\n- 📨 **Postuler** à une mission qui vous intéresse.\n- 📁 **Gérer** vos missions publiées (Mes Missions).\n- 📊 **Suivre** vos candidatures envoyées.\n\nQue souhaitez-vous faire exactement ?";

        // ===== PROFIL & COMPTE =====
        } elseif (preg_match('/\b(mot de passe|password|oublié)\b/i', $msgLower)) {
            $reply = "Pour changer votre mot de passe, allez dans **'Sécurité & 2FA'** et descendez jusqu'à la section de changement de mot de passe. Si vous n'arrivez pas à vous connecter, utilisez le bouton 'Mot de passe oublié' sur la page de connexion.";
        } elseif (preg_match('/\b(modifier|changer|editer|mettre à jour|nom|prénom|prenom|telephone|téléphone|photo|image|profil)\b/i', $msgLower) && !preg_match('/\b(ia|analyse|coach|mission)\b/i', $msgLower)) {
            $reply = "Pour modifier vos informations (nom, prénom, téléphone, photo, etc.) :\n1. Allez dans l'onglet **'Mon Profil'** dans le menu.\n2. Modifiez les champs souhaités.\n3. Cliquez sur **'Enregistrer les modifications'** au bas de la page.";
        } elseif (preg_match('/\b(2fa|double authentification|sécurité|sms|code|auth)\b/i', $msgLower)) {
            $reply = "Pour activer la **Double Authentification (2FA)** :\n1. Allez dans l'onglet **'Sécurité & 2FA'** dans le menu de gauche.\n2. Cliquez sur le bouton 'Activer la double authentification'.\n3. Lors de votre prochaine connexion, un code à 6 chiffres sera envoyé à votre adresse email !";
        } elseif (preg_match('/\b(ia|analyse|coach|améliorer|perfectionner)\b/i', $msgLower) && !preg_match('/\b(mission|classifier|catégorie)\b/i', $msgLower)) {
            $reply = "L'**Analyse IA** vous aide à perfectionner votre profil professionnel.\n1. Allez dans **'Analyse IA'** dans le menu.\n2. Décrivez vos compétences et expériences.\n3. L'IA va corriger vos fautes, réécrire votre texte de manière professionnelle, et vous suggérer les métiers qui vous correspondent le mieux !";
        } elseif (preg_match('/\b(cin|identité|vérification|ocr|document)\b/i', $msgLower)) {
            $reply = "Pour avoir le **Badge Vérifié** :\n1. Allez dans **'Vérifier CIN'**.\n2. Uploadez une photo de votre pièce d'identité.\n3. Notre IA OCR extraira votre nom et validera instantanément votre compte si les noms correspondent.";
        } elseif (preg_match('/\b(bonjour|salut|hello|coucou)\b/i', $msgLower)) {
            $reply = "Bonjour ! 👋 Je suis l'assistant WorkWave. Je peux vous aider avec :\n- 📋 Les **Missions** (créer, postuler, gérer)\n- 👤 Votre **Profil**\n- 🔒 La **Sécurité & 2FA**\n- 🤖 L'**Analyse IA**\n\nQue puis-je faire pour vous ?";
        } elseif (preg_match('/\b(merci|thanks)\b/i', $msgLower)) {
            $reply = "Avec plaisir ! N'hésitez pas si vous avez d'autres questions. 😊";
        
        // ===== EVENTS & RESOURCES =====
        } elseif (preg_match('/\b(événement|evenement|event|events|conférence|conference|atelier)\b/i', $msgLower)) {
            $reply = "La section **Événements & Services** vous permet de voir les prochains événements (ex: Tech Summit, Ateliers).\n- Si vous êtes un **Employeur** ou **Admin**, vous pouvez **Ajouter (+)**, **Modifier (✏️)** et **Supprimer (🗑️)** des événements.\n- Vous pouvez aussi générer un lien **+ Cal** pour les ajouter à votre Google Agenda ou utiliser le bouton **Payer** pour acheter un billet d'entrée.";
        } elseif (preg_match('/\b(ressource|ressources|matériel|materiel|fourniture|stock)\b/i', $msgLower)) {
            $reply = "Dans la page **Événements & Services**, vous trouverez la liste des **Ressources Disponibles** (matériel, fournitures, salle, etc.).\n- Si vous êtes **Employeur** ou **Admin**, vous avez accès aux boutons pour **Ajouter**, **Modifier** et **Supprimer** les stocks de matériel.\n- Les candidats peuvent s'informer en cliquant sur le bouton **Info**.";
        } elseif (preg_match('/\b(payer|paiement|billet|ticket|stripe)\b/i', $msgLower)) {
            $reply = "Le bouton **Payer** à côté des événements simule une passerelle de paiement sécurisée (type Stripe).\n1. Cliquez sur **Payer** sur un événement.\n2. Une popup s'affiche.\n3. Entrez un faux numéro de carte/RIB et validez.\n4. Vous verrez une belle animation de validation ! 💳✨";
        } elseif (preg_match('/\b(calendrier|agenda|google|gcal|cal)\b/i', $msgLower)) {
            $reply = "Le bouton **+ Cal** à côté des événements vous redirige vers Google Agenda avec un événement pré-rempli portant le titre de l'événement. Vous n'avez plus qu'à l'enregistrer ! 📅";
        }

        // Simulate a small typing delay to feel like a real bot
        usleep(400000); 

        echo json_encode(['reply' => $reply]);
        exit;

    case 'missions':
        $missionController = new MissionController();
        $missionController->frontIndex();
        break;

    // Mission AI & Chat routes
    case 'ai_classify':
        $missionController = new MissionController();
        $missionController->aiClassify();
        break;
    case 'ai_forecast':
        $missionController = new MissionController();
        $missionController->aiForecast();
        break;
    case 'mission_ai_chat':
        $missionController = new MissionController();
        $missionController->aiChat();
        break;
    case 'send_chat_message':
        $missionController = new MissionController();
        $missionController->sendChatMessage();
        break;
    case 'get_chat_messages':
        $missionController = new MissionController();
        $missionController->getChatMessages();
        break;
    case 'get_unread_count':
        $missionController = new MissionController();
        $missionController->getUnreadCount();
        break;
    case 'update_candidature_statut':
        $missionController = new MissionController();
        $missionController->updateCandidatureStatut();
        break;
    case 'generate_email':
        $missionController = new MissionController();
        $missionController->generateEmail();
        break;
    case 'front_create':
        $missionController = new MissionController();
        $missionController->frontCreate();
        break;
    case 'front_edit':
        $missionController = new MissionController();
        $missionController->frontEdit();
        break;
    case 'front_delete':
        $missionController = new MissionController();
        $missionController->frontDelete();
        break;
    case 'front_apply':
        $missionController = new MissionController();
        $missionController->frontApply();
        break;
    case 'front_candidatures':
        $missionController = new MissionController();
        $missionController->frontCandidatures();
        break;
    case 'front_edit_candidature':
        $missionController = new MissionController();
        $missionController->frontEditCandidature();
        break;
    case 'front_delete_candidature':
        $missionController = new MissionController();
        $missionController->frontDeleteCandidature();
        break;
    case 'front_missions':
        $missionController = new MissionController();
        $missionController->frontMissions();
        break;
    case 'front_mes_resultats':
        $missionController = new MissionController();
        $missionController->frontMesResultats();
        break;

    // --- Formations Module Routes ---
    case 'formation':
    case 'formations':
    case 'dashboard':
    case 'formation_add':
    case 'formation_edit':
    case 'formation_delete':
    case 'participants':
    case 'participant_add':
    case 'participant_remove':
    case 'taches':
    case 'tache_add':
    case 'tache_edit':
    case 'tache_delete':
    case 'comment_add':
    case 'comment_delete':
    case 'translate':
    case 'ai_describe':
    case 'quitter':
    case 'participer':
    case 'tache_statut':
        // Bridge WorkWave session to Formation session
        if (isset($_SESSION['user_role']) && !empty($_SESSION['user_id'])) {
            $r = ($_SESSION['user_role'] === 'employer' || $_SESSION['user_role'] === 'admin') ? 'manager' : 'client';
            $_SESSION['role'] = $r;
            
            // Sync user to formation database to prevent foreign key errors
            try {
                require_once __DIR__ . '/../Model/config/database.php';
                $pdo = getDB();
                $table = ($r === 'manager') ? 'managers' : 'clients';
                $uid = (int)$_SESSION['user_id'];
                $stmt = $pdo->prepare("SELECT id FROM {$table} WHERE id = ?");
                $stmt->execute([$uid]);
                if (!$stmt->fetch()) {
                    $nom = $_SESSION['user_last_name'] ?? 'User';
                    $prenom = $_SESSION['user_first_name'] ?? 'Test';
                    $email = $_SESSION['user_email'] ?? ($uid . '@workwave.test');
                    $insert = $pdo->prepare("INSERT INTO {$table} (id, nom, prenom, email, password) VALUES (?, ?, ?, ?, 'sync')");
                    $insert->execute([$uid, $nom, $prenom, $email]);
                }
            } catch (Exception $e) {}
            
            if ($r === 'manager') {
                (new ManagerController())->handle($action);
            } else if (class_exists('ClientController')) {
                (new ClientController())->handle($action);
            }
        }
        break;

    case 'home':
    default:
        require_once __DIR__ . '/../View/layout/pl_header.php';
        require_once __DIR__ . '/../View/layout/home.php';
        require_once __DIR__ . '/../View/layout/pl_footer.php';
        break;
}
