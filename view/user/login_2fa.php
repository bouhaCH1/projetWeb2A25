<?php
// Guard: must have a pending 2FA session
if (empty($_SESSION['pending_2fa_user_id'])) {
    header('Location: index.php?action=login');
    exit;
}

$emailHint = htmlspecialchars($_SESSION['pending_2fa_email_hint'] ?? 'votre email');
$sentOk    = $_SESSION['pending_2fa_sent_ok'] ?? false;

include __DIR__ . '/../layout/pl_header.php';
?>

<div class="ww-form-section">
  <div class="ww-form-card" style="max-width:460px;margin:auto;">

    <!-- Icon + Title -->
    <div style="text-align:center;margin-bottom:28px;">
      <div style="font-size:3rem;margin-bottom:10px;">🔐</div>
      <h1 style="margin:0;font-size:1.45rem;font-weight:800;">Vérification en deux étapes</h1>
    </div>

    <!-- Info message -->
    <div style="margin-bottom:22px;padding:14px 18px;border-radius:10px;
      background:<?= $sentOk ? 'rgba(0,255,204,0.06)' : 'rgba(255,179,0,0.07)' ?>;
      border:1px solid <?= $sentOk ? 'rgba(0,255,204,0.25)' : 'rgba(255,179,0,0.3)' ?>;
      font-size:0.85rem;line-height:1.65;color:#bbb;">
      <?php if ($sentOk): ?>
        ✅ Un code à 6 chiffres a été envoyé à <strong style="color:#00ffcc;"><?= $emailHint ?></strong>.<br>
        <span style="color:#666;font-size:0.78rem;">Vérifiez votre boîte de réception (et les spams). Code valide 5 minutes.</span>
      <?php else: ?>
        ⚠️ Le code a été généré mais l'envoi email a échoué (SMTP non configuré).<br>
        <span style="color:#666;font-size:0.78rem;">Contactez l'administrateur ou configurez le SMTP dans <code>Model/SmtpMailer.php</code>.</span>
      <?php endif; ?>
    </div>

    <!-- Error messages -->
    <?php if (!empty($_SESSION['errors'])): ?>
      <div class="ww-alert ww-alert-danger" style="margin-bottom:18px;">
        <?= htmlspecialchars($_SESSION['errors'][0]); unset($_SESSION['errors']); ?>
      </div>
    <?php endif; ?>

    <!-- Code input form -->
    <form action="/WorkWave/Controller/index.php?action=login_2fa_submit" method="POST" autocomplete="off">
      <label style="display:block;font-size:0.72rem;font-weight:700;color:#888;
                    text-transform:uppercase;letter-spacing:0.6px;margin-bottom:10px;">
        Code de vérification (6 chiffres)
      </label>

      <input type="text"
             name="code"
             id="otpInput"
             placeholder="_ _ _ _ _ _"
             maxlength="6"
             inputmode="numeric"
             autocomplete="one-time-code"
             style="width:100%;font-size:2.2rem;letter-spacing:18px;text-align:center;
                    font-weight:900;padding:18px 12px;
                    background:rgba(0,255,204,0.03);
                    border:2px solid rgba(0,255,204,0.18);
                    border-radius:10px;color:#fff;font-family:monospace;
                    box-sizing:border-box;outline:none;transition:border-color .2s;"
             onfocus="this.style.borderColor='#00ffcc'"
             onblur="this.style.borderColor='rgba(0,255,204,0.18)'"
             oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,6)">

      <button type="submit"
              id="verifyBtn"
              style="margin-top:18px;width:100%;padding:14px;border:none;border-radius:10px;
                     background:linear-gradient(135deg,#00ffcc,#00b3ff);
                     color:#000;font-weight:800;font-size:1rem;cursor:pointer;
                     transition:transform .15s,box-shadow .15s;"
              onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(0,255,204,0.3)'"
              onmouseout="this.style.transform='none';this.style.boxShadow='none'">
        ✅ Vérifier et se connecter
      </button>
    </form>

    <!-- Cancel link -->
    <div style="text-align:center;margin-top:18px;">
      <a href="/WorkWave/Controller/index.php?action=login"
         style="font-size:.83rem;color:#555;text-decoration:none;transition:color .15s;"
         onmouseover="this.style.color='#00ffcc'"
         onmouseout="this.style.color='#555'">
        ← Annuler et revenir à la connexion
      </a>
    </div>

  </div>
</div>

<script>
  // Auto-focus the input
  document.getElementById('otpInput')?.focus();
  // Auto-submit when 6 digits entered
  document.getElementById('otpInput')?.addEventListener('input', function() {
    if (this.value.length === 6) {
      document.getElementById('verifyBtn').click();
    }
  });
</script>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
