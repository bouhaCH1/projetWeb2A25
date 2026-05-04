<?php
$pageTitle = 'Mon Tableau de Bord';
include __DIR__ . '/../layout/pl_dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Bon retour, <?= htmlspecialchars($_SESSION['user_first_name'] ?? '') ?>! 👋</div>
        <div class="page-header-sub">Voici l'actualité de votre recherche d'emploi</div>
    </div>
</div>

<!-- Flash messages -->
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<!-- Stats row -->
<div class="stat-grid" style="margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-card-label">Profil complété</div>
        <div class="stat-card-value" style="font-size:1.5rem;">
            <?= !empty($_SESSION['user_pic']) ? '100%' : '60%' ?>
        </div>
        <div class="stat-card-sub">
            <?= !empty($_SESSION['user_pic']) ? '✅ Profil complet' : '⚠️ Ajoutez une photo' ?>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Statut identité</div>
        <div class="stat-card-value" style="font-size:1.1rem;color:<?= (int)($_SESSION['user_verified'] ?? 0) === 1 ? '#00ffcc' : '#ffd700' ?>;">
            <?= (int)($_SESSION['user_verified'] ?? 0) === 1 ? '✅ Vérifié' : '⏳ En attente' ?>
        </div>
        <div class="stat-card-sub"><?= (int)($_SESSION['user_verified'] ?? 0) === 1 ? 'Badge de confiance actif' : 'Vérifiez votre CIN' ?></div>
    </div>
    <div class="stat-card" id="weatherCard">
        <div class="stat-card-label">🌤 Météo locale</div>
        <div class="stat-card-value" id="weatherTemp" style="font-size:1.5rem;color:#00b3ff;">--°C</div>
        <div class="stat-card-sub" id="weatherDesc">Chargement...</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Membre depuis</div>
        <div class="stat-card-value" style="font-size:1rem;color:#a78bfa;">
            <?= date('M Y') ?>
        </div>
        <div class="stat-card-sub">Compte actif</div>
    </div>
</div>

<!-- Quick actions -->
<div class="action-grid" style="margin-bottom:24px;">

    <a href="/workwave/Controller/index.php?action=profile" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20v-2a8 8 0 0116 0v2"/></svg>
        </div>
        <div class="action-card-title">Mon Profil</div>
        <div class="action-card-desc">Mettez à jour vos informations personnelles</div>
    </a>

    <a href="/workwave/Controller/index.php?action=ai_analyze" class="action-card" style="border-color:rgba(0,179,255,0.2);">
        <div class="action-card-icon" style="background:rgba(0,179,255,0.1);color:#00b3ff;">
            🤖
        </div>
        <div class="action-card-title">Analyse IA</div>
        <div class="action-card-desc">Découvrez votre domaine métier avec l'IA HuggingFace</div>
    </a>

    <a href="/workwave/Controller/index.php?action=security" class="action-card" style="border-color:rgba(167,139,250,0.2);">
        <div class="action-card-icon" style="background:rgba(167,139,250,0.1);color:#a78bfa;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div class="action-card-title">Sécurité & 2FA</div>
        <div class="action-card-desc">Gérez la sécurité et vérifiez votre identité</div>
    </a>

    <a href="/workwave/Controller/index.php?action=verify_identity" class="action-card" style="border-color:rgba(255,215,0,0.2);">
        <div class="action-card-icon" style="background:rgba(255,215,0,0.1);color:#ffd700;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M16 10a4 4 0 11-8 0 4 4 0 018 0zM18 19l-2-2"/></svg>
        </div>
        <div class="action-card-title">Vérifier mon identité</div>
        <div class="action-card-desc">Scanner votre CIN avec l'OCR IA</div>
    </a>

</div>

<!-- Bottom row: Météo + Jobs recommandés -->
<div style="display:flex;flex-wrap:wrap;gap:20px;align-items:flex-start;">

    <!-- Météo widget -->
    <div class="dsh-card" style="flex:0 0 300px;min-width:260px;padding:24px;" id="weatherWidget">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <div style="font-weight:700;color:#fff;font-size:0.95rem;">🌍 Météo — Métier Avancé</div>
            <div style="font-size:0.7rem;color:#555;background:rgba(0,179,255,0.08);padding:2px 8px;border-radius:10px;border:1px solid rgba(0,179,255,0.2);color:#00b3ff;">API OpenWeatherMap</div>
        </div>

        <!-- City selector -->
        <div style="display:flex;gap:8px;margin-bottom:16px;">
            <input type="text" id="cityInput" value="Tunis" placeholder="Ville..."
                style="flex:1;padding:7px 10px;background:rgba(255,255,255,0.04);border:1px solid rgba(0,179,255,0.2);border-radius:6px;color:#ddd;font-size:0.83rem;outline:none;" />
            <button onclick="fetchWeather()" style="padding:7px 14px;background:linear-gradient(135deg,#00b3ff,#00ffcc);border:none;border-radius:6px;color:#000;font-weight:700;font-size:0.8rem;cursor:pointer;">Go</button>
        </div>

        <!-- Weather display -->
        <div id="weatherDisplay" style="text-align:center;padding:16px 0;">
            <div id="weatherIcon" style="font-size:3.5rem;margin-bottom:8px;line-height:1;">⏳</div>
            <div id="weatherBigTemp" style="font-size:2.8rem;font-weight:800;color:#00b3ff;line-height:1;">--</div>
            <div id="weatherUnit" style="font-size:1rem;color:#555;margin-bottom:6px;">°C</div>
            <div id="weatherCity" style="font-weight:700;color:#fff;font-size:1rem;margin-bottom:4px;">Chargement...</div>
            <div id="weatherDescFull" style="font-size:0.83rem;color:#777;text-transform:capitalize;margin-bottom:12px;">...</div>

            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-top:12px;">
                <div style="padding:8px;border-radius:7px;background:rgba(0,179,255,0.06);border:1px solid rgba(0,179,255,0.1);">
                    <div style="font-size:0.65rem;color:#555;margin-bottom:3px;">RESSENTI</div>
                    <div id="weatherFeels" style="font-size:0.88rem;font-weight:700;color:#00b3ff;">--°</div>
                </div>
                <div style="padding:8px;border-radius:7px;background:rgba(0,255,204,0.06);border:1px solid rgba(0,255,204,0.1);">
                    <div style="font-size:0.65rem;color:#555;margin-bottom:3px;">HUMIDITÉ</div>
                    <div id="weatherHumidity" style="font-size:0.88rem;font-weight:700;color:#00ffcc;">--%</div>
                </div>
                <div style="padding:8px;border-radius:7px;background:rgba(167,139,250,0.06);border:1px solid rgba(167,139,250,0.1);">
                    <div style="font-size:0.65rem;color:#555;margin-bottom:3px;">VENT</div>
                    <div id="weatherWind" style="font-size:0.88rem;font-weight:700;color:#a78bfa;">-- km/h</div>
                </div>
            </div>
        </div>

        <div style="text-align:center;font-size:0.68rem;color:#444;margin-top:8px;">
            Mis à jour : <span id="weatherUpdated">--</span>
        </div>
    </div>

    <!-- Jobs recommandés -->
    <div class="dsh-card" style="flex:1;min-width:280px;">
        <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(0,255,204,0.07);padding-bottom:15px;margin-bottom:15px;">
            <div style="font-weight:700;color:#fff;font-size:0.95rem;">Offres recommandées</div>
            <a href="#" class="btn btn-outline" style="padding:5px 12px;font-size:0.8rem;" onclick="event.preventDefault()">Parcourir</a>
        </div>
        <?php
        $jobs = [
            ['title'=>'Développeur Full-Stack','company'=>'TechNova','location'=>'Distanciel','salary'=>'70k–90k DT','tag'=>'💻','color'=>'#00ffcc'],
            ['title'=>'Designer UX/UI','company'=>'Creative Labs','location'=>'Tunis, TN','salary'=>'50k–65k DT','tag'=>'🎨','color'=>'#a78bfa'],
            ['title'=>'Analyste de données','company'=>'DataSphere','location'=>'Sfax, TN','salary'=>'60k–80k DT','tag'=>'📊','color'=>'#00b3ff'],
            ['title'=>'Chef de projet IT','company'=>'InnoSys','location'=>'Sousse, TN','salary'=>'80k–100k DT','tag'=>'🚀','color'=>'#ffd700'],
        ];
        foreach ($jobs as $j): ?>
        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;border-radius:8px;background:rgba(255,255,255,0.02);border:1px solid rgba(0,255,204,0.06);margin-bottom:10px;transition:.2s;" onmouseover="this.style.borderColor='rgba(0,255,204,0.18)'" onmouseout="this.style.borderColor='rgba(0,255,204,0.06)'">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:38px;height:38px;border-radius:8px;background:rgba(255,255,255,0.04);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;"><?= $j['tag'] ?></div>
                <div>
                    <div style="font-weight:700;color:#fff;font-size:0.88rem;"><?= $j['title'] ?></div>
                    <div style="font-size:0.75rem;color:#666;"><?= $j['company'] ?> · <?= $j['location'] ?></div>
                </div>
            </div>
            <div style="text-align:right;flex-shrink:0;margin-left:12px;">
                <div style="font-size:0.75rem;color:<?= $j['color'] ?>;font-weight:700;"><?= $j['salary'] ?></div>
                <a href="#" onclick="event.preventDefault()" style="font-size:0.72rem;color:#555;text-decoration:none;">Voir →</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>

<?php include __DIR__ . '/../layout/pl_dashboard_footer.php'; ?>

<script>
const weatherIcons = {
    'clear sky': '☀️', 'few clouds': '⛅', 'scattered clouds': '🌤',
    'broken clouds': '☁️', 'overcast clouds': '☁️',
    'shower rain': '🌧', 'rain': '🌧', 'light rain': '🌦',
    'thunderstorm': '⛈', 'snow': '❄️', 'mist': '🌫', 'haze': '🌫',
    'fog': '🌫', 'drizzle': '🌦', 'moderate rain': '🌧', 'heavy rain': '🌧'
};

function getWeatherIcon(desc) {
    for (const [k, v] of Object.entries(weatherIcons)) {
        if (desc.toLowerCase().includes(k)) return v;
    }
    return '🌡';
}

function fetchWeather() {
    const city = document.getElementById('cityInput').value.trim() || 'Tunis';
    // Use wttr.in JSON API — no key required, works perfectly for demo
    const url = `https://wttr.in/${encodeURIComponent(city)}?format=j1`;

    fetch(url)
        .then(r => r.json())
        .then(data => {
            const curr = data.current_condition[0];
            const area = data.nearest_area[0];
            const cityName = area.areaName[0].value + ', ' + area.country[0].value;
            const temp    = curr.temp_C;
            const feels   = curr.FeelsLikeC;
            const humid   = curr.humidity;
            const wind    = curr.windspeedKmph;
            const desc    = curr.weatherDesc[0].value;

            document.getElementById('weatherBigTemp').textContent = temp;
            document.getElementById('weatherCity').textContent    = cityName;
            document.getElementById('weatherDescFull').textContent = desc;
            document.getElementById('weatherFeels').textContent   = feels + '°';
            document.getElementById('weatherHumidity').textContent = humid + '%';
            document.getElementById('weatherWind').textContent    = wind + ' km/h';
            document.getElementById('weatherIcon').textContent    = getWeatherIcon(desc);
            document.getElementById('weatherTemp').textContent    = temp + '°C';
            document.getElementById('weatherDesc').textContent    = desc;
            document.getElementById('weatherUpdated').textContent = new Date().toLocaleTimeString('fr-FR');
        })
        .catch(() => {
            document.getElementById('weatherCity').textContent    = 'Erreur API';
            document.getElementById('weatherDescFull').textContent = 'Vérifiez votre connexion';
            document.getElementById('weatherIcon').textContent    = '❌';
        });
}

// Auto-fetch on load
fetchWeather();

// Allow Enter key in city input
document.getElementById('cityInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') fetchWeather();
});
</script>
