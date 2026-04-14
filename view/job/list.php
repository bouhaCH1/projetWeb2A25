<?php
/** @var array<int, array<string, mixed>> $jobs */
include __DIR__ . '/../layout/header.php';

$typeLabels = [
    'full_time'  => 'Full-time',
    'part_time'  => 'Part-time',
    'contract'   => 'Contract',
    'internship' => 'Internship',
];
?>

<div class="content_box">
    <h1>Job openings</h1>
    <p>Browse roles posted by employers on WorkWave.</p>

    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger"><ul>
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </ul></div>
    <?php endif; ?>

    <?php if (empty($jobs)): ?>
        <p>No jobs yet. Employers can post a listing from their dashboard.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Employer</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Posted</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($jobs as $j): ?>
                <tr>
                    <td><?= htmlspecialchars($j['title']) ?></td>
                    <td><?= htmlspecialchars(trim(($j['employer_first_name'] ?? '') . ' ' . ($j['employer_last_name'] ?? ''))) ?></td>
                    <td><?= htmlspecialchars($typeLabels[$j['employment_type']] ?? $j['employment_type']) ?></td>
                    <td><?= htmlspecialchars($j['location'] !== '' ? $j['location'] : '—') ?></td>
                    <td><?= htmlspecialchars(substr((string) $j['created_at'], 0, 10)) ?></td>
                    <td><a href="/workwave/Controller/index.php?action=job_view&amp;id=<?= (int) $j['id'] ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
