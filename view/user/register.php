<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="content_box">
    <h1>Create an Account</h1>

    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger"><ul>
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </ul></div>
    <?php endif; ?>



    <form id="registerForm" action="/workwave/Controller/index.php?action=register_submit" method="POST" novalidate>

        <label>First Name *</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($_SESSION['old']['first_name'] ?? '') ?>">

        <label>Last Name *</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($_SESSION['old']['last_name'] ?? '') ?>">

        <label>Email Address *</label>
        <input type="text" id="email" name="email" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">

        <label>Phone Number</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>">

        <label>I am a *</label>
        <select id="role" name="role">
            <option value="">-- Select --</option>
            <option value="job_seeker" <?= (($_SESSION['old']['role'] ?? '') === 'job_seeker') ? 'selected' : '' ?>>Job Seeker</option>
            <option value="employer"   <?= (($_SESSION['old']['role'] ?? '') === 'employer')   ? 'selected' : '' ?>>Employer / Company</option>
        </select>

        <label>Password * <small style="color:#aaa;">(Min. 8 chars, one uppercase, one number)</small></label>
        <input type="password" id="password" name="password">

        <label>Confirm Password *</label>
        <input type="password" id="confirm_password" name="confirm_password">

        <br/>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="/workwave/Controller/index.php?action=login" class="btn btn-secondary">Already have an account?</a>

    </form>
    <?php unset($_SESSION['old']); ?>
</div>



<?php include __DIR__ . '/../layout/footer.php'; ?>
