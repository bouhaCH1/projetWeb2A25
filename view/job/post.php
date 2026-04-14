<?php
include __DIR__ . '/../layout/header.php';
$old = $_SESSION['old_job'] ?? [];
?>

<div class="content_box">
    <h1>Post a job</h1>
    <p>Create a new listing for job seekers. Validation is performed on the server (PHP), not via HTML5 constraint attributes.</p>

    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger"><ul>
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </ul></div>
    <?php endif; ?>

    <form id="jobPostForm" action="/workwave/Controller/index.php?action=job_post_submit" method="POST" novalidate>
        <label>Job title *</label>
        <input type="text" name="title" value="<?= htmlspecialchars($old['title'] ?? '') ?>">

        <label>Employment type *</label>
        <select name="employment_type">
            <?php
            $opts = [
                'full_time'  => 'Full-time',
                'part_time'  => 'Part-time',
                'contract'   => 'Contract',
                'internship' => 'Internship',
            ];
            $sel = $old['employment_type'] ?? 'full_time';
            foreach ($opts as $val => $lab):
            ?>
                <option value="<?= htmlspecialchars($val) ?>" <?= $sel === $val ? 'selected' : '' ?>><?= htmlspecialchars($lab) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Location</label>
        <input type="text" name="location" value="<?= htmlspecialchars($old['location'] ?? '') ?>" placeholder="City or remote">

        <label>Salary / compensation (optional)</label>
        <input type="text" name="salary_range" value="<?= htmlspecialchars($old['salary_range'] ?? '') ?>" placeholder="e.g. €45k–55k">

        <label>Description * <small style="color:#aaa;">(min. 30 characters)</small></label>
        <textarea name="description" rows="12"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>

        <br/>
        <button type="submit" class="btn btn-primary">Publish job</button>
        <a href="/workwave/Controller/index.php?action=my_jobs" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php unset($_SESSION['old_job']); ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
