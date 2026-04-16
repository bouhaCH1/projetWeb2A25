<?php
$pageTitle = 'Manage My CV';
include __DIR__ . '/../layout/dashboard_header.php';
$old = $_SESSION['old_cv'] ?? $cv ?? [];
?>

<div class="page-header">
    <div>
        <div class="page-header-title">My CV</div>
        <div class="page-header-sub">Create or update your professional details. All validation is handled server-side by PHP.</div>
    </div>
</div>

<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger"><ul>
        <?php foreach ($_SESSION['errors'] as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; unset($_SESSION['errors']); ?>
    </ul></div>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<div class="dsh-card" style="max-width:640px;">
    <form id="cvForm" action="/workwave/Controller/index.php?action=cv_submit" method="POST" novalidate>

        <label>Professional Title *</label>
        <input type="text" name="professional_title" value="<?= htmlspecialchars($old['professional_title'] ?? '') ?>" placeholder="e.g. Senior Graphic Designer">

        <label>Skills * <small style="color:#555;font-weight:400;">(Comma separated)</small></label>
        <input type="text" name="skills" value="<?= htmlspecialchars($old['skills'] ?? '') ?>" placeholder="e.g. Photoshop, Illustrator, UI/UX">

        <label>Years of Experience *</label>
        <input type="text" name="experience_years" value="<?= htmlspecialchars((string)($old['experience_years'] ?? '')) ?>" placeholder="e.g. 5">

        <label>Hourly Rate <small style="color:#555;font-weight:400;">(optional)</small></label>
        <input type="text" name="hourly_rate" value="<?= htmlspecialchars($old['hourly_rate'] ?? '') ?>" placeholder="e.g. €50/hr">

        <label>About Me *</label>
        <textarea name="about_me" rows="8"><?= htmlspecialchars($old['about_me'] ?? '') ?></textarea>

        <br><br>
        <button type="submit" class="btn btn-primary">Save CV</button>
    </form>
</div>
<?php unset($_SESSION['old_cv']); ?>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
