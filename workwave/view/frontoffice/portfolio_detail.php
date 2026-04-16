<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - <?= htmlspecialchars($project['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fb; }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
        }
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .detail-container { padding: 120px 0 80px; }
        .detail-card {
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .detail-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 40px;
            color: white;
        }
        .detail-header h1 { font-size: 2.5rem; font-weight: bold; margin-bottom: 20px; }
        .detail-body { padding: 40px; }
        
        .info-section { margin-bottom: 30px; }
        .info-title { font-size: 1.2rem; font-weight: bold; color: #667eea; margin-bottom: 15px; }
        .tech-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.9rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: bold;
        }
        .status-completed { background: #d4edda; color: #155724; }
        .status-progress { background: #fff3cd; color: #856404; }
        .status-planned { background: #cce5ff; color: #004085; }
        
        .btn-back {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-back:hover { transform: scale(1.05); color: white; }
        
        /* Tâches */
        .tasks-section { background: white; border-radius: 30px; padding: 30px; box-shadow: 0 20px 50px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .section-title { font-size: 1.5rem; font-weight: bold; margin-bottom: 20px; color: #333; }
        .task-item {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
        }
        .priority-high { border-left-color: #dc3545; }
        .priority-medium { border-left-color: #ffc107; }
        .priority-low { border-left-color: #28a745; }
        
        .status-todo { background: #6c757d; color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .status-progress { background: #17a2b8; color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .status-review { background: #fd7e14; color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .status-done { background: #28a745; color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        
        /* Membres */
        .members-section { background: white; border-radius: 30px; padding: 30px; box-shadow: 0 20px 50px rgba(0,0,0,0.1); }
        .member-card {
            background: linear-gradient(135deg, #667eea10, #764ba210);
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            margin-bottom: 15px;
        }
        
        footer {
            background: #1a1a2e;
            color: white;
            padding: 40px 0;
            text-align: center;
            margin-top: 50px;
        }
        
        .progress-bar-custom { background: linear-gradient(135deg, #667eea, #764ba2); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">🌊 Work Wave</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?action=login">Admin</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container detail-container">
    <div class="row">
        <div class="col-lg-8">
            <!-- Détails du projet -->
            <div class="detail-card">
                <div class="detail-header">
                    <h1><?= htmlspecialchars($project['title']) ?></h1>
                    <div class="mt-3">
                        <?php if ($project['status'] == 'completed'): ?>
                            <span class="status-badge status-completed"><i class="fas fa-check-circle"></i> Projet terminé</span>
                        <?php elseif ($project['status'] == 'in_progress'): ?>
                            <span class="status-badge status-progress"><i class="fas fa-clock"></i> Projet en cours</span>
                        <?php else: ?>
                            <span class="status-badge status-planned"><i class="fas fa-calendar-alt"></i> Projet planifié</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="detail-body">
                    <div class="info-section">
                        <div class="info-title"><i class="fas fa-align-left"></i> Description</div>
                        <p style="line-height: 1.8;"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-section">
                                <div class="info-title"><i class="fas fa-tags"></i> Catégorie</div>
                                <p><strong><?= htmlspecialchars($project['category']) ?></strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-section">
                                <div class="info-title"><i class="fas fa-code"></i> Technologies</div>
                                <div>
                                    <?php 
                                    $techs = explode(',', $project['technologies']);
                                    foreach ($techs as $tech): 
                                    ?>
                                        <span class="tech-badge"><?= htmlspecialchars(trim($tech)) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ($project['project_url']): ?>
                    <div class="info-section">
                        <div class="info-title"><i class="fas fa-link"></i> Lien du projet</div>
                        <a href="<?= htmlspecialchars($project['project_url']) ?>" target="_blank" class="btn-back">
                            Visiter le projet <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Liste des tâches -->
            <div class="tasks-section">
                <div class="section-title">
                    <i class="fas fa-tasks"></i> Tâches du projet
                    <?php if (!empty($tasks)): ?>
                        <span class="badge bg-secondary float-end"><?= count($tasks) ?> tâches</span>
                    <?php endif; ?>
                </div>
                
                <?php if (empty($tasks)): ?>
                    <div class="text-center text-muted" style="padding: 40px;">
                        <i class="fas fa-clipboard-list" style="font-size: 3rem; margin-bottom: 15px;"></i>
                        <p>Aucune tâche pour ce projet pour le moment.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <div class="task-item priority-<?= $task['priority'] ?>">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h6 style="font-weight: bold;"><?= htmlspecialchars($task['title']) ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars(substr($task['description'] ?? '', 0, 80)) ?></small>
                                </div>
                                <div class="col-md-3">
                                    <?php if ($task['assigned_to']): ?>
                                        <small><i class="fas fa-user"></i> <?= htmlspecialchars($task['assigned_to']) ?></small><br>
                                    <?php endif; ?>
                                    <?php if ($task['due_date']): ?>
                                        <small><i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($task['due_date'])) ?></small>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3 text-end">
                                    <span class="status-<?= $task['status'] ?>">
                                        <?php if ($task['status'] == 'todo'): ?>📋 À faire
                                        <?php elseif ($task['status'] == 'in_progress'): ?>🔄 En cours
                                        <?php elseif ($task['status'] == 'review'): ?>👁️ Relecture
                                        <?php else: ?>✅ Terminé<?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <!-- Progression -->
                    <?php
                    $total = count($tasks);
                    $done = 0;
                    foreach ($tasks as $task) {
                        if ($task['status'] == 'done') $done++;
                    }
                    $percentage = $total > 0 ? round(($done / $total) * 100) : 0;
                    ?>
                    <div class="mt-4">
                        <small>Progression : <?= $percentage ?>%</small>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar progress-bar-custom" style="width: <?= $percentage ?>%"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Membres de l'équipe -->
            <div class="members-section">
                <div class="section-title">
                    <i class="fas fa-users"></i> Équipe
                    <?php if (!empty($members)): ?>
                        <span class="badge bg-secondary float-end"><?= count($members) ?> membres</span>
                    <?php endif; ?>
                </div>
                
                <?php if (empty($members)): ?>
                    <div class="text-center text-muted" style="padding: 30px;">
                        <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 10px;"></i>
                        <p>Aucun membre dans l'équipe</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($members as $member): ?>
                        <div class="member-card">
                            <i class="fas fa-user-circle" style="font-size: 2rem; color: #667eea;"></i>
                            <h6 class="mt-2 mb-0"><?= htmlspecialchars($member['member_name']) ?></h6>
                            <small class="text-muted"><?= htmlspecialchars($member['role']) ?></small>
                            <?php if ($member['member_email']): ?>
                                <br><small><i class="fas fa-envelope"></i> <?= htmlspecialchars($member['member_email']) ?></small>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Stats rapides -->
            <div class="members-section mt-4">
                <div class="section-title">
                    <i class="fas fa-chart-line"></i> Statistiques
                </div>
                <div class="row text-center">
                    <div class="col-6">
                        <h3><?= $stats['total_tasks'] ?? 0 ?></h3>
                        <small class="text-muted">Tâches totales</small>
                    </div>
                    <div class="col-6">
                        <h3><?= $stats['total_members'] ?? 0 ?></h3>
                        <small class="text-muted">Membres</small>
                    </div>
                </div>
                <hr>
                <div>
                    <small><strong>Progression des tâches :</strong></small>
                    <?php if (!empty($stats['tasks_by_status'])): ?>
                        <?php foreach ($stats['tasks_by_status'] as $stat): ?>
                            <div class="d-flex justify-content-between mt-2">
                                <span>
                                    <?php if ($stat['status'] == 'todo'): ?>📋 À faire
                                    <?php elseif ($stat['status'] == 'in_progress'): ?>🔄 En cours
                                    <?php elseif ($stat['status'] == 'review'): ?>👁️ Relecture
                                    <?php else: ?>✅ Terminé<?php endif; ?>
                                </span>
                                <span><strong><?= $stat['count'] ?></strong></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted mt-2">Aucune donnée</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="index.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour aux projets
        </a>
    </div>
</div>

<footer>
    <div class="container">
        <p>&copy; 2024 Work Wave - Plateforme intelligente pour l'avenir du travail</p>
        <p>Économie digitale & Entrepreneuriat moderne | Gestion de projets collaboratifs</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>