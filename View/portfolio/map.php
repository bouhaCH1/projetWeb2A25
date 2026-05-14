<?php
$pageTitle = 'Carte des Talents';
require_once __DIR__ . '/../../View/layout/pl_dashboard_header.php';
?>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="ww-page">

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <div class="page-header-title">
            <i class="fa fa-map-marked-alt" style="color:#00ffcc;"></i> Réseau de Talents
        </div>
        <div class="page-header-sub">Trouvez des freelances et des entreprises à proximité de vous</div>
    </div>
    <a href="/workwave/Controller/index.php?action=portfolio" class="ww-btn-secondary" style="margin-top:0;">
        <i class="fa fa-arrow-left"></i> Retour au Portfolio
    </a>
</div>

<!-- MAP FILTER -->
<div class="dsh-card mb-4" style="padding: 20px;">
    <form method="GET" action="/workwave/Controller/index.php" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <input type="hidden" name="action" value="portfolio_map">
        
        <div style="flex:1;min-width:150px;">
            <label style="margin-top:0;margin-bottom:8px;">Latitude</label>
            <input type="text" name="lat" value="<?= htmlspecialchars((string)$lat) ?>" placeholder="Ex: 36.8065">
        </div>
        
        <div style="flex:1;min-width:150px;">
            <label style="margin-top:0;margin-bottom:8px;">Longitude</label>
            <input type="text" name="lng" value="<?= htmlspecialchars((string)$lng) ?>" placeholder="Ex: 10.1815">
        </div>
        
        <div style="flex:1;min-width:150px;">
            <label style="margin-top:0;margin-bottom:8px;">Rayon (km)</label>
            <input type="text" name="radius" value="<?= htmlspecialchars((string)$radius) ?>" placeholder="Ex: 50">
        </div>
        
        <button type="submit" class="cyber-btn" style="height: 42px; margin-top:0;">
            <i class="fa fa-search"></i> Mettre à jour
        </button>
    </form>
</div>

<!-- MAP CONTAINER -->
<div class="dsh-card" style="padding: 0; overflow: hidden; height: 500px; border-radius: 12px; position: relative;">
    <div id="ww-map" style="width: 100%; height: 100%;"></div>
</div>

<!-- NEARBY LISTS -->
<div class="row g-4 mt-2">
    <div class="col-md-6">
        <div class="dsh-card" style="height: 100%;">
            <h5 style="color: #00ffcc; margin-bottom: 20px;"><i class="fa fa-users"></i> Freelances à proximité (<?= count($freelancers) ?>)</h5>
            <?php if(empty($freelancers)): ?>
                <p class="text-muted">Aucun freelance trouvé dans ce rayon.</p>
            <?php else: ?>
                <ul style="list-style: none; padding: 0; margin: 0;">
                <?php foreach($freelancers as $f): ?>
                    <li style="padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between;">
                        <span style="color: #fff; font-weight: 600;">
                            <i class="fa fa-user-circle" style="color: #00b3ff; margin-right: 8px;"></i>
                            <?= htmlspecialchars($f['u_fname'] . ' ' . $f['u_lname']) ?>
                        </span>
                        <span style="color: #00ffcc; font-size: 0.9em;"><?= number_format($f['distance_km'], 1) ?> km</span>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="dsh-card" style="height: 100%;">
            <h5 style="color: #00ffcc; margin-bottom: 20px;"><i class="fa fa-building"></i> Entreprises à proximité (<?= count($companies) ?>)</h5>
            <?php if(empty($companies)): ?>
                <p class="text-muted">Aucune entreprise trouvée dans ce rayon.</p>
            <?php else: ?>
                <ul style="list-style: none; padding: 0; margin: 0;">
                <?php foreach($companies as $c): ?>
                    <li style="padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between;">
                        <span style="color: #fff; font-weight: 600;">
                            <i class="fa fa-building" style="color: #ff6b6b; margin-right: 8px;"></i>
                            <?= htmlspecialchars($c['company_name']) ?>
                        </span>
                        <span style="color: #00ffcc; font-size: 0.9em;"><?= number_format($c['distance_km'], 1) ?> km</span>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

</div><!-- /.ww-page -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mapCenter = [<?= (float)$lat ?>, <?= (float)$lng ?>];
    const map = L.map('ww-map', {
        zoomControl: true,
        scrollWheelZoom: false
    }).setView(mapCenter, 11);

    // Dark theme map tiles
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 20
    }).addTo(map);

    // Center circle
    L.circle(mapCenter, {
        color: '#00ffcc',
        fillColor: '#00ffcc',
        fillOpacity: 0.1,
        radius: <?= (float)$radius ?> * 1000
    }).addTo(map);

    // Marker icons
    const freelanceIcon = L.divIcon({
        html: '<i class="fa fa-user-circle" style="color:#00b3ff; font-size: 24px; filter: drop-shadow(0px 0px 4px rgba(0,179,255,0.8));"></i>',
        className: 'custom-div-icon',
        iconSize: [24, 24],
        iconAnchor: [12, 24]
    });

    const companyIcon = L.divIcon({
        html: '<i class="fa fa-map-marker-alt" style="color:#ff6b6b; font-size: 28px; filter: drop-shadow(0px 0px 4px rgba(255,107,107,0.8));"></i>',
        className: 'custom-div-icon',
        iconSize: [24, 24],
        iconAnchor: [12, 28]
    });

    // Add freelancers
    <?php foreach($freelancers as $f): ?>
        <?php if(!empty($f['lat']) && !empty($f['lng'])): ?>
            L.marker([<?= (float)$f['lat'] ?>, <?= (float)$f['lng'] ?>], {icon: freelanceIcon})
                .bindPopup('<div style="color:#333;font-weight:bold;"><?= htmlspecialchars($f['u_fname'] . " " . $f['u_lname']) ?></div><div style="color:#666;font-size:12px;">Freelance</div>')
                .addTo(map);
        <?php endif; ?>
    <?php endforeach; ?>

    // Add companies
    <?php foreach($companies as $c): ?>
        <?php if(!empty($c['lat']) && !empty($c['lng'])): ?>
            L.marker([<?= (float)$c['lat'] ?>, <?= (float)$c['lng'] ?>], {icon: companyIcon})
                .bindPopup('<div style="color:#333;font-weight:bold;"><?= htmlspecialchars($c['company_name']) ?></div><div style="color:#666;font-size:12px;">Entreprise</div>')
                .addTo(map);
        <?php endif; ?>
    <?php endforeach; ?>
});
</script>

<?php require_once __DIR__ . '/../../View/layout/pl_dashboard_footer.php'; ?>
