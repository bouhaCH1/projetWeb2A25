<?php
$pageTitle = 'Tableau de Bord Employeur';
include __DIR__ . '/../layout/pl_dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Bon retour, <?= htmlspecialchars($_SESSION['user_first_name'] ?? '') ?>! 🏢</div>
        <div class="page-header-sub">Gérez vos offres, analysez vos candidats et suivez votre activité</div>
    </div>
</div>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<!-- Stats row -->
<div class="stat-grid" style="margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-card-label">Offres actives</div>
        <div class="stat-card-value">0</div>
        <div class="stat-card-sub">Bientôt disponible</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Candidatures reçues</div>
        <div class="stat-card-value" style="color:#ffd700;">0</div>
        <div class="stat-card-sub">Ce mois-ci</div>
    </div>
    <div class="stat-card" id="weatherCard">
        <div class="stat-card-label">🌤 Météo locale</div>
        <div class="stat-card-value" id="weatherTemp" style="font-size:1.5rem;color:#00b3ff;">--°C</div>
        <div class="stat-card-sub" id="weatherDesc">Chargement...</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Statut compte</div>
        <div class="stat-card-value" style="font-size:1rem;color:<?= (int)($_SESSION['user_verified'] ?? 0) === 1 ? '#00ffcc' : '#ffd700' ?>;">
            <?= (int)($_SESSION['user_verified'] ?? 0) === 1 ? '✅ Vérifié' : '⚠️ Non vérifié' ?>
        </div>
        <div class="stat-card-sub">Vérifiez votre identité</div>
    </div>
</div>

<!-- Quick actions -->
<div class="action-grid" style="margin-bottom:24px;">

    <a href="/workwave/Controller/index.php?action=profile" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div class="action-card-title">Mon Entreprise</div>
        <div class="action-card-desc">Mettez à jour votre profil d'entreprise</div>
    </a>

    <a href="/workwave/Controller/index.php?action=ai_analyze" class="action-card" style="border-color:rgba(0,179,255,0.2);">
        <div class="action-card-icon" style="background:rgba(0,179,255,0.1);color:#00b3ff;">🤖</div>
        <div class="action-card-title">Analyse IA</div>
        <div class="action-card-desc">Analysez les profils candidats avec HuggingFace IA</div>
    </a>

    <a href="/workwave/Controller/index.php?action=security" class="action-card" style="border-color:rgba(167,139,250,0.2);">
        <div class="action-card-icon" style="background:rgba(167,139,250,0.1);color:#a78bfa;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div class="action-card-title">Sécurité & 2FA</div>
        <div class="action-card-desc">Double authentification et vérification</div>
    </a>

    <a href="#" class="action-card" style="border-style:dashed;opacity:.6;cursor:default;" onclick="event.preventDefault()">
        <div class="action-card-icon" style="background:rgba(255,107,107,0.1);color:#ff6b6b;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 5v14M5 12l7-7 7 7"/></svg>
        </div>
        <div class="action-card-title">Publier une offre</div>
        <div class="action-card-desc">Bientôt disponible</div>
    </a>

</div>

<!-- Bottom row: Météo + Tips + Mini chart -->
<div style="display:flex;flex-wrap:wrap;gap:20px;align-items:flex-start;">

    <!-- Météo widget -->
    <div class="dsh-card" style="flex:0 0 300px;min-width:260px;padding:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <div style="font-weight:700;color:#fff;font-size:0.95rem;">🌍 Météo — Métier Avancé</div>
            <div style="font-size:0.7rem;background:rgba(0,179,255,0.08);padding:2px 8px;border-radius:10px;border:1px solid rgba(0,179,255,0.2);color:#00b3ff;">wttr.in API</div>
        </div>
        <div style="display:flex;gap:8px;margin-bottom:16px;">
            <input type="text" id="cityInput" value="Tunis" placeholder="Ville..."
                style="flex:1;padding:7px 10px;background:rgba(255,255,255,0.04);border:1px solid rgba(0,179,255,0.2);border-radius:6px;color:#ddd;font-size:0.83rem;outline:none;" />
            <button onclick="fetchWeather()" style="padding:7px 14px;background:linear-gradient(135deg,#00b3ff,#00ffcc);border:none;border-radius:6px;color:#000;font-weight:700;font-size:0.8rem;cursor:pointer;">Go</button>
        </div>
        <div style="text-align:center;padding:12px 0;">
            <div id="weatherIcon" style="font-size:3.5rem;line-height:1;margin-bottom:8px;">⏳</div>
            <div id="weatherBigTemp" style="font-size:2.8rem;font-weight:800;color:#00b3ff;line-height:1;">--°C</div>
            <div id="weatherCity" style="font-weight:700;color:#fff;margin:6px 0 2px;">Chargement...</div>
            <div id="weatherDescFull" style="font-size:0.82rem;color:#777;text-transform:capitalize;margin-bottom:12px;">...</div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;">
                <div style="padding:8px;border-radius:7px;background:rgba(0,179,255,0.06);border:1px solid rgba(0,179,255,0.1);">
                    <div style="font-size:0.62rem;color:#555;margin-bottom:3px;">RESSENTI</div>
                    <div id="weatherFeels" style="font-size:0.85rem;font-weight:700;color:#00b3ff;">--°</div>
                </div>
                <div style="padding:8px;border-radius:7px;background:rgba(0,255,204,0.06);border:1px solid rgba(0,255,204,0.1);">
                    <div style="font-size:0.62rem;color:#555;margin-bottom:3px;">HUMIDITÉ</div>
                    <div id="weatherHumidity" style="font-size:0.85rem;font-weight:700;color:#00ffcc;">--%</div>
                </div>
                <div style="padding:8px;border-radius:7px;background:rgba(167,139,250,0.06);border:1px solid rgba(167,139,250,0.1);">
                    <div style="font-size:0.62rem;color:#555;margin-bottom:3px;">VENT</div>
                    <div id="weatherWind" style="font-size:0.85rem;font-weight:700;color:#a78bfa;">-- km/h</div>
                </div>
            </div>
        </div>
        <div style="text-align:center;font-size:0.68rem;color:#444;margin-top:8px;">Mis à jour : <span id="weatherUpdated">--</span></div>
    </div>

    <!-- Tips + activity -->
    <div style="flex:1;min-width:280px;display:flex;flex-direction:column;gap:20px;">

        <!-- Conseils -->
        <div class="dsh-card" style="padding:22px;">
            <div style="font-weight:700;color:#fff;font-size:0.95rem;margin-bottom:14px;">💡 Conseils pour attirer les meilleurs candidats</div>
            <?php
            $tips = [
                ['🎯','Rédigez des descriptions claires avec les compétences requises exactes'],
                ['💰','Indiquez la fourchette salariale — les offres avec salaire ont 3x plus de candidatures'],
                ['⚡','Répondez rapidement aux candidatures pour montrer votre sérieux'],
                ['🏆','Mettez en avant les avantages de votre entreprise (culture, remote, etc.)'],
            ];
            foreach ($tips as $tip):
            ?>
            <div style="display:flex;gap:10px;align-items:flex-start;margin-bottom:10px;">
                <span style="font-size:1.1rem;flex-shrink:0;"><?= $tip[0] ?></span>
                <span style="font-size:0.82rem;color:#777;line-height:1.5;"><?= $tip[1] ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Activity trend (mini chart) -->
        <div class="dsh-card" style="padding:22px;">
            <div style="font-weight:700;color:#fff;font-size:0.95rem;margin-bottom:14px;">📈 Tendance du marché de l'emploi</div>
            <canvas id="trendChart" style="max-height:160px;"></canvas>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../layout/pl_dashboard_footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Weather widget
const weatherIcons = {
    'clear sky':'☀️','few clouds':'⛅','scattered clouds':'🌤','broken clouds':'☁️',
    'overcast clouds':'☁️','shower rain':'🌧','rain':'🌧','light rain':'🌦',
    'thunderstorm':'⛈','snow':'❄️','mist':'🌫','haze':'🌫','fog':'🌫',
    'drizzle':'🌦','moderate rain':'🌧','heavy rain':'🌧'
};

function getWeatherIcon(desc) {
    for (const [k, v] of Object.entries(weatherIcons)) {
        if (desc.toLowerCase().includes(k)) return v;
    }
    return '🌡';
}

function fetchWeather() {
    const city = document.getElementById('cityInput').value.trim() || 'Tunis';
    fetch(`https://wttr.in/${encodeURIComponent(city)}?format=j1`)
        .then(r => r.json())
        .then(data => {
            const curr = data.current_condition[0];
            const area = data.nearest_area[0];
            const cityName = area.areaName[0].value + ', ' + area.country[0].value;
            const desc = curr.weatherDesc[0].value;
            document.getElementById('weatherBigTemp').textContent   = curr.temp_C + '°C';
            document.getElementById('weatherCity').textContent      = cityName;
            document.getElementById('weatherDescFull').textContent  = desc;
            document.getElementById('weatherFeels').textContent     = curr.FeelsLikeC + '°';
            document.getElementById('weatherHumidity').textContent  = curr.humidity + '%';
            document.getElementById('weatherWind').textContent      = curr.windspeedKmph + ' km/h';
            document.getElementById('weatherIcon').textContent      = getWeatherIcon(desc);
            document.getElementById('weatherTemp').textContent      = curr.temp_C + '°C';
            document.getElementById('weatherDesc').textContent      = desc;
            document.getElementById('weatherUpdated').textContent   = new Date().toLocaleTimeString('fr-FR');
        })
        .catch(() => {
            document.getElementById('weatherCity').textContent    = 'Erreur API';
            document.getElementById('weatherDescFull').textContent = 'Vérifiez votre connexion';
            document.getElementById('weatherIcon').textContent    = '❌';
        });
}
fetchWeather();
document.getElementById('cityInput').addEventListener('keypress', e => { if (e.key === 'Enter') fetchWeather(); });

// Trend chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('trendChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Nov','Déc','Jan','Févr','Mars','Avr','Mai'],
                datasets: [{
                    label: 'Offres publiées',
                    data: [420, 510, 380, 460, 590, 720, 810],
                    borderColor: '#00ffcc',
                    backgroundColor: 'rgba(0,255,204,0.08)',
                    fill: true, tension: 0.4, borderWidth: 2,
                    pointRadius: 3, pointBackgroundColor: '#00ffcc'
                },{
                    label: 'Candidatures',
                    data: [1200, 1500, 1100, 1350, 1700, 2100, 2500],
                    borderColor: '#00b3ff',
                    backgroundColor: 'rgba(0,179,255,0.06)',
                    fill: true, tension: 0.4, borderWidth: 2,
                    pointRadius: 3, pointBackgroundColor: '#00b3ff'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { labels: { color: '#888', font: { size: 11 } } } },
                scales: {
                    x: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#666' } },
                    y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#666' } }
                }
            }
        });
    }
});
</script>
