<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - <?= isset($task) ? 'Modifier' : 'Ajouter' ?> une tâche</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fb; }
        
        .sidebar {
            position: fixed; left: 0; top: 0; height: 100vh; width: 280px;
            background: linear-gradient(135deg, #1a1a2e, #16213e); color: white;
        }
        .sidebar-header { padding: 30px 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h3 { font-size: 1.5rem; margin-top: 10px; }
        .sidebar-menu { padding: 20px 0; }
        .sidebar-menu a {
            display: block; padding: 15px 25px; color: rgba(255,255,255,0.8);
            text-decoration: none; transition: 0.3s;
        }
        .sidebar-menu a:hover {
            background: rgba(102, 126, 234, 0.3); color: white; padding-left: 35px;
        }
        .sidebar-menu i { margin-right: 10px; width: 25px; }
        
        .main-content { margin-left: 280px; padding: 20px; }
        
        .top-bar {
            background: white; padding: 20px 30px; border-radius: 15px; margin-bottom: 30px;
            display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .page-title h2 { font-size: 1.5rem; color: #333; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .logout-btn {
            background: linear-gradient(135deg, #667eea, #764ba2); color: white;
            border: none; padding: 8px 20px; border-radius: 25px; text-decoration: none;
        }
        
        .form-container {
            background: white; border-radius: 15px; padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .form-group label .required { color: #dc3545; margin-left: 5px; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0;
            border-radius: 10px; font-size: 1rem; transition: 0.3s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none; border-color: #667eea;
        }
        .form-group input.is-invalid, .form-group select.is-invalid, .form-group textarea.is-invalid {
            border-color: #dc3545;
        }
        .error-message { color: #dc3545; font-size: 0.85rem; margin-top: 5px; }
        .info-text { font-size: 0.85rem; color: #666; margin-top: 5px; }
        
        .form-actions { display: flex; gap: 15px; margin-top: 30px; }
        .btn-submit {
            background: linear-gradient(135deg, #667eea, #764ba2); color: white;
            border: none; padding: 12px 30px; border-radius: 10px;
            font-size: 1rem; font-weight: 600; cursor: pointer; transition: 0.3s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .btn-cancel {
            background: #6c757d; color: white; border: none; padding: 12px 30px;
            border-radius: 10px; font-size: 1rem; font-weight: 600;
            text-decoration: none; text-align: center; transition: 0.3s;
        }
        .btn-cancel:hover { background: #5a6268; color: white; }
        
        .alert { border-radius: 10px; margin-bottom: 20px; }
        .alert-error { background: #f8d7da; color: #721c24; border: none; }
        
        .project-info {
            background: linear-gradient(135deg, #667eea10, #764ba210);
            border-radius: 10px; padding: 15px; margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-waveform" style="font-size: 2.5rem;"></i>
            <h3>Work Wave</h3>
            <p style="font-size: 0.85rem;">Espace Administrateur</p>
        </div>
        <div class="sidebar-menu">
            <a href="index.php?action=back-dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="index.php?action=back-list"><i class="fas fa-project-diagram"></i> Tous les projets</a>
            <a href="index.php?action=back-tasks&id=<?= $project['id'] ?>"><i class="fas fa-tasks"></i> Gestion des tâches</a>
        </div>
    </div>
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h2><i class="fas fa-<?= isset($task) ? 'edit' : 'plus-circle' ?>"></i> <?= isset($task) ? 'Modifier la tâche' : 'Ajouter une tâche' ?></h2>
            </div>
            <div class="user-info">
                <span><i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                <a href="index.php?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </div>
        </div>
        
        <!-- Affichage des erreurs -->
        <?php if (isset($_SESSION['task_errors']) && !empty($_SESSION['task_errors'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> Veuillez corriger les erreurs suivantes :
                <ul class="mb-0 mt-2">
                    <?php foreach ($_SESSION['task_errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['task_errors']); ?>
        <?php endif; ?>
        
        <div class="form-container">
            <div class="project-info">
                <i class="fas fa-project-diagram"></i> <strong>Projet :</strong> <?= htmlspecialchars($project['title']) ?>
            </div>
            
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title">Titre de la tâche <span class="required">*</span></label>
                            <input type="text" id="title" name="title" 
                                   value="<?= htmlspecialchars($task['title'] ?? '') ?>"
                                   placeholder="Ex: Développer le module d'authentification"
                                   required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      placeholder="Décrivez la tâche en détail..."><?= htmlspecialchars($task['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="assigned_to">Assigné à</label>
                            <input type="text" id="assigned_to" name="assigned_to" 
                                   value="<?= htmlspecialchars($task['assigned_to'] ?? '') ?>"
                                   placeholder="Nom de la personne responsable">
                            <div class="info-text">Qui est responsable de cette tâche ?</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="priority">Priorité <span class="required">*</span></label>
                            <select id="priority" name="priority" required>
                                <option value="low" <?= (($task['priority'] ?? '') == 'low') ? 'selected' : '' ?>>🟢 Basse</option>
                                <option value="medium" <?= (($task['priority'] ?? '') == 'medium') ? 'selected' : '' ?>>🟠 Moyenne</option>
                                <option value="high" <?= (($task['priority'] ?? '') == 'high') ? 'selected' : '' ?>>🔴 Haute</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Statut <span class="required">*</span></label>
                            <select id="status" name="status" required>
                                <option value="todo" <?= (($task['status'] ?? '') == 'todo') ? 'selected' : '' ?>>📋 À faire</option>
                                <option value="in_progress" <?= (($task['status'] ?? '') == 'in_progress') ? 'selected' : '' ?>>🔄 En cours</option>
                                <option value="review" <?= (($task['status'] ?? '') == 'review') ? 'selected' : '' ?>>👁️ En relecture</option>
                                <option value="done" <?= (($task['status'] ?? '') == 'done') ? 'selected' : '' ?>>✅ Terminé</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="due_date">Date d'échéance</label>
                            <input type="date" id="due_date" name="due_date" 
                                   value="<?= htmlspecialchars($task['due_date'] ?? '') ?>">
                            <div class="info-text">Date limite pour cette tâche</div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estimated_hours">Heures estimées</label>
                            <input type="number" id="estimated_hours" name="estimated_hours" 
                                   value="<?= htmlspecialchars($task['estimated_hours'] ?? 0) ?>"
                                   min="0" step="0.5">
                            <div class="info-text">Estimation du temps nécessaire (en heures)</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="actual_hours">Heures réelles</label>
                            <input type="number" id="actual_hours" name="actual_hours" 
                                   value="<?= htmlspecialchars($task['actual_hours'] ?? 0) ?>"
                                   min="0" step="0.5">
                            <div class="info-text">Temps réel passé sur cette tâche (en heures)</div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> <?= isset($task) ? 'Mettre à jour' : 'Enregistrer' ?>
                    </button>
                    <a href="index.php?action=back-tasks&id=<?= $project['id'] ?>" class="btn-cancel">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>