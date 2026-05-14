<section class="ww-page">
    <h1>Companies</h1>
    <form class="ww-filter" method="get"><input type="hidden" name="r" value="companies"><input name="industry" value="<?= e($filters['industry'] ?? '') ?>" placeholder="Industry"><button>Search</button></form>
    <div class="ww-card-grid">
        <?php foreach ($companies as $c): ?>
            <article class="ww-card">
                <h2><?= e($c['company_name']) ?></h2>
                <p><?= e($c['description']) ?></p>
                <div class="ww-tags"><span><?= e($c['industry']) ?></span><span><?= e($c['city']) ?></span><span><?= e($c['phone']) ?></span></div>
                <a class="ww-secondary small" href="<?= e($c['website']) ?>">Website</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
