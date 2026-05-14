<section class="ww-page">
    <h1>Freelancers</h1>
    <form class="ww-filter" method="get"><input type="hidden" name="r" value="freelancers"><input name="skill" value="<?= e($filters['skill'] ?? '') ?>" placeholder="Skill"><input name="city" value="<?= e($filters['city'] ?? '') ?>" placeholder="City"><button>Search</button></form>
    <div class="ww-card-grid">
        <?php foreach ($freelancers as $f): ?>
            <article class="ww-card">
                <h2><?= e($f['first_name'] . ' ' . $f['last_name']) ?></h2>
                <p><?= e($f['bio']) ?></p>
                <div class="ww-tags"><span><?= e($f['city']) ?></span><span><?= e($f['governorate']) ?></span><span><?= (int)$f['profile_views'] ?> views</span></div>
                <div class="ww-card-actions">
                    <div class="ww-qr-code small" data-url="<?= e(absoluteRouteUrl('p', ['token' => $f['qr_token']])) ?>"></div>
                    <a class="ww-secondary small" href="<?= routeUrl('p', ['token' => $f['qr_token']]) ?>">Public Profile</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
