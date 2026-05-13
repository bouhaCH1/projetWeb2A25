<?php
$pageTitle = 'Tableau de bord Admin';
require_once __DIR__ . '/../layout/dashboard_header.php';

// $kpi is passed from adminDashboard() in UserController
$u  = $kpi['users'];
$m  = $kpi['missions'];
$c  = $kpi['candidatures'];
$ev = $kpi['events'];
$rs = $kpi['resources'];
$ch = $kpi['charts'];
$ac = $kpi['activity'];
?>

<!-- Flash messages -->
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if (!empty($_SESSION['errors'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0"><?php foreach ($_SESSION['errors'] as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; unset($_SESSION['errors']); ?></ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Header -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <h6 class="mb-0">Vue d'ensemble — Statistiques en temps réel</h6>
    <div class="d-flex gap-2 flex-wrap">
        <a href="/workwave/Controller/index.php?action=admin_add_user"   class="btn btn-sm btn-primary"><i class="fa fa-user-plus me-1"></i>Ajouter utilisateur</a>
        <a href="/workwave/Controller/index.php?action=admin_missions"    class="btn btn-sm btn-outline-light"><i class="fa fa-briefcase me-1"></i>Missions</a>
        <a href="/workwave/Controller/index.php?action=admin_events"      class="btn btn-sm btn-outline-warning"><i class="fa fa-calendar-alt me-1"></i>Événements</a>
    </div>
</div>

<!-- ── KPI Row 1: Users ──────────────────────────────────────────────────── -->
<div class="row g-3 mb-3">
    <div class="col-6 col-xl-3">
        <a href="/workwave/Controller/index.php?action=admin_users" class="text-decoration-none">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 h-100">
            <i class="fa fa-users fa-2x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-1 text-muted small">Utilisateurs</p>
                <h5 class="mb-0"><?= (int)$u['total'] ?></h5>
                <small class="text-success">+<?= (int)$u['new_this_month'] ?> ce mois</small>
            </div>
        </div>
        </a>
    </div>
    <div class="col-6 col-xl-3">
        <a href="/workwave/Controller/index.php?action=admin_missions" class="text-decoration-none">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 h-100">
            <i class="fa fa-briefcase fa-2x text-warning"></i>
            <div class="ms-3 text-end">
                <p class="mb-1 text-muted small">Missions</p>
                <h5 class="mb-0"><?= (int)$m['total'] ?></h5>
                <small class="text-info"><?= (int)$m['open'] ?> ouvertes</small>
            </div>
        </div>
        </a>
    </div>
    <div class="col-6 col-xl-3">
        <a href="/workwave/Controller/index.php?action=admin_mission_candidatures" class="text-decoration-none">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 h-100">
            <i class="fa fa-file-alt fa-2x" style="color:#00ffcc;"></i>
            <div class="ms-3 text-end">
                <p class="mb-1 text-muted small">Candidatures</p>
                <h5 class="mb-0"><?= (int)$c['total'] ?></h5>
                <small class="text-warning"><?= (int)$c['pending'] ?> en attente</small>
            </div>
        </div>
        </a>
    </div>
    <div class="col-6 col-xl-3">
        <a href="/workwave/Controller/index.php?action=admin_events" class="text-decoration-none">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 h-100">
            <i class="fa fa-calendar-alt fa-2x" style="color:#eb1616;"></i>
            <div class="ms-3 text-end">
                <p class="mb-1 text-muted small">Événements</p>
                <h5 class="mb-0"><?= (int)$ev['total'] ?></h5>
                <small class="text-success"><?= (int)$ev['upcoming'] ?> à venir</small>
            </div>
        </div>
        </a>
    </div>
</div>

<!-- ── KPI Row 2: Secondary stats ───────────────────────────────────────── -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="bg-secondary rounded p-3 h-100">
            <p class="mb-1 text-muted small"><i class="fa fa-user-tie me-1"></i>Candidats (Seekers)</p>
            <h5 class="mb-0 text-primary"><?= (int)$u['seekers'] ?></h5>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="bg-secondary rounded p-3 h-100">
            <p class="mb-1 text-muted small"><i class="fa fa-building me-1"></i>Employeurs</p>
            <h5 class="mb-0 text-primary"><?= (int)$u['employers'] ?></h5>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="bg-secondary rounded p-3 h-100">
            <p class="mb-1 text-muted small"><i class="fa fa-check-circle me-1 text-success"></i>Candidatures acceptées</p>
            <h5 class="mb-0 text-success"><?= (int)$c['accepted'] ?></h5>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <a href="/workwave/Controller/index.php?action=admin_events" class="text-decoration-none">
        <div class="bg-secondary rounded p-3 h-100">
            <p class="mb-1 text-muted small"><i class="fa fa-boxes me-1" style="color:#00ffcc;"></i>Stock ressources</p>
            <h5 class="mb-0" style="color:#00ffcc;"><?= (int)$rs['total_stock'] ?> unités</h5>
            <?php if ((int)$rs['low_stock_count'] > 0): ?>
            <small class="text-danger"><i class="fa fa-exclamation-triangle me-1"></i><?= (int)$rs['low_stock_count'] ?> en alerte</small>
            <?php endif; ?>
        </div>
        </a>
    </div>
</div>

<!-- ── Charts Row ───────────────────────────────────────────────────────── -->
<div class="row g-4 mb-4">
    <!-- User Growth -->
    <div class="col-12 col-xl-5">
        <div class="bg-secondary rounded p-4 h-100">
            <h6 class="mb-3">📈 Croissance Utilisateurs (6 mois)</h6>
            <canvas id="growthChart" height="200"></canvas>
        </div>
    </div>
    <!-- Candidature Status -->
    <div class="col-12 col-xl-3">
        <div class="bg-secondary rounded p-4 h-100">
            <h6 class="mb-3">📊 Statut Candidatures</h6>
            <canvas id="candChart" height="200"></canvas>
        </div>
    </div>
    <!-- Top Missions by Candidatures -->
    <div class="col-12 col-xl-4">
        <div class="bg-secondary rounded p-4 h-100">
            <h6 class="mb-3">🏆 Missions les plus demandées</h6>
            <?php if (!empty($ch['top_missions'])): ?>
            <div class="d-flex flex-column gap-2">
                <?php foreach ($ch['top_missions'] as $i => $ms): $maxCount = max(1, $ch['top_missions'][0]['count']); ?>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="small text-muted"><?= $i+1 ?>. <?= htmlspecialchars(mb_substr($ms['mission'],0,28)) ?></span>
                    <span class="badge" style="background:#eb1616;"><?= (int)$ms['count'] ?> cand.</span>
                </div>
                <div class="progress" style="height:4px;">
                    <div class="progress-bar" style="width:<?= min(100, round($ms['count']/$maxCount*100)) ?>%;background:#eb1616;"></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="text-muted small">Aucune candidature pour l'instant.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ── Activity Feed ────────────────────────────────────────────────────── -->
<div class="row g-4 mb-4">
    <div class="col-12 col-xl-7">
        <div class="bg-secondary rounded p-4 h-100">
            <h6 class="mb-3">⚡ Activité Récente (en temps réel)</h6>
            <?php if (!empty($ac)): ?>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($ac as $a): ?>
                <div class="d-flex align-items-start gap-3">
                    <div style="width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa <?= $a['icon'] ?> small" style="color:<?= $a['color'] ?>;"></i>
                    </div>
                    <div>
                        <p class="mb-0 small"><?= $a['text'] ?></p>
                        <span class="text-muted" style="font-size:11px;"><?= date('d/m/Y H:i', strtotime($a['time'])) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="text-muted small">Aucune activité récente.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Quick Actions -->
    <div class="col-12 col-xl-5">
        <div class="bg-secondary rounded p-4 h-100">
            <h6 class="mb-3">🚀 Actions Rapides</h6>
            <div class="row g-2">
                <?php
                $actions = [
                    ['url'=>'admin_users',                  'icon'=>'fa-users-cog',   'label'=>'Utilisateurs',      'color'=>'#eb1616'],
                    ['url'=>'admin_missions',               'icon'=>'fa-briefcase',   'label'=>'Missions',          'color'=>'#ffcc00'],
                    ['url'=>'admin_mission_candidatures',   'icon'=>'fa-user-check',  'label'=>'Candidatures',      'color'=>'#00ffcc'],
                    ['url'=>'admin_events',                 'icon'=>'fa-calendar-alt','label'=>'Événements & Stock','color'=>'#ff6b6b'],
                    ['url'=>'ai_analyze',                   'icon'=>'fa-brain',       'label'=>'Analyse IA',        'color'=>'#00b3ff'],
                    ['url'=>'admin_add_user',               'icon'=>'fa-user-plus',   'label'=>'+ Utilisateur',     'color'=>'#a855f7'],
                ];
                foreach ($actions as $act): ?>
                <div class="col-6">
                    <a href="/workwave/Controller/index.php?action=<?= $act['url'] ?>" class="text-decoration-none">
                    <div class="rounded p-3 text-center h-100" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);transition:.2s;" onmouseover="this.style.background='rgba(255,255,255,0.09)'" onmouseout="this.style.background='rgba(255,255,255,0.04)'">
                        <i class="fa <?= $act['icon'] ?> mb-2" style="color:<?= $act['color'] ?>;font-size:1.4rem;"></i>
                        <p class="mb-0 small text-white"><?= $act['label'] ?></p>
                    </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Chart === 'undefined') return;

    // ── Growth Chart ─────────────────────────────────────────────────────
    const growthLabels = <?= json_encode(array_column($ch['growth'], 'month')) ?>;
    const growthData   = <?= json_encode(array_column($ch['growth'], 'count')) ?>;

    new Chart(document.getElementById('growthChart'), {
        type: 'line',
        data: {
            labels: growthLabels,
            datasets: [{
                label: 'Nouveaux inscrits',
                data: growthData,
                backgroundColor: 'rgba(235,22,22,0.15)',
                borderColor: '#eb1616',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#eb1616'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#aaa' } } },
            scales: {
                x: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#888' } },
                y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#888', stepSize: 1 }, beginAtZero: true }
            }
        }
    });

    // ── Candidature Status Chart ─────────────────────────────────────────
    const candData = <?= json_encode($ch['cand_status']) ?>;
    const candLabels = candData.map(r => r.status);
    const candCounts = candData.map(r => parseInt(r.count));
    const candColors = {
        'En attente': '#ffcc00',
        'Acceptée':   '#00ffcc',
        'Refusée':    '#eb1616'
    };

    new Chart(document.getElementById('candChart'), {
        type: 'doughnut',
        data: {
            labels: candLabels,
            datasets: [{ data: candCounts, backgroundColor: candLabels.map(l => candColors[l] || '#888'), borderWidth: 0 }]
        },
        options: {
            responsive: true,
            cutout: '60%',
            plugins: { legend: { position: 'bottom', labels: { color: '#aaa', font: { size: 11 } } } }
        }
    });
});
</script>
