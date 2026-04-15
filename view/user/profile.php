<?php
$pageTitle = 'My Profile';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">My Profile</div>
        <div class="page-header-sub">Update your personal information and profile picture</div>
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
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<div class="alert alert-warning" id="js-errors" style="display:none;"><ul id="js-error-list"></ul></div>

<div class="dsh-card" style="max-width:560px;">
    <!-- Avatar preview -->
    <div style="display:flex;align-items:center;gap:18px;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #1c1c1c;">
        <div style="width:64px;height:64px;border-radius:50%;overflow:hidden;background:linear-gradient(135deg,#C4A15A,#7a5f30);display:flex;align-items:center;justify-content:center;font-size:1.6rem;font-weight:700;color:#000;flex-shrink:0;">
            <?php if (!empty($data['profile_pic'])): ?>
                <img src="/workwave/<?= htmlspecialchars($data['profile_pic']) ?>" alt="avatar" style="width:100%;height:100%;object-fit:cover;">
            <?php else: ?>
                <?= strtoupper(substr($data['first_name'], 0, 1)) ?>
            <?php endif; ?>
        </div>
        <div>
            <div style="font-size:1rem;font-weight:600;color:#e0e0e0;"><?= htmlspecialchars($data['first_name'] . ' ' . $data['last_name']) ?></div>
            <div style="font-size:.78rem;color:#666;margin-top:3px;"><?= htmlspecialchars($data['email']) ?></div>
            <span class="badge <?= $data['role'] === 'employer' ? 'badge-employer' : 'badge-seeker' ?>" style="margin-top:6px;">
                <?= ucfirst(str_replace('_', ' ', $data['role'])) ?>
            </span>
        </div>
    </div>

    <form id="profileForm" action="/workwave/Controller/index.php?action=profile_update"
          method="POST" enctype="multipart/form-data" novalidate>

        <label>First Name</label>
        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($data['first_name']) ?>">

        <label>Last Name</label>
        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($data['last_name']) ?>">

        <label>Email <small style="color:#555;font-weight:400;">(cannot be changed)</small></label>
        <input type="text" value="<?= htmlspecialchars($data['email']) ?>" disabled>

        <label>Phone <small style="color:#555;font-weight:400;">(optional)</small></label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>">

        <label>Profile Picture <small style="color:#555;font-weight:400;">(JPG, PNG, GIF — max 2MB)</small></label>
        <input type="file" name="profile_pic" accept="image/*">

        <br><br>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    var errors = [], fn = document.getElementById('first_name').value.trim(),
        ln = document.getElementById('last_name').value.trim(),
        ph = document.getElementById('phone').value.trim(),
        nr = /^[a-zA-ZÀ-ÿ\s\-]{2,50}$/, pr = /^\+?[0-9\s\-]{7,15}$/;
    if (!fn) errors.push('First name is required.');
    else if (!nr.test(fn)) errors.push('First name is invalid.');
    if (!ln) errors.push('Last name is required.');
    else if (!nr.test(ln)) errors.push('Last name is invalid.');
    if (ph && !pr.test(ph)) errors.push('Phone number is invalid.');
    if (errors.length > 0) {
        e.preventDefault();
        var list = document.getElementById('js-error-list');
        list.innerHTML = '';
        errors.forEach(function(m){ var li = document.createElement('li'); li.textContent = m; list.appendChild(li); });
        document.getElementById('js-errors').style.display = 'block';
        window.scrollTo(0,0);
    }
});
</script>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
