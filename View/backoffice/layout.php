<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - Administration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../View/darkpan-1.0.0/darkpan-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../View/darkpan-1.0.0/darkpan-1.0.0/css/style.css" rel="stylesheet">
    <style>
        /* CSS Variables */
        :root {
            --primary: #EB1616;
            --primary-hover: #d01212;
            --secondary: #191C24;
            --secondary-hover: #1e2229;
            --light: #6C7293;
            --light-hover: #7a82a0;
            --dark: #000000;
            --dark-hover: #0a0a0a;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #17a2b8;
            
            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #EB1616 0%, #d01212 100%);
            --gradient-secondary: linear-gradient(135deg, #191C24 0%, #1e2229 100%);
            --gradient-success: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            --gradient-warning: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            --gradient-danger: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            
            /* Shadows */
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.2);
            --shadow-primary: 0 4px 15px rgba(235, 22, 22, 0.3);
            
            /* Transitions */
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
            --transition-slow: 0.5s ease;
        }

        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background: var(--dark);
            color: var(--light);
            line-height: 1.6;
            transition: background-color var(--transition-normal);
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            color: var(--light);
            margin-bottom: 1rem;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            height: 100vh;
            overflow-y: auto;
            background: var(--secondary);
            transition: all var(--transition-normal);
            z-index: 999;
            box-shadow: var(--shadow-lg);
        }

        .sidebar .navbar {
            padding: 1rem 0;
        }

        .sidebar .navbar-brand {
            margin: 0 1.5rem 2rem;
            padding: 0;
        }

        .sidebar .navbar-brand h3 {
            font-family: 'Roboto', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
            text-align: center;
            transition: color var(--transition-fast);
        }

        .sidebar .navbar-brand h3:hover {
            color: var(--primary-hover);
        }

        .sidebar .navbar-brand h3 i {
            margin-right: 0.5rem;
        }

        /* User Profile */
        .sidebar .d-flex.align-items-center {
            margin: 0 1.5rem 2rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .position-relative {
            position: relative;
        }

        .sidebar .position-relative > div:first-child {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .sidebar .position-relative .bg-success {
            width: 12px;
            height: 12px;
            background: var(--success);
            border: 2px solid var(--secondary);
            position: absolute;
            bottom: 2px;
            right: 2px;
            border-radius: 50%;
        }

        .sidebar .ms-3 h6 {
            font-size: 0.875rem;
            font-weight: 600;
            color: white;
            margin: 0;
        }

        .sidebar .ms-3 span {
            font-size: 0.75rem;
            color: var(--light);
        }

        /* Navigation */
        .sidebar .navbar-nav {
            width: 100%;
            padding: 0 1rem;
        }

        .sidebar .nav-item {
            margin-bottom: 0.25rem;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--light);
            font-weight: 500;
            font-size: 0.875rem;
            border-left: 3px solid transparent;
            border-radius: 0 30px 30px 0;
            outline: none;
            text-decoration: none;
            transition: all var(--transition-normal);
            position: relative;
        }

        .sidebar .nav-link:hover {
            color: var(--primary);
            background: var(--dark);
            border-color: var(--primary);
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            color: var(--primary);
            background: var(--dark);
            border-color: var(--primary);
            font-weight: 600;
        }

        .sidebar .nav-link i {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--dark);
            border-radius: 40px;
            margin-right: 0.75rem;
            transition: all var(--transition-normal);
        }

        .sidebar .nav-link:hover i,
        .sidebar .nav-link.active i {
            background: var(--secondary);
            color: var(--primary);
        }

        /* FrontOffice Link Separator */
        .sidebar .nav-link-front {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--light);
            font-weight: 500;
            border-left: 3px solid var(--secondary);
            border-radius: 0 30px 30px 0;
            outline: none;
            text-decoration: none;
            margin-top: 1rem;
            border-top: 1px solid rgba(108, 114, 147, 0.2);
            padding-top: 1.5rem;
            transition: all var(--transition-normal);
        }

        .sidebar .nav-link-front:hover {
            color: var(--primary);
            background: var(--dark);
            border-color: var(--primary);
            transform: translateX(2px);
        }

        .sidebar .nav-link-front i {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--dark);
            border-radius: 40px;
            margin-right: 0.75rem;
            transition: all var(--transition-normal);
        }

        .sidebar .nav-link-front:hover i {
            background: var(--secondary);
            color: var(--primary);
        }

        /* Content Area */
        .content {
            margin-left: 250px;
            min-height: 100vh;
            background: var(--dark);
            transition: all var(--transition-normal);
        }

        /* Top Navbar */
        .content .navbar {
            background: var(--secondary);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: var(--shadow-md);
        }

        .content .navbar-brand {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            transition: color var(--transition-fast);
        }

        .content .navbar-brand:hover {
            color: var(--primary-hover);
        }

        .content .sidebar-toggler {
            color: var(--light);
            font-size: 1.25rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all var(--transition-normal);
            cursor: pointer;
        }

        .content .sidebar-toggler:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--primary);
        }

        .content .nav-link {
            color: var(--light);
            font-weight: 500;
            transition: color var(--transition-fast);
        }

        .content .nav-link:hover {
            color: var(--primary);
        }

        /* Cards */
        .bg-secondary {
            background: var(--secondary) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
        }

        .bg-secondary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Tables */
        .table {
            background: var(--secondary);
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background: rgba(255, 255, 255, 0.05);
            color: var(--primary);
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            padding: 1rem 0.75rem;
        }

        .table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background-color var(--transition-fast);
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .table tbody td {
            color: var(--light);
            font-size: 0.875rem;
            padding: 1rem 0.75rem;
            border: none;
        }

        .table tbody td strong {
            color: white;
            font-weight: 600;
        }

        /* Forms */
        .form-control {
            background: var(--dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 8px !important;
            color: var(--light) !important;
            font-size: 0.875rem;
            transition: all var(--transition-normal);
        }

        .form-control:focus {
            background: var(--dark-hover) !important;
            border-color: var(--primary) !important;
            color: white !important;
            box-shadow: 0 0 0 3px rgba(235, 22, 22, 0.1) !important;
        }

        .form-control::placeholder {
            color: var(--light) !important;
            opacity: 0.6;
        }

        .form-select {
            background: var(--dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 8px !important;
            color: var(--light) !important;
            font-size: 0.875rem;
            transition: all var(--transition-normal);
        }

        .form-select:focus {
            background: var(--dark-hover) !important;
            border-color: var(--primary) !important;
            color: white !important;
            box-shadow: 0 0 0 3px rgba(235, 22, 22, 0.1) !important;
        }

        .form-label {
            color: var(--light);
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        /* Buttons */
        .btn {
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: all var(--transition-normal);
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-primary);
        }

        .btn-primary:hover {
            background: var(--gradient-primary);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(235, 22, 22, 0.4);
            color: white;
        }

        .btn-outline-light {
            background: transparent;
            color: var(--light);
            border: 1px solid var(--light);
        }

        .btn-outline-light:hover {
            background: var(--light);
            color: var(--dark);
            transform: translateY(-2px);
        }

        .btn-success {
            background: var(--gradient-success);
            color: white;
        }

        .btn-success:hover {
            background: var(--gradient-success);
            transform: translateY(-2px);
            color: white;
        }

        .btn-danger {
            background: var(--gradient-danger);
            color: white;
        }

        .btn-danger:hover {
            background: var(--gradient-danger);
            transform: translateY(-2px);
            color: white;
        }

        .btn-info {
            background: var(--info);
            color: white;
        }

        .btn-info:hover {
            background: #138496;
            transform: translateY(-2px);
            color: white;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8rem;
        }

        /* Badges */
        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .bg-success { background: var(--gradient-success) !important; }
        .bg-warning { background: var(--gradient-warning) !important; color: var(--dark) !important; }
        .bg-danger { background: var(--gradient-danger) !important; }
        .bg-secondary { background: var(--gradient-secondary) !important; }
        .bg-info { background: var(--info) !important; }

        /* Alerts */
        .admin-alert {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.25rem;
            font-family: 'Open Sans', sans-serif;
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-alert.success {
            background: rgba(40, 167, 69, 0.15);
            border-color: var(--success);
            color: var(--success);
        }

        .admin-alert.warning {
            background: rgba(255, 193, 7, 0.15);
            border-color: var(--warning);
            color: var(--warning);
        }

        .admin-alert i {
            font-size: 1.25rem;
        }

        /* Footer */
        .content .container-fluid:last-child .bg-secondary {
            background: var(--secondary) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 2rem;
        }

        .content .container-fluid:last-child .bg-secondary a {
            color: var(--primary);
            text-decoration: none;
            transition: color var(--transition-fast);
        }

        .content .container-fluid:last-child .bg-secondary a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        /* Back to Top */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            box-shadow: var(--shadow-primary);
            transition: all var(--transition-normal);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(235, 22, 22, 0.4);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .sidebar {
                margin-left: -250px;
            }
            
            .sidebar.open {
                margin-left: 0;
            }
            
            .content {
                width: 100%;
                margin-left: 0;
            }
            
            .content.open {
                width: 100%;
                margin-left: 0;
            }
        }

        @media (max-width: 767.98px) {
            .sidebar .navbar-brand h3 {
                font-size: 1.25rem;
            }
            
            .sidebar .d-flex.align-items-center {
                margin: 0 1rem 1.5rem;
                padding: 0.75rem;
            }
            
            .table {
                font-size: 0.8rem;
            }
            
            .table thead th,
            .table tbody td {
                padding: 0.75rem 0.5rem;
            }
            
            .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 575.98px) {
            .sidebar {
                width: 280px;
            }
            
            .content .navbar .navbar-nav .nav-link {
                margin-left: 1rem;
                font-size: 0.875rem;
            }
            
            .table-responsive {
                border-radius: 8px;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInLeft {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .fade-in {
            animation: fadeIn var(--transition-normal);
        }

        .slide-in-left {
            animation: slideInLeft var(--transition-normal);
        }

        .pulse-on-hover:hover {
            animation: pulse 0.5s ease-in-out;
        }

        /* Utility Classes */
        .text-primary { color: var(--primary) !important; }
        .text-light { color: var(--light) !important; }
        .text-danger { color: var(--danger) !important; }
        .text-success { color: var(--success) !important; }

        .bg-dark { background: var(--dark) !important; }
        .bg-secondary { background: var(--secondary) !important; }

        .border-primary { border-color: var(--primary) !important; }
        .border-light { border-color: var(--light) !important; }

        .shadow-primary { box-shadow: var(--shadow-primary) !important; }
        .shadow-md { box-shadow: var(--shadow-md) !important; }
        .shadow-lg { box-shadow: var(--shadow-lg) !important; }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--secondary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-hover);
        }

        /* Form Sections */
        .form-section {
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.02);
            transition: all var(--transition-normal);
        }

        .form-section:hover {
            border-color: rgba(235, 22, 22, 0.3);
            background: rgba(255, 255, 255, 0.03);
        }

        .form-section legend {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 0.5rem;
            width: 100%;
        }

        /* Progress Bar */
        .progress {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            background: var(--gradient-primary);
            transition: width var(--transition-normal);
        }

        /* Form Actions */
        .form-actions {
            position: sticky;
            bottom: 0;
            background: var(--secondary);
            z-index: 10;
        }

        /* Empty States */
        .empty-state {
            padding: 3rem 1rem;
        }

        .empty-state-icon {
            opacity: 0.5;
            transition: opacity var(--transition-normal);
        }

        .empty-state:hover .empty-state-icon {
            opacity: 0.8;
        }

        /* Table Row Hover */
        .table-row-hover {
            transition: background-color var(--transition-fast);
        }

        /* Action Buttons */
        .action-buttons {
            min-width: 120px;
        }

        /* Filter Section */
        .filter-section {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 8px;
            padding: 1rem;
        }

        /* Validation States */
        .is-valid {
            border-color: var(--success) !important;
            background: rgba(40, 167, 69, 0.1) !important;
        }

        .is-invalid {
            border-color: var(--danger) !important;
            background: rgba(220, 53, 69, 0.1) !important;
        }

        /* Input Group Text */
        .input-group-text {
            background: var(--dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: var(--light) !important;
        }

        /* Form Select Dropdown */
        .form-select option {
            background: var(--secondary);
            color: var(--light);
        }

        /* Button Hover Effects */
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Alert Styles */
        .alert {
            border-radius: 8px;
            border: none;
        }

        .alert-info {
            background: rgba(23, 162, 184, 0.15);
            color: var(--info);
        }

        /* Badge Styles */
        .badge {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .form-section {
                padding: 1rem;
            }

            .form-actions {
                position: static;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php?action=index" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-shield-halved me-2"></i>WorkWave</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fa fa-user-shield text-white"></i>
                        </div>
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0" style="color: #fff;">Admin</h6>
                        <span style="color: var(--light);">Administrateur</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php?action=index" class="nav-item nav-link <?= (isset($activePage) && $activePage === 'list') ? 'active' : '' ?>">
                        <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="index.php?action=index" class="nav-item nav-link <?= (isset($activePage) && $activePage === 'list') ? 'active' : '' ?>">
                        <i class="fa fa-table me-2"></i>Missions
                    </a>
                    <a href="index.php?action=create" class="nav-item nav-link <?= (isset($activePage) && $activePage === 'create') ? 'active' : '' ?>">
                        <i class="fa fa-keyboard me-2"></i>Ajouter Mission
                    </a>
                    <a href="index.php?action=candidatures" class="nav-item nav-link <?= (isset($activePage) && $activePage === 'candidatures') ? 'active' : '' ?>">
                        <i class="fa fa-user-check me-2"></i>Candidatures
                    </a>
                    <a href="index.php?action=missions" class="nav-link-front">
                        <i class="fa fa-globe"></i>Retour au FrontOffice
                    </a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.php?action=index" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-shield-halved"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item">
                        <span class="nav-link" style="color: var(--light);">
                            <i class="fa fa-<?= isset($pageIcon) ? htmlspecialchars($pageIcon) : 'briefcase' ?> me-2"></i>
                            <?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Administration' ?>
                        </span>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Admin Content -->
            <div class="container-fluid pt-4 px-4">
                <?php if (isset($_GET['success'])): ?>
                    <div class="admin-alert success">
                        <i class="fas fa-check-circle"></i> Mission ajoutee avec succes.
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['updated'])): ?>
                    <div class="admin-alert success">
                        <i class="fas fa-check-circle"></i> Mission mise a jour avec succes.
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['deleted'])): ?>
                    <div class="admin-alert warning">
                        <i class="fas fa-trash-alt"></i> Mission supprimee avec succes.
                    </div>
                <?php endif; ?>

                <?= $content ?>
            </div>

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#" style="color: var(--primary);">WorkWave</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end" style="color: var(--light);">
                            Designed By <a href="https://htmlcodex.com" style="color: var(--primary);">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../View/darkpan-1.0.0/darkpan-1.0.0/js/main.js"></script>
    <?= isset($extraJs) ? $extraJs : '' ?>
</body>
</html>