<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="content_box">
    <h1>My Profile</h1>

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

    <div id="js-errors" class="alert alert-warning" style="display:none;">
        <ul id="js-error-list"></ul>
    </div>

    <form id="profileForm" action="/job_platform/index.php?action=profile_update"
          method="POST" enctype="multipart/form-data" novalidate>

        <label>First Name</label>
        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($data['first_name']) ?>">

        <label>Last Name</label>
        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($data['last_name']) ?>">

        <label>Email (cannot be changed)</label>
        <input type="text" value="<?= htmlspecialchars($data['email']) ?>" disabled>

        <label>Phone</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>">

        <label>Profile Picture <small style="color:#aaa;">(JPG, PNG, GIF — max 2MB)</small></label>
        <input type="file" name="profile_pic" accept="image/*">

        <br/>
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="/job_platform/index.php?action=logout" class="btn btn-danger">Log Out</a>

    </form>
</div>

<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    var errors    = [];
    var firstName = document.getElementById('first_name').value.trim();
    var lastName  = document.getElementById('last_name').value.trim();
    var phone     = document.getElementById('phone').value.trim();
    var nameRegex  = /^[a-zA-ZÀ-ÿ\s\-]{2,50}$/;
    var phoneRegex = /^\+?[0-9\s\-]{7,15}$/;

    if (!firstName)                      errors.push('First name is required.');
    else if (!nameRegex.test(firstName)) errors.push('First name is invalid.');
    if (!lastName)                       errors.push('Last name is required.');
    else if (!nameRegex.test(lastName))  errors.push('Last name is invalid.');
    if (phone && !phoneRegex.test(phone)) errors.push('Phone number is invalid.');

    if (errors.length > 0) {
        e.preventDefault();
        var list = document.getElementById('js-error-list');
        list.innerHTML = '';
        errors.forEach(function(msg) {
            var li = document.createElement('li'); li.textContent = msg; list.appendChild(li);
        });
        document.getElementById('js-errors').style.display = 'block';
        window.scrollTo(0,0);
    }
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
