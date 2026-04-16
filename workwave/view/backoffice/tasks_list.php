<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - Tâches du projet</title>
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
        .sidebar-menu a:hover, .sidebar-menu a.active {
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
        
        .card { border: none; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .card-header {
            background: linear-gradient(135deg, #667eea, #764ba2); color: white;
            border-radius: 15px 15px 0 0 !important; padding: 15px 20px;
        }
        
        .priority-badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; }
        .priority-high { background: #dc3545; color: white; }
        .priority-medium { background: #ffc107; color: #333; }
        .priority-low { background: #28a745; color: white; }
        
        .status-badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; }
        .status-todo { background: #6c757d; color: white; }
        .status-progress { background: #17a2b8; color: white; }
        .status-review { background: #fd7e14; color: white; }
        .status-done { background: #28a745; color: white; }
        
        .task-card {
            background: white; border-radius: 12px; padding: 15px; margin-bottom: 15px;
            border-left: 4px solid #667eea; transition: 0.3s;
        }
        .task-card:hover { transform: translateX(5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        
        .member-item {
            background: #f8f9fa; border-radius: 10px; padding: 10px 15px; margin-bottom: 10px;
            display: flex; justify-content: space-between; align-items: center;
        }
        
        .btn-sm { padding: 5px 12px; border-radius: 20px; margin: 0 3px; }
        .btn-edit { background: #ffc107; color: #333; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-add { background: #28a745; color: white; }
        
        .alert { border-radius: 10px; margin-bottom: 20px; }
        .progress-bar-custom { background: linear-gradient(135deg, #667eea, #764ba2); }
        
        .modal-content { border-radius: 15px; }
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
            <a href="index.php?action=back-tasks&id=<?= $project['id'] ?>" class="active"><i class="fas fa-tasks"></i> Gestion des tâches</a>
        </div>
    </div>
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h2><i class="fas fa-tasks"></i> Tâches du projet : <?= htmlspecialchars($project['title']) ?></h2>
            </div>
            <div class="user-info">
                <span><i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                <a href="index.php?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </div>
        </div>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] == 'success' ? 'success' : 'danger' ?>">
                <i class="fas fa-<?= $_SESSION['message_type'] == 'success' ? 'check-circle' : 'exclamation-triangle' ?>"></i>
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>
        
        <div class="row">
            <!-- Liste des tâches -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-list-check"></i> Liste des tâches
                        <a href="index.php?action=back-create-task&id=<?= $project['id'] ?>" class="btn btn-sm btn-add" style="float: right; background: white; color: #667eea;">
                            <i class="fas fa-plus"></i> Nouvelle tâche
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($tasks)): ?>
                            <div class="text-center text-muted" style="padding: 50px;">
                                <i class="fas fa-clipboard-list" style="font-size: 3rem; margin-bottom: 15px;"></i>
                                <p>Aucune tâche pour ce projet</p>
                                <a href="index.php?action=back-create-task&id=<?= $project['id'] ?>" class="btn btn-add">Créer la première tâche</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($tasks as $task): ?>
                                <div class="task-card">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <h6 style="font-weight: bold;"><?= htmlspecialchars($task['title']) ?></h6>
                                            <small class="text-muted"><?= htmlspecialchars(substr($task['description'] ?? '', 0, 60)) ?></small>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="priority-badge priority-<?= $task['priority'] ?>">
                                                <?php if ($task['priority'] == 'high'): ?>🔴 Haute
                                                <?php elseif ($task['priority'] == 'medium'): ?>🟠 Moyenne
                                                <?php else: ?>🟢 Basse<?php endif; ?>
                                            </span>
                                        </div>
                                        <div class="col-md-2">
                                            <form method="POST" action="index.php?action=back-update-task-status" style="display: inline;">
                                                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                                    <option value="todo" <?= $task['status'] == 'todo' ? 'selected' : ?>>📋 À faire</option>
                                                    <option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : ?>>🔄 En cours</option>
                                                    <option value="review" <?= $task['status'] == 'review' ? 'selected' : ?>>👁️ En relecture</option>
                                                    <option value="done" <?= $task['status'] == 'done' ? 'selected' : ?>>✅ Terminé</option>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <?php if ($task['assigned_to']): ?>
                                                <small><i class="fas fa-user"></i> <?= htmlspecialchars($task['assigned_to']) ?></small><br>
                                            <?php endif; ?>
                                            <?php if ($task['due_date']): ?>
                                                <small><i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($task['due_date'])) ?></small>
                                            <?php endif; ?>
                                            <div class="mt-2">
                                                <a href="index.php?action=back-edit-task&id=<?= $task['id'] ?>" class="btn-sm btn-edit"><i class="fas fa-edit"></i></a>
                                                <a href="index.php?action=back-delete-task&id=<?= $task['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('Supprimer cette tâche ?')"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Membres de l'équipe -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-users"></i> Membres de l'équipe
                        <button type="button" class="btn btn-sm btn-add" style="float: right; background: white; color: #667eea;" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                            <i class="fas fa-user-plus"></i> Ajouter
                        </button>
                    </div>
                    <div class="card-body">
                        <?php if (empty($members)): ?>
                            <div class="text-center text-muted" style="padding: 30px;">
                                <i class="fas fa-users" style="font-size: 2rem;"></i>
                                <p>Aucun membre dans l'équipe</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($members as $member): ?>
                                <div class="member-item">
                                    <div>
                                        <strong><i class="fas fa-user-circle"></i> <?= htmlspecialchars($member['member_name']) ?></strong>
                                        <?php if ($member['member_email']): ?>
                                            <br><small class="text-muted"><?= htmlspecialchars($member['member_email']) ?></small>
                                        <?php endif; ?>
                                        <br><small><span class="badge bg-info"><?= htmlspecialchars($member['role']) ?></span></small>
                                    </div>
                                    <a href="index.php?action=back-remove-member&member_id=<?= $member['id'] ?>&project_id=<?= $project['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('Retirer ce membre ?')">
                                        <i class="fas fa-user-minus"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Progression du projet -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-line"></i> Progression
                    </div>
                    <div class="card-body">
                        <?php
                        $total = count($tasks);
                        $done = 0;
                        foreach ($tasks as $task) {
                            if ($task['status'] == 'done') $done++;
                        }
                        $percentage = $total > 0 ? round(($done / $total) * 100) : 0;
                        ?>
                        <div class="text-center mb-3">
                            <h3><?= $percentage ?>%</h3>
                            <p class="text-muted">Tâches terminées</p>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar progress-bar-custom" style="width: <?= $percentage ?>%"></div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <div class="col-6">
                                <h5><?= count($tasks) ?></h5>
                                <small class="text-muted">Total tâches</small>
                            </div>
                            <div class="col-6">
                                <h5><?= count($members) ?></h5>
                                <small class="text-muted">Membres</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Ajouter Membre -->
    <div class="modal fade" id="addMemberModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="index.php?action=back-add-member&id=<?= $project['id'] ?>">
                    <div class="modal-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                        <h5 class="modal-title"><i class="fas fa-user-plus"></i> Ajouter un membre</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nom du membre *</label>
                            <input type="text" name="member_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="member_email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Rôle</label>
                            <select name="role" class="form-control">
                                <option value="contributor">Contributeur</option>
                                <option value="developer">Développeur</option>
                                <option value="designer">Designer</option>
                                <option value="lead">Lead</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-add">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>