<section class="ww-page public">
    <header class="ww-dash-head">
        <div>
            <p class="ww-kicker">Public digital profile</p>
            <h1><?= e($profile['first_name'] . ' ' . $profile['last_name']) ?></h1>
            <p><?= e($profile['bio']) ?></p>
            <div class="ww-tags"><span><?= e($profile['city']) ?></span><span><?= e($profile['email']) ?></span><span><?= e($profile['phone']) ?></span></div>
        </div>
        <?php if (!empty($profile['cv_path'])): ?><a class="cta-button" target="_blank" href="<?= assetUrl($profile['cv_path']) ?>">View CV</a><?php endif; ?>
    </header>
    <div class="ww-grid-3">
        <section class="ww-box"><h2>Skills</h2><?php foreach ($profile['skills'] as $s): ?><div class="ww-progress"><span><?= e($s['name']) ?></span><b style="width:<?= (int)$s['level'] ?>%"></b></div><?php endforeach; ?></section>
        <section class="ww-box"><h2>Diplomas</h2><?php foreach ($profile['diplomas'] as $d): ?><p><?= e($d['title']) ?><br><?= e($d['institution']) ?> · <?= e((string)$d['graduation_year']) ?></p><?php endforeach; ?></section>
        <section class="ww-box"><h2>Certificates</h2><?php foreach ($profile['certificates'] as $c): ?><p><a target="_blank" href="<?= assetUrl($c['file_path']) ?>"><?= e($c['title']) ?></a></p><?php endforeach; ?></section>
    </div>
    <section class="ww-box"><h2>Portfolio</h2><div class="ww-card-grid"><?php foreach ($profile['projects'] as $p): ?><article class="ww-list-card"><h3><?= e($p['title']) ?></h3><p><?= e($p['description']) ?></p><span><?= e($p['technologies']) ?></span></article><?php endforeach; ?></div></section>
</section>
