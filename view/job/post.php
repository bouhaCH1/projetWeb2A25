<?php
$pageTitle = 'Post a Job';
include __DIR__ . '/../layout/dashboard_header.php';
$old = $_SESSION['old_job'] ?? [];
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Post a Job</div>
        <div class="page-header-sub">Create a new listing. All validation is handled server-side by PHP.</div>
    </div>
    <a href="/workwave/Controller/index.php?action=my_jobs" class="btn btn-secondary">← My Listings</a>
</div>

<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger"><ul>
        <?php foreach ($_SESSION['errors'] as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; unset($_SESSION['errors']); ?>
    </ul></div>
<?php endif; ?>

<div class="dsh-card" style="max-width:640px;">
    <form id="jobPostForm" action="/workwave/Controller/index.php?action=job_post_submit" method="POST" novalidate>

        <label>Job Title *</label>
        <input type="text" name="title" value="<?= htmlspecialchars($old['title'] ?? '') ?>">

        <label>Employment Type *</label>
        <select name="employment_type">
            <?php
            $opts = ['full_time' => 'Full-time', 'part_time' => 'Part-time', 'contract' => 'Contract', 'internship' => 'Internship'];
            $sel  = $old['employment_type'] ?? 'full_time';
            foreach ($opts as $val => $lab):
            ?>
                <option value="<?= htmlspecialchars($val) ?>" <?= $sel === $val ? 'selected' : '' ?>><?= htmlspecialchars($lab) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Location <small style="color:#555;font-weight:400;">(optional)</small></label>
        <input type="text" name="location" value="<?= htmlspecialchars($old['location'] ?? '') ?>" placeholder="City or Remote">

        <label>Salary / Compensation <small style="color:#555;font-weight:400;">(optional)</small></label>
        <input type="text" name="salary_range" value="<?= htmlspecialchars($old['salary_range'] ?? '') ?>" placeholder="e.g. €45k–55k">

        <label>Job Description * <small style="color:#555;font-weight:400;">(min. 30 characters)</small></label>
        <textarea name="description" rows="10"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>

        <br><br>
        <button type="submit" class="btn btn-primary">Publish Job</button>
        <a href="/workwave/Controller/index.php?action=my_jobs" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php unset($_SESSION['old_job']); ?>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
