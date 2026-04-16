<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - Gestion des projets</title>
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
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
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
        
        /* Table */
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            border-bottom: 2px solid #e0e0e0;
            color: #555;
            font-weight: 600;
        }
        
        .table tbody tr:hover {
            background: #f8f9fa;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-progress {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-planned {
            background: #cce5ff;
            color: #004085;
        }
        
        .btn-action {
            padding: 5px 12px;
            border-radius: 20px;
            margin: 0 3px;
            font-size: 0.85rem;
        }
        
        .btn-edit {
            background: #ffc107;
            color: #333;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-view {
            background: #17a2b8;
            color: white;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: none;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: none;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #999;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
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
            <a href="index.php?action=back-list" class="active">
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
                <h2><i class="fas fa-project-diagram"></i> Gestion des projets</h2>
            </div>
            <div class="user-info">
                <span><i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                <a href="index.php?action=logout" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>
        
        <!-- Messages flash -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] == 'success' ? 'success' : 'error' ?>">
                <i class="fas fa-<?= $_SESSION['message_type'] == 'success' ? 'check-circle' : 'exclamation-triangle' ?>"></i>
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>
        
        <div class="table-container">
            <div class="mb-3">
                <a href="index.php?action=back-create" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none;">
                    <i class="fas fa-plus"></i> Nouveau projet
                </a>
            </div>
            
            <?php if (empty($projects)): ?>
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h4>Aucun projet</h4>
                    <p>Commencez par ajouter votre premier projet</p>
                    <a href="index.php?action=back-create" class="btn btn-primary">Ajouter un projet</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Catégorie</th>
                                <th>Technologies</th>
                                <th>Statut</th>
                                <th>Date création</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td><?= $project['id'] ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($project['title']) ?></strong>
                                        <br>
                                        <small class="text-muted"><?= htmlspecialchars(substr($project['description'], 0, 50)) ?>...</small>
                                    </td>
                                    <td><?= htmlspecialchars($project['category']) ?></td>
                                    <td>
                                        <?php 
                                        $techs = explode(',', $project['technologies']);
                                        $displayTechs = array_slice($techs, 0, 2);
                                        foreach ($displayTechs as $tech): 
                                        ?>
                                            <span class="badge bg-secondary"><?= htmlspecialchars(trim($tech)) ?></span>
                                        <?php endforeach; ?>
                                        <?php if (count($techs) > 2): ?>
                                            <span class="badge bg-light text-dark">+<?= count($techs) - 2 ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($project['status'] == 'completed'): ?>
                                            <span class="status-badge status-completed">
                                                <i class="fas fa-check-circle"></i> Terminé
                                            </span>
                                        <?php elseif ($project['status'] == 'in_progress'): ?>
                                            <span class="status-badge status-progress">
                                                <i class="fas fa-clock"></i> En cours
                                            </span>
                                        <?php else: ?>
                                            <span class="status-badge status-planned">
                                                <i class="fas fa-calendar"></i> Planifié
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($project['created_at'])) ?></td>
                                    <td>
                                        <a href="index.php?action=front-detail&id=<?= $project['id'] ?>" class="btn-action btn-view" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="index.php?action=back-edit&id=<?= $project['id'] ?>" class="btn-action btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?action=back-delete&id=<?= $project['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>