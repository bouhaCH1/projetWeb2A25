<section class="ww-dashboard">
    <header class="ww-dash-head">
        <div>
            <p class="ww-kicker">Freelancer dashboard</p>
            <h1><?= e(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? '')) ?></h1>
            <p><?= e($profile['bio'] ?? 'Complete your profile to start applying with confidence.') ?></p>
        </div>
        <div id="qr-code" class="ww-qr-code" data-url="<?= e(absoluteRouteUrl('p', ['token' => $profile['qr_token'] ?? ''])) ?>"></div>
    </header>

    <div class="ww-stat-row">
        <?php foreach (['total'=>'Applications','accepted'=>'Accepted','pending'=>'Pending','rejected'=>'Rejected','completed'=>'Projects','views'=>'Profile views'] as $key => $label): ?>
            <article class="ww-mini-stat"><strong><?= e((string)$stats[$key]) ?></strong><span><?= e($label) ?></span></article>
        <?php endforeach; ?>
    </div>

    <div class="ww-grid-2">
        <section class="ww-box">
            <h2>Profile</h2>
            <form method="post" action="<?= routeUrl('freelancer/profile') ?>" enctype="multipart/form-data" class="ww-form">
                <?= csrf() ?>
                <div class="ww-two"><label>First name <input name="first_name" value="<?= e($profile['first_name'] ?? '') ?>"></label><label>Last name <input name="last_name" value="<?= e($profile['last_name'] ?? '') ?>"></label></div>
                <div class="ww-two"><label>Phone <input name="phone" value="<?= e($profile['phone'] ?? '') ?>"></label><label>City <input name="city" value="<?= e($profile['city'] ?? '') ?>"></label></div>
                <div class="ww-two"><label>Governorate <input name="governorate" value="<?= e($profile['governorate'] ?? '') ?>"></label><label>Address <input name="address" value="<?= e($profile['address'] ?? '') ?>"></label></div>
                <label>Bio <textarea name="bio"><?= e($profile['bio'] ?? '') ?></textarea></label>
                <div class="ww-three"><label>LinkedIn <input name="linkedin" value="<?= e($profile['linkedin'] ?? '') ?>"></label><label>GitHub <input name="github" value="<?= e($profile['github'] ?? '') ?>"></label><label>Website <input name="website" value="<?= e($profile['website'] ?? '') ?>"></label></div>
                <div class="ww-two"><label>Latitude <input name="lat" value="<?= e((string)($profile['lat'] ?? '')) ?>"></label><label>Longitude <input name="lng" value="<?= e((string)($profile['lng'] ?? '')) ?>"></label></div>
                <div class="ww-two"><label>Profile picture <input type="file" name="avatar" accept="image/*"></label><label>CV PDF <input type="file" name="cv" accept="application/pdf"></label></div>
                <button class="cta-button">Save Profile</button>
                <?php if (!empty($profile['cv_path'])): ?><a class="ww-secondary small" target="_blank" href="<?= assetUrl($profile['cv_path']) ?>">Preview CV</a><?php endif; ?>
            </form>
        </section>

        <section class="ww-box">
            <h2>Notifications</h2>
            <?php foreach ($notifications as $note): ?><p class="ww-note"><strong><?= e($note['title']) ?></strong><br><?= e($note['message']) ?></p><?php endforeach; ?>
            <?php if (!$notifications): ?><p>No notifications yet.</p><?php endif; ?>
        </section>
    </div>

    <div class="ww-grid-3">
        <section class="ww-box">
            <h2>Skills</h2>
            <form method="post" action="<?= routeUrl('freelancer/skill') ?>" class="ww-form compact"><?= csrf() ?><input name="name" placeholder="Skill" required><input name="category" placeholder="Category" required><input type="number" name="level" min="1" max="100" placeholder="Level" required><button>Add</button></form>
            <?php foreach ($skills as $skill): ?><div class="ww-progress"><span><?= e($skill['name']) ?> · <?= e($skill['category']) ?></span><b style="width:<?= (int)$skill['level'] ?>%"></b></div><?php endforeach; ?>
        </section>
        <section class="ww-box">
            <h2>Diplomas</h2>
            <form method="post" action="<?= routeUrl('freelancer/diploma') ?>" class="ww-form compact"><?= csrf() ?><input name="title" placeholder="Diploma" required><input name="institution" placeholder="Institution" required><input type="number" name="graduation_year" placeholder="Year" required><button>Add</button></form>
            <?php foreach ($diplomas as $d): ?><p><?= e($d['title']) ?> · <?= e($d['institution']) ?> · <?= e((string)$d['graduation_year']) ?></p><?php endforeach; ?>
        </section>
        <section class="ww-box">
            <h2>Certificates</h2>
            <form method="post" action="<?= routeUrl('freelancer/certificate') ?>" enctype="multipart/form-data" class="ww-form compact"><?= csrf() ?><input name="title" placeholder="Title" required><input type="file" name="certificate" accept="application/pdf" required><button>Upload</button></form>
            <?php foreach ($certificates as $c): ?><p><a target="_blank" href="<?= assetUrl($c['file_path']) ?>"><?= e($c['title']) ?></a></p><?php endforeach; ?>
        </section>
    </div>

    <div class="ww-grid-2">
        <section class="ww-box">
            <h2>Portfolio</h2>
            <form method="post" action="<?= routeUrl('freelancer/project') ?>" enctype="multipart/form-data" class="ww-form">
                <?= csrf() ?><input name="title" placeholder="Project title" required><textarea name="description" placeholder="Description"></textarea><input name="technologies" placeholder="Technologies"><div class="ww-two"><input name="github_url" placeholder="GitHub URL"><input name="demo_url" placeholder="Live demo URL"></div><input type="file" name="image" accept="image/*"><button>Add Project</button>
            </form>
            <?php foreach ($projects as $p): ?><article class="ww-list-card"><strong><?= e($p['title']) ?></strong><p><?= e($p['description']) ?></p><span><?= e($p['technologies']) ?></span></article><?php endforeach; ?>
        </section>
        <section class="ww-box">
            <h2>Applications</h2>
            <table class="ww-table"><tr><th>Job</th><th>Company</th><th>Status</th></tr><?php foreach ($applications as $a): ?><tr><td><?= e($a['title']) ?></td><td><?= e($a['company_name']) ?></td><td><span class="ww-badge"><?= e($a['status']) ?></span></td></tr><?php endforeach; ?></table>
        </section>
    </div>
</section>
