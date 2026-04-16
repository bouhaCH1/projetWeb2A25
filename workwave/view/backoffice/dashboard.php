<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - Dashboard</title>
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
            transition: all 0.3s;
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
        
        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }
        
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
        
        /* Chart Cards */
        .chart-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .chart-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        
        .status-item, .category-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        .status-completed { background: #d4edda; color: #155724; }
        .status-progress { background: #fff3cd; color: #856404; }
        .status-planned { background: #cce5ff; color: #004085; }
        
        .project-list {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .project-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .project-item:hover {
            background: #f8f9fa;
        }
        
        .btn-sm {
            padding: 5px 12px;
            border-radius: 20px;
            margin: 0 3px;
        }
        
        .btn-edit {
            background: #ffc107;
            color: #333;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
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
            <a href="index.php?action=back-dashboard" class="active">
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
                <h2>Dashboard</h2>
            </div>
            <div class="user-info">
                <span><i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                <a href="index.php?action=logout" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <div class="stat-number"><?= $stats['total'] ?></div>
                    <div class="stat-label">Projets total</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number">
                        <?php 
                        $completed = 0;
                        foreach ($stats['by_status'] as $s) {
                            if ($s['status'] == 'completed') $completed = $s['count'];
                        }
                        echo $completed;
                        ?>
                    </div>
                    <div class="stat-label">Projets terminés</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card text-center">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number">
                        <?php 
                        $inProgress = 0;
                        foreach ($stats['by_status'] as $s) {
                            if ($s['status'] == 'in_progress') $inProgress = $s['count'];
                        }
                        echo $inProgress;
                        ?>
                    </div>
                    <div class="stat-label">Projets en cours</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Status Distribution -->
            <div class="col-md-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-chart-pie"></i> Distribution par statut
                    </div>
                    <?php foreach ($stats['by_status'] as $status): ?>
                        <div class="status-item">
                            <span>
                                <?php if ($status['status'] == 'completed'): ?>
                                    <span class="status-badge status-completed">✓ Terminé</span>
                                <?php elseif ($status['status'] == 'in_progress'): ?>
                                    <span class="status-badge status-progress">🔄 En cours</span>
                                <?php else: ?>
                                    <span class="status-badge status-planned">📅 Planifié</span>
                                <?php endif; ?>
                            </span>
                            <span><strong><?= $status['count'] ?></strong> projet(s)</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Category Distribution -->
            <div class="col-md-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="fas fa-chart-bar"></i> Distribution par catégorie
                    </div>
                    <?php foreach ($stats['by_category'] as $category): ?>
                        <div class="category-item">
                            <span><i class="fas fa-tag"></i> <?= htmlspecialchars($category['category']) ?></span>
                            <span><strong><?= $category['count'] ?></strong> projet(s)</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Recent Projects -->
        <div class="chart-card">
            <div class="chart-title">
                <i class="fas fa-history"></i> Derniers projets ajoutés
            </div>
            <div class="project-list">
                <?php if (empty($recentProjects)): ?>
                    <p class="text-center text-muted">Aucun projet pour le moment</p>
                <?php else: ?>
                    <?php foreach ($recentProjects as $project): ?>
                        <div class="project-item">
                            <div>
                                <strong><?= htmlspecialchars($project['title']) ?></strong>
                                <br>
                                <small class="text-muted"><?= htmlspecialchars($project['category']) ?></small>
                            </div>
                            <div>
                                <a href="index.php?action=back-edit&id=<?= $project['id'] ?>" class="btn btn-sm btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?action=back-delete&id=<?= $project['id'] ?>" class="btn btn-sm btn-delete" onclick="return confirm('Supprimer ce projet ?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>