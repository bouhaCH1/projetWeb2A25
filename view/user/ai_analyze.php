<?php
$pageTitle = 'Analyse IA de Profil';
$isAdmin   = ($_SESSION['user_role'] ?? '') === 'admin';
if ($isAdmin) {
    include __DIR__ . '/../layout/dashboard_header.php';
} else {
    include __DIR__ . '/../layout/pl_dashboard_header.php';
}

$aiResult = $_SESSION['ai_result'] ?? null;
$aiInput  = $_SESSION['ai_input']  ?? '';
unset($_SESSION['ai_result'], $_SESSION['ai_input']);

// Build prefill hint from saved session profile
$prefillText = '';
$firstName   = $_SESSION['user_first_name'] ?? '';
$userRole    = $_SESSION['user_role']        ?? '';
if ($firstName) {
    $prefillText = trim($firstName . ' ' . ($_SESSION['user_last_name'] ?? ''));
    if ($userRole === 'job_seeker') {
        $prefillText .= "\nCandidature en tant que chercheur d'emploi.";
    } elseif ($userRole === 'employer') {
        $prefillText .= "\nEmployeur / Recruteur.";
    }
}

// Colour palette for bars
$colours = [
    '#00ffcc','#00b3ff','#ff6b6b','#ffd700','#a78bfa','#34d399','#f472b6','#fb923c'
];

// Per-domain recommendations
$domainData = [
    'Informatique & Développement' => [
        'icon'   => '💻',
        'jobs'   => ['Développeur Full-Stack','Ingénieur Logiciel','Data Analyst','DevOps','Chef de Projet IT'],
        'skills' => ['Docker & CI/CD','Cloud (AWS/Azure)','Tests unitaires','Architecture microservices'],
    ],
    'Marketing & Communication' => [
        'icon'   => '📣',
        'jobs'   => ['Responsable Marketing Digital','Community Manager','Chef de Produit','Chargé de Communication','SEO Manager'],
        'skills' => ['Google Analytics 4','Meta Ads Manager','Email automation','Brand strategy'],
    ],
    'Finance & Comptabilité' => [
        'icon'   => '💼',
        'jobs'   => ['Comptable','Contrôleur de Gestion','Auditeur','Analyste Financier','DAF'],
        'skills' => ['ERP SAP / Sage','Reporting IFRS','Fiscalité internationale','Modélisation financière'],
    ],
    'Design & Créativité' => [
        'icon'   => '🎨',
        'jobs'   => ['UI/UX Designer','Directeur Artistique','Motion Designer','Product Designer','Illustrateur'],
        'skills' => ['Figma / Adobe XD','Design System','Tests utilisateurs','3D & Motion (Blender)'],
    ],
    'Ressources Humaines' => [
        'icon'   => '🤝',
        'jobs'   => ['Chargé RH','Responsable Recrutement','HRBP','Gestionnaire de Formation','DRH'],
        'skills' => ['GPEC','SIRH (Workday/SAP HR)','Droit du travail','Assessment center'],
    ],
    'Commerce & Ventes' => [
        'icon'   => '🛒',
        'jobs'   => ['Commercial B2B','Account Manager','Business Developer','Responsable Grands Comptes','Directeur Commercial'],
        'skills' => ['CRM Salesforce / HubSpot','Négociation avancée','Social Selling','KPIs & Pipeline'],
    ],
    'Ingénierie & Technique' => [
        'icon'   => '⚙️',
        'jobs'   => ['Ingénieur Mécanique','Chef de Projet BTP','Ingénieur Électronique','Technicien Industriel','Ingénieur Qualité'],
        'skills' => ['AutoCAD / SolidWorks','Gestion de projet (PMP)','Lean Manufacturing','Bureau des méthodes'],
    ],
    'Santé & Médecine' => [
        'icon'   => '🏥',
        'jobs'   => ['Médecin Généraliste','Infirmier(e)','Technicien de Laboratoire','Pharmacien','Coordinateur Médical'],
        'skills' => ['Protocoles de soin','Logiciels médicaux (DMP)','Gestion des urgences','Recherche clinique'],
    ],
];

$topResult = !empty($aiResult['results']) ? $aiResult['results'][0] : null;
$topData   = $topResult ? ($domainData[$topResult['label']] ?? null) : null;
?>

<div class="page-header">
    <div>
        <div class="page-header-title">🤖 Analyse IA de Profil</div>
        <div class="page-header-sub">HuggingFace · Identifiez votre domaine idéal et obtenez des recommandations concrètes</div>
    </div>
</div>

<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger" style="margin-bottom:16px;">
        <?php foreach ($_SESSION['errors'] as $e) echo htmlspecialchars($e); unset($_SESSION['errors']); ?>
    </div>
<?php endif; ?>

<!-- Info banner -->
<div class="dsh-card" style="background:linear-gradient(135deg,rgba(0,255,204,0.06),rgba(0,179,255,0.06));border-color:rgba(0,255,204,0.2);padding:20px 24px;margin-bottom:20px;display:flex;align-items:flex-start;gap:16px;">
    <div style="font-size:2rem;line-height:1;">🧠</div>
    <div>
        <div style="font-weight:700;color:#fff;margin-bottom:4px;">Intelligence Artificielle — HuggingFace Zero-Shot Classification</div>
        <div style="font-size:0.82rem;color:#666;line-height:1.6;">
            Ce module utilise le modèle <strong style="color:#00ffcc">facebook/bart-large-mnli</strong> pour analyser votre texte
            et le classer parmi les grands domaines professionnels. Vous obtenez ensuite des recommandations concrètes :
            titres de postes ciblés et compétences à développer.
        </div>
    </div>
</div>

<div style="display:flex;flex-wrap:wrap;gap:20px;align-items:flex-start;">

    <!-- FORM -->
    <div class="dsh-card" style="flex:1;min-width:300px;padding:26px;">
        <h4 style="font-weight:700;color:#fff;margin-bottom:6px;font-size:1rem;">📝 Décrivez votre profil</h4>
        <p style="font-size:0.82rem;color:#666;margin-bottom:18px;line-height:1.6;">
            Compétences, expériences, outils maîtrisés, ambitions professionnelles…
        </p>

        <?php if ($prefillText): ?>
        <button type="button" id="prefillBtn"
            style="width:100%;margin-bottom:14px;padding:9px;border:1px dashed rgba(0,255,204,0.3);border-radius:8px;background:rgba(0,255,204,0.04);color:#00ffcc;font-size:0.8rem;cursor:pointer;text-align:left;">
            ✨ Utiliser mes informations de profil comme point de départ
        </button>
        <?php endif; ?>

        <form action="/workwave/Controller/index.php?action=ai_analyze_submit" method="POST" id="aiForm">

            <label style="font-size:0.72rem;font-weight:700;color:#00ffcc;text-transform:uppercase;letter-spacing:.5px;">Votre texte de profil *</label>
            <textarea id="profileTextarea" name="profile_text" rows="10"
                style="width:100%;margin-top:6px;padding:12px;background:rgba(255,255,255,0.04);border:1px solid rgba(0,255,204,0.15);border-radius:8px;color:#ddd;font-size:0.88rem;resize:vertical;outline:none;line-height:1.6;font-family:inherit;transition:border-color .2s;box-sizing:border-box;"
                onfocus="this.style.borderColor='#00ffcc'" onblur="this.style.borderColor='rgba(0,255,204,0.15)'"
                placeholder="Ex: Je suis développeur web avec 3 ans d'expérience en PHP, JavaScript, MySQL et React..."><?= htmlspecialchars($aiInput) ?></textarea>

            <div id="charError" style="display:none;color:#ff6b6b;font-size:0.78rem;margin-top:4px;">⚠ Veuillez entrer au moins 20 caractères.</div>

            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:6px;">
                <span id="charCount" style="font-size:0.72rem;color:#555;">0 / 1000</span>
                <button type="button" onclick="clearText()" style="font-size:0.72rem;color:#666;background:none;border:none;cursor:pointer;padding:0;">✕ Effacer</button>
            </div>

            <!-- Quick fill -->
            <div style="margin-top:14px;">
                <div style="font-size:0.72rem;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Exemples rapides :</div>
                <div style="display:flex;flex-wrap:wrap;gap:6px;">
                    <button type="button" class="quick-fill" data-text="Développeur full-stack PHP, JavaScript, React, Node.js, MySQL, Docker. 4 ans d'expérience en développement web et API REST.">💻 Dev</button>
                    <button type="button" class="quick-fill" data-text="Responsable marketing digital, gestion de campagnes SEO/SEA, réseaux sociaux, création de contenu, stratégie de marque.">📣 Marketing</button>
                    <button type="button" class="quick-fill" data-text="Comptable confirmé, maîtrise des bilans comptables, fiscalité, audit, ERP SAP, gestion de budget et reporting financier.">💼 Finance</button>
                    <button type="button" class="quick-fill" data-text="Designer UI/UX, expert Figma, Photoshop, Illustrator. Création d'interfaces mobiles et web, design systems, tests utilisateurs.">🎨 Design</button>
                </div>
            </div>

            <button type="submit" id="analyzeBtn"
                style="margin-top:20px;width:100%;padding:12px;border:none;border-radius:8px;background:linear-gradient(135deg,#00ffcc,#00b3ff);color:#000;font-weight:700;font-size:0.9rem;cursor:pointer;transition:transform .18s,box-shadow .18s;display:flex;align-items:center;justify-content:center;gap:8px;"
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(0,255,204,0.3)'"
                onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                <span id="btnText">🚀 Analyser avec l'IA</span>
                <span id="btnSpinner" style="display:none;">⏳ Analyse en cours…</span>
            </button>
        </form>
    </div>

    <!-- RESULTS -->
    <div class="dsh-card" style="flex:1;min-width:300px;padding:26px;">
        <h4 style="font-weight:700;color:#fff;margin-bottom:6px;font-size:1rem;">📊 Résultats de l'IA</h4>
        <p style="font-size:0.82rem;color:#666;margin-bottom:18px;">Classification de votre profil par domaine professionnel</p>

        <?php if ($aiResult && !empty($aiResult['results'])): ?>

        <?php
        $isRealAPI = isset($aiResult['source']) && str_contains($aiResult['source'], 'HuggingFace API');
        $badgeColor = $isRealAPI ? '#00ffcc' : '#ffd700';
        $badgeBg    = $isRealAPI ? 'rgba(0,255,204,0.08)' : 'rgba(255,215,0,0.08)';
        $badgeBorder= $isRealAPI ? 'rgba(0,255,204,0.2)'  : 'rgba(255,215,0,0.25)';
        $sourceIcon = $isRealAPI ? '⚡' : '🧮';
        ?>
        <!-- Source badge -->
        <div style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:20px;background:<?= $badgeBg ?>;border:1px solid <?= $badgeBorder ?>;font-size:0.72rem;color:<?= $badgeColor ?>;margin-bottom:16px;">
            <span><?= $sourceIcon ?></span> Source : <?= htmlspecialchars($aiResult['source'] ?? 'IA') ?>
        </div>

        <!-- Top domain highlight -->
        <?php if ($topResult && $topData): ?>
        <div style="background:linear-gradient(135deg,rgba(0,255,204,0.08),rgba(0,179,255,0.05));border:1px solid rgba(0,255,204,0.25);border-radius:12px;padding:18px;margin-bottom:20px;">
            <div style="font-size:0.72rem;color:#888;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">🏆 Domaine dominant</div>
            <div style="font-size:1.4rem;margin-bottom:4px;"><?= $topData['icon'] ?></div>
            <div style="font-size:1.05rem;font-weight:700;color:#00ffcc;margin-bottom:2px;"><?= htmlspecialchars($topResult['label']) ?></div>
            <div style="font-size:1.8rem;font-weight:900;color:#fff;"><?= $topResult['score'] ?>%</div>
        </div>
        <?php endif; ?>

        <!-- Bar chart -->
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

        <!-- Radar chart -->
        <div style="margin-top:20px;padding-top:20px;border-top:1px solid rgba(0,255,204,0.07);">
            <canvas id="aiRadarChart" style="max-height:260px;"></canvas>
        </div>

        <?php else: ?>
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

<!-- RECOMMENDATIONS — only shown when results exist -->
<?php if ($topResult && $topData): ?>
<div style="display:flex;flex-wrap:wrap;gap:20px;margin-top:20px;">

    <div class="dsh-card" style="flex:1;min-width:260px;padding:22px;">
        <div style="font-weight:700;color:#fff;margin-bottom:14px;font-size:0.95rem;">🎯 Titres de postes recommandés</div>
        <div style="display:flex;flex-direction:column;gap:10px;">
            <?php foreach ($topData['jobs'] as $job): ?>
            <div style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:rgba(0,255,204,0.04);border:1px solid rgba(0,255,204,0.1);border-radius:8px;">
                <span style="color:#00ffcc;">▶</span>
                <span style="color:#ccc;font-size:0.85rem;"><?= htmlspecialchars($job) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="dsh-card" style="flex:1;min-width:260px;padding:22px;">
        <div style="font-weight:700;color:#fff;margin-bottom:14px;font-size:0.95rem;">📈 Compétences à développer</div>
        <div style="display:flex;flex-direction:column;gap:10px;">
            <?php foreach ($topData['skills'] as $skill): ?>
            <div style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:rgba(0,179,255,0.04);border:1px solid rgba(0,179,255,0.1);border-radius:8px;">
                <span style="color:#00b3ff;">+</span>
                <span style="color:#ccc;font-size:0.85rem;"><?= htmlspecialchars($skill) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
<?php endif; ?>

<!-- Tips -->
<div class="dsh-card" style="margin-top:20px;padding:20px 24px;background:rgba(255,255,255,0.02);">
    <div style="font-weight:700;color:#fff;margin-bottom:10px;font-size:0.9rem;">💡 Conseils pour une meilleure analyse</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;">
        <?php foreach ([
            ['📌','Citez vos compétences techniques précises (langages, outils, logiciels)'],
            ['📚','Mentionnez vos diplômes et certifications obtenus'],
            ['🎯','Décrivez vos objectifs et les secteurs qui vous attirent'],
            ['📋','Incluez vos expériences professionnelles passées'],
        ] as $tip): ?>
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
document.addEventListener('DOMContentLoaded', function () {

    // Animate bars
    document.querySelectorAll('.ai-bar').forEach(function (bar) {
        setTimeout(function () { bar.style.width = bar.dataset.width + '%'; }, 100);
    });

    // Char counter (no HTML5 required/minlength — validation is server-side)
    var ta = document.getElementById('profileTextarea');
    var cc = document.getElementById('charCount');
    var ce = document.getElementById('charError');

    function updateCount() {
        if (!ta || !cc) return;
        var len = ta.value.length;
        cc.textContent = len + ' / 1000';
        cc.style.color = len >= 20 ? '#00ffcc' : '#ff6b6b';
        if (len > 1000) ta.value = ta.value.slice(0, 1000);
    }
    if (ta) { ta.addEventListener('input', updateCount); updateCount(); }

    // Client-side guard before submit (replaces removed HTML5 required/minlength)
    var form = document.getElementById('aiForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            var len = ta ? ta.value.trim().length : 0;
            if (len < 20) {
                e.preventDefault();
                if (ce) ce.style.display = 'block';
                if (ta) ta.focus();
                return;
            }
            if (ce) ce.style.display = 'none';
            document.getElementById('btnText').style.display    = 'none';
            document.getElementById('btnSpinner').style.display = 'inline';
            document.getElementById('analyzeBtn').disabled      = true;
        });
    }

    // Quick fill buttons
    document.querySelectorAll('.quick-fill').forEach(function (btn) {
        btn.style.cssText = 'padding:4px 10px;font-size:0.75rem;background:rgba(0,255,204,0.07);border:1px solid rgba(0,255,204,0.2);border-radius:20px;color:#00ffcc;cursor:pointer;transition:background .15s;';
        btn.addEventListener('mouseover', function () { this.style.background = 'rgba(0,255,204,0.14)'; });
        btn.addEventListener('mouseout',  function () { this.style.background = 'rgba(0,255,204,0.07)'; });
        btn.addEventListener('click', function () { if (ta) { ta.value = this.dataset.text; updateCount(); } });
    });

    // Prefill from saved profile
    var prefillBtn  = document.getElementById('prefillBtn');
    var prefillText = <?= json_encode($prefillText) ?>;
    if (prefillBtn && prefillText) {
        prefillBtn.addEventListener('click', function () {
            if (ta) { ta.value = prefillText; updateCount(); ta.focus(); }
        });
    }

    // Radar chart
    <?php if ($aiResult && !empty($aiResult['results'])): ?>
    var ctx = document.getElementById('aiRadarChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: <?= json_encode(array_column($aiResult['results'], 'label')) ?>,
                datasets: [{
                    label: 'Score (%)',
                    data: <?= json_encode(array_column($aiResult['results'], 'score')) ?>,
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
                        ticks:       { color: '#555', font: { size: 10 }, stepSize: 20 },
                        grid:        { color: 'rgba(255,255,255,0.05)' },
                        angleLines:  { color: 'rgba(255,255,255,0.05)' },
                        pointLabels: { color: '#888', font: { size: 10 } }
                    }
                }
            }
        });
    }
    <?php endif; ?>
});

function clearText() {
    var ta = document.getElementById('profileTextarea');
    if (ta) { ta.value = ''; ta.dispatchEvent(new Event('input')); }
}
</script>
