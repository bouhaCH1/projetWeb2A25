<?php
$pageTitle = 'Analyse IA de Profil';
$isAdmin   = ($_SESSION['user_role'] ?? '') === 'admin';
if ($isAdmin) {
    include __DIR__ . '/../layout/dashboard_header.php';
} else {
    include __DIR__ . '/../layout/pl_dashboard_header.php';
}

$aiResult  = $_SESSION['ai_result'] ?? null;
$aiInput   = $_SESSION['ai_input']  ?? '';
unset($_SESSION['ai_result'], $_SESSION['ai_input']);

// Colour palette for labels
$colours = [
    '#00ffcc','#00b3ff','#ff6b6b','#ffd700','#a78bfa','#34d399','#f472b6','#fb923c'
];
?>

<div class="page-header">
    <div>
        <div class="page-header-title">🤖 Analyse IA de Profil</div>
        <div class="page-header-sub">HuggingFace · Classifiez votre profil et découvrez votre domaine métier idéal</div>
    </div>
</div>

<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger"><?php foreach ($_SESSION['errors'] as $e) echo htmlspecialchars($e); unset($_SESSION['errors']); ?></div>
<?php endif; ?>

<!-- Info banner -->
<div class="dsh-card" style="background:linear-gradient(135deg,rgba(0,255,204,0.06),rgba(0,179,255,0.06));border-color:rgba(0,255,204,0.2);padding:20px 24px;margin-bottom:20px;display:flex;align-items:flex-start;gap:16px;">
    <div style="font-size:2.2rem;line-height:1;">🧠</div>
    <div>
        <div style="font-weight:700;color:#fff;margin-bottom:4px;">Intelligence Artificielle — HuggingFace Zero-Shot Classification</div>
        <div style="font-size:0.82rem;color:#666;line-height:1.6;">
            Ce module utilise le modèle <strong style="color:#00ffcc">facebook/bart-large-mnli</strong> de HuggingFace pour analyser votre texte libre
            (compétences, expériences, ambitions) et le classer automatiquement parmi les grands domaines professionnels.
            Cela vous aide à identifier votre orientation de carrière idéale.
        </div>
    </div>
</div>

<div style="display:flex;flex-wrap:wrap;gap:20px;align-items:flex-start;">

    <!-- Form Card -->
    <div class="dsh-card" style="flex:1;min-width:300px;padding:26px;">
        <h4 style="font-weight:700;color:#fff;margin-bottom:6px;font-size:1rem;">📝 Décrivez votre profil</h4>
        <p style="font-size:0.82rem;color:#666;margin-bottom:18px;line-height:1.6;">
            Entrez votre texte librement : compétences techniques, expériences passées, outils maîtrisés, domaines d'intérêt...
        </p>

        <form action="/workwave/Controller/index.php?action=ai_analyze_submit" method="POST" id="aiForm">
            <label style="font-size:0.72rem;font-weight:700;color:#00ffcc;text-transform:uppercase;letter-spacing:.5px;">Votre texte de profil *</label>
            <textarea id="profileTextarea" name="profile_text" rows="10" required minlength="20"
                style="width:100%;margin-top:6px;padding:12px;background:rgba(255,255,255,0.04);border:1px solid rgba(0,255,204,0.15);border-radius:8px;color:#ddd;font-size:0.88rem;resize:vertical;outline:none;line-height:1.6;font-family:inherit;transition:border-color .2s;"
                onfocus="this.style.borderColor='#00ffcc'" onblur="this.style.borderColor='rgba(0,255,204,0.15)'"
                placeholder="Ex: Je suis développeur web avec 3 ans d'expérience en PHP, JavaScript, MySQL et React. Je maîtrise Git, Docker et les APIs REST..."><?= htmlspecialchars($aiInput) ?></textarea>

            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:6px;">
                <span id="charCount" style="font-size:0.72rem;color:#555;">0 / 1000</span>
                <button type="button" onclick="clearText()" style="font-size:0.72rem;color:#666;background:none;border:none;cursor:pointer;padding:0;">✕ Effacer</button>
            </div>

            <!-- Quick fill examples -->
            <div style="margin-top:14px;">
                <div style="font-size:0.72rem;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Exemples rapides :</div>
                <div style="display:flex;flex-wrap:wrap;gap:6px;">
                    <button type="button" class="quick-fill" data-text="Développeur full-stack PHP, JavaScript, React, Node.js, MySQL, Docker. 4 ans d'expérience en développement web et API REST. Passionné par l'open source et le cloud.">💻 Dev</button>
                    <button type="button" class="quick-fill" data-text="Responsable marketing digital, gestion de campagnes SEO/SEA, réseaux sociaux, création de contenu, stratégie de marque, analytics Google et Meta Ads.">📣 Marketing</button>
                    <button type="button" class="quick-fill" data-text="Comptable confirmé, maîtrise des bilans comptables, fiscalité, audit, ERP SAP, gestion de budget d'entreprise et reporting financier mensuel.">💼 Finance</button>
                    <button type="button" class="quick-fill" data-text="Designer UI/UX, expert Figma, Photoshop, Illustrator. Création d'interfaces mobiles et web, design systems, prototypage et tests utilisateurs.">🎨 Design</button>
                </div>
            </div>

            <button type="submit" id="analyzeBtn" style="
                margin-top:20px;width:100%;padding:12px;border:none;border-radius:8px;
                background:linear-gradient(135deg,#00ffcc,#00b3ff);
                color:#000;font-weight:700;font-size:0.9rem;cursor:pointer;
                transition:transform .18s,box-shadow .18s;display:flex;align-items:center;justify-content:center;gap:8px;
            " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(0,255,204,0.3)'"
               onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                <span id="btnText">🚀 Analyser avec l'IA</span>
                <span id="btnSpinner" style="display:none;">⏳ Analyse en cours...</span>
            </button>
        </form>
    </div>

    <!-- Results Card -->
    <div class="dsh-card" style="flex:1;min-width:300px;padding:26px;">
        <h4 style="font-weight:700;color:#fff;margin-bottom:6px;font-size:1rem;">📊 Résultats de l'IA</h4>
        <p style="font-size:0.82rem;color:#666;margin-bottom:18px;">Classification de votre profil par domaine professionnel</p>

        <?php if ($aiResult && !empty($aiResult['results'])): ?>

        <!-- Source badge -->
        <div style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:20px;background:rgba(0,255,204,0.08);border:1px solid rgba(0,255,204,0.2);font-size:0.72rem;color:#00ffcc;margin-bottom:16px;">
            <span>⚡</span>
            Source : <?= htmlspecialchars($aiResult['source'] ?? 'IA') ?>
        </div>

        <!-- Top result highlight -->
        <?php $top = $aiResult['results'][0]; ?>
        <div style="padding:18px;border-radius:10px;background:linear-gradient(135deg,rgba(0,255,204,0.08),rgba(0,179,255,0.06));border:1px solid rgba(0,255,204,0.25);margin-bottom:20px;text-align:center;">
            <div style="font-size:2.5rem;margin-bottom:6px;">🏆</div>
            <div style="font-weight:800;font-size:1.15rem;color:#fff;margin-bottom:4px;"><?= htmlspecialchars($top['label']) ?></div>
            <div style="font-size:2rem;font-weight:800;color:#00ffcc;"><?= $top['score'] ?>%</div>
            <div style="font-size:0.75rem;color:#666;margin-top:4px;">Domaine recommandé principal</div>
        </div>

        <!-- All scores as bar chart -->
        <?php foreach ($aiResult['results'] as $i => $item): ?>
        <?php $colour = $colours[$i % count($colours)]; ?>
        <div style="margin-bottom:14px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                <span style="font-size:0.83rem;color:#ccc;font-weight:500;"><?= htmlspecialchars($item['label']) ?></span>
                <span style="font-size:0.82rem;color:<?= $colour ?>;font-weight:700;"><?= $item['score'] ?>%</span>
            </div>
            <div style="height:8px;background:rgba(255,255,255,0.04);border-radius:10px;overflow:hidden;">
                <div class="ai-bar" data-width="<?= $item['score'] ?>" style="height:100%;width:0%;background:<?= $colour ?>;border-radius:10px;transition:width 1s cubic-bezier(.4,0,.2,1);"></div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Radar Chart -->
        <div style="margin-top:20px;padding-top:20px;border-top:1px solid rgba(0,255,204,0.07);">
            <canvas id="aiRadarChart" style="max-height:260px;"></canvas>
        </div>

        <?php else: ?>
        <!-- Empty state -->
        <div style="text-align:center;padding:60px 20px;color:#444;">
            <div style="font-size:4rem;margin-bottom:16px;opacity:.5;">🤖</div>
            <div style="font-weight:700;color:#666;margin-bottom:8px;">En attente d'analyse</div>
            <div style="font-size:0.82rem;color:#444;line-height:1.6;">
                Remplissez le formulaire à gauche et cliquez sur « Analyser » pour voir votre classification IA.
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Tips card -->
<div class="dsh-card" style="margin-top:4px;padding:20px 24px;background:rgba(255,255,255,0.02);">
    <div style="font-weight:700;color:#fff;margin-bottom:10px;font-size:0.9rem;">💡 Conseils pour une meilleure analyse</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;">
        <?php
        $tips = [
            ['📌','Citez vos compétences techniques précises (langages, outils, logiciels)'],
            ['📚','Mentionnez vos diplômes et certifications obtenus'],
            ['🎯','Décrivez vos objectifs et secteurs qui vous attirent'],
            ['📋','Incluez vos expériences professionnelles passées'],
        ];
        foreach ($tips as $tip):
        ?>
        <div style="display:flex;gap:10px;align-items:flex-start;padding:12px;border-radius:8px;background:rgba(0,255,204,0.03);border:1px solid rgba(0,255,204,0.07);">
            <span style="font-size:1.2rem;flex-shrink:0;"><?= $tip[0] ?></span>
            <span style="font-size:0.8rem;color:#777;line-height:1.5;"><?= $tip[1] ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
if ($isAdmin) {
    include __DIR__ . '/../layout/dashboard_footer.php';
} else {
    include __DIR__ . '/../layout/pl_dashboard_footer.php';
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Animate progress bars on load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ai-bar').forEach(function(bar) {
        setTimeout(function() {
            bar.style.width = bar.dataset.width + '%';
        }, 100);
    });

    // Char counter
    const ta = document.getElementById('profileTextarea');
    const cc = document.getElementById('charCount');
    if (ta && cc) {
        function updateCount() {
            const len = ta.value.length;
            cc.textContent = len + ' / 1000';
            cc.style.color = len >= 20 ? '#00ffcc' : '#ff6b6b';
            if (len > 1000) ta.value = ta.value.slice(0, 1000);
        }
        ta.addEventListener('input', updateCount);
        updateCount();
    }

    // Quick fill buttons
    document.querySelectorAll('.quick-fill').forEach(function(btn) {
        btn.style.cssText = 'padding:4px 10px;font-size:0.75rem;background:rgba(0,255,204,0.07);border:1px solid rgba(0,255,204,0.2);border-radius:20px;color:#00ffcc;cursor:pointer;transition:background .15s;';
        btn.addEventListener('mouseover', function() { this.style.background='rgba(0,255,204,0.14)'; });
        btn.addEventListener('mouseout',  function() { this.style.background='rgba(0,255,204,0.07)'; });
        btn.addEventListener('click', function() {
            if (ta) { ta.value = this.dataset.text; updateCount && updateCount(); }
        });
    });

    // Spinner on submit
    const form = document.getElementById('aiForm');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('btnText').style.display = 'none';
            document.getElementById('btnSpinner').style.display = 'inline';
            document.getElementById('analyzeBtn').disabled = true;
        });
    }

    // Radar chart if results present
    <?php if ($aiResult && !empty($aiResult['results'])): ?>
    const ctx = document.getElementById('aiRadarChart');
    if (ctx && typeof Chart !== 'undefined') {
        const labels = <?= json_encode(array_column($aiResult['results'], 'label')) ?>;
        const scores = <?= json_encode(array_column($aiResult['results'], 'score')) ?>;
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Score (%)',
                    data: scores,
                    backgroundColor: 'rgba(0,255,204,0.1)',
                    borderColor: '#00ffcc',
                    borderWidth: 2,
                    pointBackgroundColor: '#00ffcc',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    r: {
                        min: 0, max: 100,
                        ticks: { color: '#555', font: { size: 10 }, stepSize: 20 },
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        angleLines: { color: 'rgba(255,255,255,0.05)' },
                        pointLabels: { color: '#888', font: { size: 10 } }
                    }
                }
            }
        });
    }
    <?php endif; ?>
});

function clearText() {
    const ta = document.getElementById('profileTextarea');
    if (ta) { ta.value = ''; const e = new Event('input'); ta.dispatchEvent(e); }
}
</script>
