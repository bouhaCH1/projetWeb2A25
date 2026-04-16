<?php
/** @var array<int, array<string, mixed>> $cvs */
include __DIR__ . '/../layout/header.php';
?>

<div class="content_box">
    <h1>Candidate CVs</h1>
    <p>Browse resumes posted by job seekers on WorkWave.</p>

    <?php if (empty($cvs)): ?>
        <p>No CVs available at the moment. Job seekers can post a CV from their dashboard.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th>Professional Title</th>
                    <th>Experience</th>
                    <th>Rate</th>
                    <th>Skills</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($cvs as $c): ?>
                <tr>
                    <td>
                        <div style="font-weight:bold;"><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></div>
                    </td>
                    <td><?= htmlspecialchars($c['professional_title']) ?></td>
                    <td><?= (int)$c['experience_years'] ?> years</td>
                    <td><?= htmlspecialchars($c['hourly_rate'] !== '' ? $c['hourly_rate'] : '—') ?></td>
                    <td>
                        <span style="font-size:0.85em; color:#aaa;"><?= htmlspecialchars((strlen($c['skills']) > 50) ? substr($c['skills'], 0, 50) . '...' : $c['skills']) ?></span>
                    </td>
                    <td><a href="/workwave/Controller/index.php?action=cv_view&amp;id=<?= (int) $c['id'] ?>">View CV</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
