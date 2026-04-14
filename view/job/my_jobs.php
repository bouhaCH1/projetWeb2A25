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
    <h1>My job postings</h1>
    <p>Manage the listings tied to your employer account.</p>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger"><ul>
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </ul></div>
    <?php endif; ?>

    <p>
        <a href="/workwave/Controller/index.php?action=job_post" class="btn btn-primary">Post a new job</a>
        <a href="/workwave/Controller/index.php?action=jobs" class="btn btn-outline">View public job board</a>
    </p>

    <?php if (empty($jobs)): ?>
        <p>You have not posted any jobs yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
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
                    <td><?= htmlspecialchars($typeLabels[$j['employment_type']] ?? $j['employment_type']) ?></td>
                    <td><?= htmlspecialchars($j['location'] !== '' ? $j['location'] : '—') ?></td>
                    <td><?= htmlspecialchars(substr((string) $j['created_at'], 0, 10)) ?></td>
                    <td>
                        <a href="/workwave/Controller/index.php?action=job_view&amp;id=<?= (int) $j['id'] ?>">View</a>
                        &nbsp;|&nbsp;
                        <a href="/workwave/Controller/index.php?action=job_delete&amp;id=<?= (int) $j['id'] ?>" onclick="return confirm('Remove this job listing?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
