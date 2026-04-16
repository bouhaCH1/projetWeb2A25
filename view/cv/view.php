<?php
/** @var array<string, mixed> $cv */
include __DIR__ . '/../layout/header.php';
?>

<div class="content_box" style="max-width:800px; margin:0 auto;">
    <a href="/workwave/Controller/index.php?action=cvs" style="display:inline-block; margin-bottom:20px;">&larr; Back to CVs</a>

    <div style="background:#1a1a1a; padding:30px; border-radius:8px; border:1px solid #333;">
        
        <div style="display:flex; align-items:center; gap:20px; border-bottom:1px solid #333; padding-bottom:20px; margin-bottom:20px;">
            <div style="width:80px;height:80px;border-radius:50%;background:#C4A15A;color:#000;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:bold;">
                <?php if (!empty($cv['profile_pic'])): ?>
                    <img src="/workwave/<?= htmlspecialchars($cv['profile_pic']) ?>" alt="avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                <?php else: ?>
                    <?= strtoupper(substr($cv['first_name'], 0, 1)) ?>
                <?php endif; ?>
            </div>
            <div>
                <h1 style="margin:0; color:#C4A15A; font-size:2rem;"><?= htmlspecialchars($cv['first_name'] . ' ' . $cv['last_name']) ?></h1>
                <p style="margin:5px 0 0 0; font-size:1.2rem; color:#fff;"><?= htmlspecialchars($cv['professional_title']) ?></p>
            </div>
        </div>

        <div style="display:flex; gap:30px; margin-bottom:30px;">
            <div>
                <strong>Experience:</strong><br>
                <?= (int)$cv['experience_years'] ?> years
            </div>
            <div>
                <strong>Hourly Rate:</strong><br>
                <?= htmlspecialchars($cv['hourly_rate'] ?: 'Negotiable') ?>
            </div>
            <div>
                <strong>Contact:</strong><br>
                <a href="mailto:<?= htmlspecialchars($cv['email']) ?>"><?= htmlspecialchars($cv['email']) ?></a>
            </div>
        </div>

        <div style="margin-bottom:30px;">
            <h3 style="color:#C4A15A; border-bottom:1px solid #333; padding-bottom:10px;">Skills</h3>
            <p style="line-height:1.6; color:#ccc;"><?= nl2br(htmlspecialchars($cv['skills'])) ?></p>
        </div>

        <div>
            <h3 style="color:#C4A15A; border-bottom:1px solid #333; padding-bottom:10px;">About Me</h3>
            <p style="line-height:1.6; color:#ccc;"><?= nl2br(htmlspecialchars($cv['about_me'])) ?></p>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
