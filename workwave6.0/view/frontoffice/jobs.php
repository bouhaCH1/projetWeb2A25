<section class="ww-page">
    <h1>Jobs</h1>
    <form class="ww-filter" method="get"><input type="hidden" name="r" value="jobs"><input name="q" value="<?= e($filters['q'] ?? '') ?>" placeholder="Search skills or title"><input name="category" value="<?= e($filters['category'] ?? '') ?>" placeholder="Category"><input name="location" value="<?= e($filters['location'] ?? '') ?>" placeholder="Location"><input type="number" name="salary_min" value="<?= e($filters['salary_min'] ?? '') ?>" placeholder="Min salary"><button>Filter</button></form>
    <div class="ww-card-grid">
        <?php foreach ($jobs as $job): ?>
            <article class="ww-card">
                <p class="ww-kicker"><?= e($job['company_name']) ?> · <?= e($job['industry']) ?></p>
                <h2><?= e($job['title']) ?></h2>
                <p><?= e($job['description']) ?></p>
                <div class="ww-tags"><span><?= e($job['contract_type']) ?></span><span><?= e($job['experience_level']) ?></span><span><?= e($job['location']) ?></span><span><?= e((string)$job['salary']) ?> TND</span></div>
                <p><strong>Skills:</strong> <?= e($job['required_skills']) ?></p>
                <?php if (($_SESSION['role'] ?? '') === 'freelancer'): ?>
                    <form method="post" action="<?= routeUrl('jobs/apply') ?>" class="ww-inline-form"><?= csrf() ?><input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>"><input name="message" placeholder="Application message"><button>Apply</button></form>
                    <form method="post" action="<?= routeUrl('jobs/save') ?>" class="ww-inline-form"><?= csrf() ?><input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>"><button>Save</button></form>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>
