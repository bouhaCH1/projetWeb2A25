<section class="hero ww-hero" id="home">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <div class="hero-text">
            <h1>WORKWAVE</h1>
            <p>The freelance recruitment platform for verified talent, serious companies, smart applications, public QR profiles and location-aware hiring.</p>
            <div class="ww-actions">
                <a href="<?= routeUrl('register-freelancer') ?>" class="cta-button">Join as Freelancer</a>
                <a href="<?= routeUrl('register-company') ?>" class="ww-secondary">Hire Talent</a>
            </div>
        </div>
        <div class="hero-visual ww-signal">
            <div class="ww-ring"></div>
            <div class="ww-orbit-card one">64 freelancers</div>
            <div class="ww-orbit-card two">32 companies</div>
            <div class="ww-orbit-card three">Live jobs</div>
        </div>
    </div>
</section>

<section class="dashboard-section">
    <div class="dashboard-container">
        <h2 class="section-title">Recruitment Workspace</h2>
        <div class="stats-grid">
            <article class="stat-card"><div class="stat-title">Freelancer Profiles</div><div class="stat-value"><?= count($freelancers) ?>+</div><p class="stat-description">Public QR-ready profiles with skills, CVs, certificates, diplomas and portfolios.</p></article>
            <article class="stat-card"><div class="stat-title">Open Opportunities</div><div class="stat-value"><?= count($jobs) ?></div><p class="stat-description">Searchable jobs with salary, contract type, category and experience filters.</p></article>
            <article class="stat-card"><div class="stat-title">Company Hiring</div><div class="stat-value">Fast</div><p class="stat-description">Companies can post roles, review applicants, accept or reject applications and map nearby talent.</p></article>
        </div>
    </div>
</section>
