<?php
/** @var array<string, mixed> $row */
include __DIR__ . '/../layout/header.php';

$typeLabels = [
    'full_time'  => 'Full-time',
    'part_time'  => 'Part-time',
    'contract'   => 'Contract',
    'internship' => 'Internship',
];
$empName = trim(($row['employer_first_name'] ?? '') . ' ' . ($row['employer_last_name'] ?? ''));
?>

<div class="content_box">
    <p><a href="/workwave/Controller/index.php?action=jobs">&larr; Back to job list</a></p>
    <h1><?= htmlspecialchars($row['title']) ?></h1>
    <p>
        <span class="badge-employer"><?= htmlspecialchars($typeLabels[$row['employment_type']] ?? $row['employment_type']) ?></span>
        <?php if (!empty($row['location'])): ?>
            &nbsp;·&nbsp; <?= htmlspecialchars($row['location']) ?>
        <?php endif; ?>
    </p>
    <?php if (!empty($row['salary_range'])): ?>
        <p><strong>Compensation:</strong> <?= htmlspecialchars($row['salary_range']) ?></p>
    <?php endif; ?>
    <p><strong>Posted by:</strong> <?= htmlspecialchars($empName !== '' ? $empName : 'Employer') ?>
        <?php if (!empty($row['employer_email'])): ?>
            (<a href="mailto:<?= htmlspecialchars($row['employer_email']) ?>"><?= htmlspecialchars($row['employer_email']) ?></a>)
        <?php endif; ?>
    </p>
    <hr style="border-color:#333;margin:24px 0;">
    <div style="white-space:pre-wrap;"><?= nl2br(htmlspecialchars($row['description'])) ?></div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
