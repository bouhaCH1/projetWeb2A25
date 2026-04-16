<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="content_box">
    <h1>Log In</h1>

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



    <form id="loginForm" action="/workwave/Controller/index.php?action=login_submit" method="POST" novalidate>

        <label>Email Address</label>
        <input type="text" id="email" name="email">

        <label>Password</label>
        <input type="password" id="password" name="password">

        <br/>
        <button type="submit" class="btn btn-primary">Log In</button>
        <a href="/workwave/Controller/index.php?action=register" class="btn btn-secondary">No account? Register</a>

    </form>
</div>



<?php include __DIR__ . '/../layout/footer.php'; ?>
