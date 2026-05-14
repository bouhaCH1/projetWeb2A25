<section class="ww-panel-page">
    <div class="ww-form-shell">
        <h1><?= $mode === 'login' ? 'Welcome Back' : ($mode === 'company' ? 'Create Company Account' : 'Create Freelancer Account') ?></h1>
        <form method="post" class="ww-form">
            <?= csrf() ?>
            <label>Email or username <input required name="email"></label>
            <label>Password <input required type="password" name="password" minlength="8"></label>
            <?php if ($mode === 'freelancer'): ?>
                <div class="ww-two"><label>First name <input required name="first_name"></label><label>Last name <input required name="last_name"></label></div>
                <div class="ww-two"><label>City <input name="city" value="Tunis"></label><label>Governorate <input name="governorate" value="Tunis"></label></div>
                <label>Professional bio <textarea name="bio"></textarea></label>
            <?php elseif ($mode === 'company'): ?>
                <label>Company name <input required name="company_name"></label>
                <div class="ww-two"><label>Industry <input name="industry"></label><label>City <input name="city" value="Tunis"></label></div>
                <label>Description <textarea name="description"></textarea></label>
            <?php else: ?>
                <label class="ww-check"><input type="checkbox" name="remember" value="1"> Remember me</label>
            <?php endif; ?>
            <button class="cta-button" type="submit"><?= $mode === 'login' ? 'Login' : 'Create Account' ?></button>
        </form>
        <div class="ww-auth-links">
            <a href="<?= routeUrl('register-freelancer') ?>">Freelancer register</a>
            <a href="<?= routeUrl('register-company') ?>">Company register</a>
            <a href="<?= routeUrl('login') ?>">Login</a>
        </div>
    </div>
</section>
