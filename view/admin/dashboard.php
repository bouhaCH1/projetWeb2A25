<?php
$pageTitle = 'Tableau de bord Admin';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h6 class="mb-0">Vue d'ensemble - Statistiques de la plateforme</h6>
    <a href="/workwave/Controller/index.php?action=admin_add_user" class="btn btn-primary m-2">+ Ajouter un utilisateur</a>
</div>

<!-- Flash messages -->
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Stats row -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-users fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Utilisateurs totaux</p>
                <h6 class="mb-0 fs-4"><?= $stats['total'] ?></h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-user-tie fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Candidats</p>
                <h6 class="mb-0 fs-4"><?= $stats['job_seeker'] ?></h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-building fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Employeurs</p>
                <h6 class="mb-0 fs-4"><?= $stats['employer'] ?></h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4" style="border-left: 4px solid var(--primary);">
            <i class="fa fa-user-plus fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Nouveaux ce mois-ci</p>
                <h6 class="mb-0 fs-4">
                    <?= $stats['new_this_month'] ?? 0 ?>
                    <?php if (($stats['new_this_month'] ?? 0) > 0): ?>
                        <span class="badge bg-success ms-2">+ Nouveaux</span>
                    <?php endif; ?>
                </h6>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-sm-12 col-xl-6">
        <div class="bg-secondary text-center rounded p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Croissance des Utilisateurs (Mensuelle)</h6>
            </div>
            <canvas id="userGrowthChart"></canvas>
        </div>
    </div>
    <div class="col-sm-12 col-xl-6">
        <div class="bg-secondary text-center rounded p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Répartition des Rôles</h6>
            </div>
            <canvas id="roleDistributionChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<!-- Quick actions -->
<div class="bg-secondary text-center rounded p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h6 class="mb-0">Actions rapides</h6>
    </div>
    <div class="row g-4">
        <div class="col-sm-12 col-md-4">
            <div class="h-100 bg-dark rounded p-4 d-flex flex-column align-items-center justify-content-center text-center shadow-sm" style="transition: .3s; cursor: pointer;" onclick="window.location.href='/workwave/Controller/index.php?action=admin_users'" onmouseover="this.classList.add('bg-secondary');this.classList.remove('bg-dark');" onmouseout="this.classList.add('bg-dark');this.classList.remove('bg-secondary');">
                <i class="fa fa-users-cog fa-3x text-primary mb-3"></i>
                <h6 class="mb-2">Gérer les utilisateurs</h6>
                <p class="mb-0 text-muted">Afficher, modifier ou supprimer des comptes</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="h-100 bg-dark rounded p-4 d-flex flex-column align-items-center justify-content-center text-center shadow-sm" style="transition: .3s; cursor: pointer;" onclick="window.location.href='/workwave/Controller/index.php?action=admin_add_user'" onmouseover="this.classList.add('bg-secondary');this.classList.remove('bg-dark');" onmouseout="this.classList.add('bg-dark');this.classList.remove('bg-secondary');">
                <i class="fa fa-user-plus fa-3x text-primary mb-3"></i>
                <h6 class="mb-2">Ajouter un utilisateur</h6>
                <p class="mb-0 text-muted">Créer manuellement un compte</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="h-100 bg-dark rounded p-4 d-flex flex-column align-items-center justify-content-center text-center shadow-sm" style="transition: .3s; cursor: pointer;" onclick="window.location.href='/workwave/Controller/index.php'" onmouseover="this.classList.add('bg-secondary');this.classList.remove('bg-dark');" onmouseout="this.classList.add('bg-dark');this.classList.remove('bg-secondary');">
                <i class="fa fa-globe fa-3x text-primary mb-3"></i>
                <h6 class="mb-2">Site public</h6>
                <p class="mb-0 text-muted">Aller sur la page d'accueil publique</p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>

<!-- Chart.js Initialization -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof Chart !== 'undefined') {
        
        // --- Line Chart (User Growth Dynamic) ---
        var ctxLine = document.getElementById("userGrowthChart").getContext("2d");
        var myLineChart = new Chart(ctxLine, {
            type: "line",
            data: {
                labels: <?= json_encode($stats['growth_labels'] ?? []) ?>,
                datasets: [{
                    label: "Nouveaux Inscrits",
                    data: <?= json_encode($stats['growth_data'] ?? []) ?>,
                    backgroundColor: "rgba(230, 57, 70, 0.2)", // Transparent Crimson
                    borderColor: "#e63946", // Crimson
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: { color: '#a0a0a0' }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { color: '#a0a0a0' }
                    },
                    y: {
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { color: '#a0a0a0', stepSize: 1 }
                    }
                }
            }
        });

        // Custom plugin to draw numbers inside the Doughnut slices
        const drawNumbersPlugin = {
            id: 'drawNumbersPlugin',
            afterDraw(chart) {
                const ctx = chart.ctx;
                chart.data.datasets.forEach((dataset, i) => {
                    chart.getDatasetMeta(i).data.forEach((datapoint, index) => {
                        const value = dataset.data[index];
                        if (value > 0) {
                            const pos = datapoint.tooltipPosition();
                            ctx.font = 'bold 16px sans-serif';
                            // Index 1 is the White slice (Employeurs), so text must be black to be visible!
                            ctx.fillStyle = (index === 1) ? '#000000' : '#ffffff';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillText(value, pos.x, pos.y);
                        }
                    });
                });
            }
        };

        // --- Pie Chart (Role Distribution) ---
        var ctxPie = document.getElementById("roleDistributionChart").getContext("2d");
        var myPieChart = new Chart(ctxPie, {
            type: "doughnut",
            data: {
                labels: [
                    "Candidats (" + <?= $stats['job_seeker'] ?? 0 ?> + ")", 
                    "Employeurs (" + <?= $stats['employer'] ?? 0 ?> + ")", 
                    "Admins (" + <?= $stats['admin'] ?? 0 ?> + ")"
                ],
                datasets: [{
                    backgroundColor: [
                        "#e63946", // Primary Crimson
                        "#ffffff", // White
                        "#333333"  // Dark grey
                    ],
                    data: [
                        <?= $stats['job_seeker'] ?? 0 ?>, 
                        <?= $stats['employer'] ?? 0 ?>, 
                        <?= $stats['admin'] ?? 0 ?>
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#a0a0a0',
                            padding: 20
                        }
                    }
                }
            },
            plugins: [drawNumbersPlugin]
        });
    }
});
</script>
