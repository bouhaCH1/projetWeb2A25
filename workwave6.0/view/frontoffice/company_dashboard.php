<section class="ww-dashboard">
    <header class="ww-dash-head">
        <div><p class="ww-kicker">Company dashboard</p><h1><?= e($profile['company_name'] ?? 'Company') ?></h1><p><?= e($profile['description'] ?? '') ?></p></div>
        <a href="<?= routeUrl('map', ['lat' => $profile['lat'] ?? 36.8065, 'lng' => $profile['lng'] ?? 10.1815]) ?>" class="cta-button">Find Nearby Talent</a>
    </header>
    <div class="ww-grid-2">
        <section class="ww-box">
            <h2>Company Profile</h2>
            <form method="post" action="<?= routeUrl('company/profile') ?>" enctype="multipart/form-data" class="ww-form">
                <?= csrf() ?><input name="company_name" value="<?= e($profile['company_name'] ?? '') ?>" placeholder="Company name"><textarea name="description" placeholder="Description"><?= e($profile['description'] ?? '') ?></textarea>
                <div class="ww-two"><input name="industry" value="<?= e($profile['industry'] ?? '') ?>" placeholder="Industry"><input name="city" value="<?= e($profile['city'] ?? '') ?>" placeholder="City"></div>
                <div class="ww-two"><input name="governorate" value="<?= e($profile['governorate'] ?? '') ?>" placeholder="Governorate"><input name="address" value="<?= e($profile['address'] ?? '') ?>" placeholder="Address"></div>
                <div class="ww-three"><input name="email" value="<?= e($profile['email'] ?? '') ?>" placeholder="Email"><input name="phone" value="<?= e($profile['phone'] ?? '') ?>" placeholder="Phone"><input name="website" value="<?= e($profile['website'] ?? '') ?>" placeholder="Website"></div>
                <div class="ww-three"><input name="lat" value="<?= e((string)($profile['lat'] ?? '')) ?>" placeholder="Latitude"><input name="lng" value="<?= e((string)($profile['lng'] ?? '')) ?>" placeholder="Longitude"><input type="file" name="logo" accept="image/*"></div>
                <button>Save Company</button>
            </form>
        </section>
        <section class="ww-box">
            <h2>Create Job</h2>
            <form method="post" action="<?= routeUrl('company/job') ?>" class="ww-form">
                <?= csrf() ?><input name="title" placeholder="Job title" required><textarea name="description" placeholder="Description" required></textarea><input name="required_skills" placeholder="Required skills" required>
                <div class="ww-two"><input type="number" step="0.01" name="salary" placeholder="Salary"><input name="location" placeholder="Location"></div>
                <div class="ww-three"><select name="contract_type"><option>remote</option><option>onsite</option><option>hybrid</option></select><select name="experience_level"><option>junior</option><option>mid</option><option>senior</option><option>lead</option></select><input name="category" placeholder="Category"></div>
                <input type="date" name="expiration_date" required><button>Publish Job</button>
            </form>
        </section>
    </div>
    <div class="ww-grid-2">
        <section class="ww-box">
            <h2>Jobs</h2>
            <table class="ww-table"><tr><th>Title</th><th>Status</th><th>Action</th></tr><?php foreach ($jobs as $j): ?><tr><td><?= e($j['title']) ?></td><td><?= e($j['status']) ?></td><td><form method="post" action="<?= routeUrl('company/job-status') ?>"><?= csrf() ?><input type="hidden" name="id" value="<?= (int)$j['id'] ?>"><input type="hidden" name="status" value="<?= $j['status'] === 'open' ? 'closed' : 'open' ?>"><button><?= $j['status'] === 'open' ? 'Close' : 'Reopen' ?></button></form></td></tr><?php endforeach; ?></table>
        </section>
        <section class="ww-box">
            <h2>Applications</h2>
            <table class="ww-table"><tr><th>Applicant</th><th>Job</th><th>Status</th><th>Decision</th></tr><?php foreach ($applications as $a): ?><tr><td><a href="<?= routeUrl('p', ['token' => $a['qr_token']]) ?>"><?= e($a['first_name'] . ' ' . $a['last_name']) ?></a></td><td><?= e($a['title']) ?></td><td><?= e($a['status']) ?></td><td><form method="post" action="<?= routeUrl('company/application') ?>"><?= csrf() ?><input type="hidden" name="id" value="<?= (int)$a['id'] ?>"><select name="status"><option>pending</option><option>accepted</option><option>rejected</option></select><button>Save</button></form></td></tr><?php endforeach; ?></table>
        </section>
    </div>
</section>
