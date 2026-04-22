<?php include __DIR__ . '/../layout/pl_header.php'; ?>

<div class="ww-form-section">
  <div class="ww-form-card">
    <h1>Welcome Back</h1>
    <p class="ww-subtitle">Sign in to your WorkWave account</p>

    <?php if (!empty($_SESSION['errors'])): ?>
      <div class="ww-alert ww-alert-danger"><ul>
        <?php foreach ($_SESSION['errors'] as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; unset($_SESSION['errors']); ?>
      </ul></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
      <div class="ww-alert ww-alert-success">
        <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <form id="loginForm" action="/workwave/Controller/index.php?action=login_submit" method="POST" novalidate>
      <label>Email Address</label>
      <input type="text" id="email" name="email">

      <label>Password</label>
      <input type="password" id="password" name="password">

      <button type="submit" class="ww-btn-primary">Sign In</button>
      <a href="/workwave/Controller/index.php?action=register" class="ww-btn-secondary">No account? Register</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
