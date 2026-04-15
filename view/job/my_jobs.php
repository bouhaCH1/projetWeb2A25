<?php
/** @var array<int, array<string, mixed>> $jobs */
$pageTitle = 'My Job Listings';
include __DIR__ . '/../layout/dashboard_header.php';

$typeLabels = [
    'full_time'  => 'Full-time',
    'part_time'  => 'Part-time',
    'contract'   => 'Contract',
    'internship' => 'Internship',
];
?>

<div class="page-header">
    <div>
        <div class="page-header-title">My Job Listings</div>
        <div class="page-header-sub">Manage the postings tied to your employer account</div>
    </div>
    <a href="/workwave/Controller/index.php?action=job_post" class="btn btn-primary">+ Post a Job</a>
</div>

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

<?php if (empty($jobs)): ?>
    <div class="dsh-card" style="text-align:center;padding:40px;">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="1.2" style="margin-bottom:12px;"><rect x="3" y="8" width="18" height="12" rx="1"/><path d="M7 8V6a5 5 0 0110 0v2"/></svg>
        <div style="color:#555;font-size:.9rem;">You haven't posted any jobs yet.</div>
        <br>
        <a href="/workwave/Controller/index.php?action=job_post" class="btn btn-primary">Post your first job</a>
    </div>
<?php else: ?>
    <div class="dsh-table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Posted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($jobs as $j): ?>
                <tr>
                    <td style="font-weight:500;color:#e0e0e0;"><?= htmlspecialchars($j['title']) ?></td>
                    <td><span class="badge badge-employer"><?= htmlspecialchars($typeLabels[$j['employment_type']] ?? $j['employment_type']) ?></span></td>
                    <td><?= htmlspecialchars($j['location'] !== '' ? $j['location'] : '—') ?></td>
                    <td style="color:#555;"><?= htmlspecialchars(substr((string)$j['created_at'], 0, 10)) ?></td>
                    <td>
                        <a href="/workwave/Controller/index.php?action=job_view&id=<?= (int)$j['id'] ?>"
                           class="btn btn-secondary btn-sm">View</a>
                        <a href="/workwave/Controller/index.php?action=job_delete&id=<?= (int)$j['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Remove this job listing?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
