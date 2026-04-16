<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - <?= $project ? 'Modifier' : 'Ajouter' ?> un projet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fb;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
        }
        
        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h3 {
            font-size: 1.5rem;
            margin-top: 10px;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 15px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: 0.3s;
        }
        
        .sidebar-menu a:hover {
            background: rgba(102, 126, 234, 0.3);
            color: white;
            padding-left: 35px;
        }
        
        .sidebar-menu i {
            margin-right: 10px;
            width: 25px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 20px;
        }
        
        /* Top Bar */
        .top-bar {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .page-title h2 {
            font-size: 1.5rem;
            color: #333;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
        }
        
        .logout-btn:hover {
            color: white;
            opacity: 0.9;
        }
        
        /* Form */
        .form-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-group label .required {
            color: #dc3545;
            margin-left: 5px;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-group input.is-invalid,
        .form-group select.is-invalid,
        .form-group textarea.is-invalid {
            border-color: #dc3545;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: 0.3s;
        }
        
        .btn-cancel:hover {
            background: #5a6268;
            color: white;
        }
        
        .info-text {
            font-size: 0.85rem;
            color: #666;
            margin-top: 5px;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-waveform" style="font-size: 2.5rem;"></i>
            <h3>Work Wave</h3>
            <p style="font-size: 0.85rem;">Espace Administrateur</p>
        </div>
        <div class="sidebar-menu">
            <a href="index.php?action=back-dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="index.php?action=back-list">
                <i class="fas fa-project-diagram"></i> Tous les projets
            </a>
            <a href="index.php?action=back-create">
                <i class="fas fa-plus-circle"></i> Ajouter un projet
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h2><i class="fas fa-<?= $project ? 'edit' : 'plus-circle' ?>"></i> <?= $project ? 'Modifier le projet' : 'Ajouter un nouveau projet' ?></h2>
            </div>
            <div class="user-info">
                <span><i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                <a href="index.php?action=logout" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>
        
        <!-- Affichage des erreurs -->
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> Veuillez corriger les erreurs suivantes :
                <ul class="mb-0 mt-2">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title">Titre du projet <span class="required">*</span></label>
                            <input type="text" id="title" name="title" 
                                   value="<?= htmlspecialchars($project['title'] ?? '') ?>"
                                   class="<?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                                   placeholder="Ex: Application de gestion intelligente">
                            <?php if (isset($errors['title'])): ?>
                                <div class="error-message"><?= htmlspecialchars($errors['title']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description <span class="required">*</span></label>
                            <textarea id="description" name="description" rows="5"
                                      class="<?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                                      placeholder="Décrivez votre projet en détail..."><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
                            <?php if (isset($errors['description'])): ?>
                                <div class="error-message"><?= htmlspecialchars($errors['description']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Catégorie <span class="required">*</span></label>
                            <select id="category" name="category" class="<?= isset($errors['category']) ? 'is-invalid' : '' ?>">
                                <option value="">Sélectionnez une catégorie</option>
                                <option value="Web Development" <?= (($project['category'] ?? '') == 'Web Development') ? 'selected' : '' ?>>Web Development</option>
                                <option value="Mobile App" <?= (($project['category'] ?? '') == 'Mobile App') ? 'selected' : '' ?>>Mobile App</option>
                                <option value="Design" <?= (($project['category'] ?? '') == 'Design') ? 'selected' : '' ?>>Design</option>
                                <option value="AI/ML" <?= (($project['category'] ?? '') == 'AI/ML') ? 'selected' : '' ?>>AI/ML</option>
                                <option value="Blockchain" <?= (($project['category'] ?? '') == 'Blockchain') ? 'selected' : '' ?>>Blockchain</option>
                            </select>
                            <?php if (isset($errors['category'])): ?>
                                <div class="error-message"><?= htmlspecialchars($errors['category']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Statut <span class="required">*</span></label>
                            <select id="status" name="status">
                                <option value="planned" <?= (($project['status'] ?? '') == 'planned') ? 'selected' : '' ?>>Planifié</option>
                                <option value="in_progress" <?= (($project['status'] ?? '') == 'in_progress') ? 'selected' : '' ?>>En cours</option>
                                <option value="completed" <?= (($project['status'] ?? '') == 'completed') ? 'selected' : '' ?>>Terminé</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="technologies">Technologies utilisées <span class="required">*</span></label>
                            <input type="text" id="technologies" name="technologies" 
                                   value="<?= htmlspecialchars($project['technologies'] ?? '') ?>"
                                   class="<?= isset($errors['technologies']) ? 'is-invalid' : '' ?>"
                                   placeholder="Ex: PHP, MySQL, JavaScript, React">
                            <div class="info-text">Séparez les technologies par des virgules</div>
                            <?php if (isset($errors['technologies'])): ?>
                                <div class="error-message"><?= htmlspecialchars($errors['technologies']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image_url">URL de l'image</label>
                            <input type="text" id="image_url" name="image_url" 
                                   value="<?= htmlspecialchars($project['image_url'] ?? '') ?>"
                                   class="<?= isset($errors['image_url']) ? 'is-invalid' : '' ?>"
                                   placeholder="https://exemple.com/image.jpg">
                            <div class="info-text">Optionnel - Lien vers une image du projet</div>
                            <?php if (isset($errors['image_url'])): ?>
                                <div class="error-message"><?= htmlspecialchars($errors['image_url']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="project_url">URL du projet en ligne</label>
                            <input type="text" id="project_url" name="project_url" 
                                   value="<?= htmlspecialchars($project['project_url'] ?? '') ?>"
                                   class="<?= isset($errors['project_url']) ? 'is-invalid' : '' ?>"
                                   placeholder="https://monprojet.com">
                            <div class="info-text">Optionnel - Lien vers la démo du projet</div>
                            <?php if (isset($errors['project_url'])): ?>
                                <div class="error-message"><?= htmlspecialchars($errors['project_url']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Date de début</label>
                            <input type="date" id="start_date" name="start_date" 
                                   value="<?= htmlspecialchars($project['start_date'] ?? '') ?>"
                                   class="<?= isset($errors['start_date']) ? 'is-invalid' : '' ?>">
                            <div class="info-text">Optionnel - Format: AAAA-MM-JJ</div>
                            <?php if (isset($errors['start_date'])): ?>
                                <div class="error-message"><?= htmlspecialchars($errors['start_date']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">Date de fin</label>
                            <input type="date" id="end_date" name="end_date" 
                                   value="<?= htmlspecialchars($project['end_date'] ?? '') ?>"
                                   class="<?= isset($errors['end_date']) ? 'is-invalid' : '' ?>">
                            <div class="info-text">Optionnel - Format: AAAA-MM-JJ</div>
                            <?php if (isset($errors['end_date'])): ?>
                                <div class="error-message"><?= htmlspecialchars($errors['end_date']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> <?= $project ? 'Mettre à jour' : 'Enregistrer' ?>
                    </button>
                    <a href="index.php?action=back-list" class="btn-cancel">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>