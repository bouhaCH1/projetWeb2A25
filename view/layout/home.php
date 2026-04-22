<!-- ── Hero Banner (uses Plot Listing main-banner style) ── -->
<div class="main-banner" style="min-height:92vh; display:flex; align-items:center;">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="top-text header-text text-center" style="margin-bottom:30px;">
          <h6>Connecter les talents aux opportunités</h6>
          <h2 style="line-height:1.2;">Trouvez le <span style="color:#ef6f31;">job de vos rêves</span><br>ou recrutez les meilleurs talents</h2>
          <p style="font-size:1.05rem; color:rgba(255,255,255,.75); max-width:560px; margin:18px auto 0; line-height:1.7;">
            WorkWave rassemble chercheurs d'emploi et employeurs sur une seule plateforme intelligente. Créez votre profil, publiez des offres et soyez recruté — tout au même endroit.
          </p>
        </div>
      </div>
      <div class="col-lg-12 text-center" style="margin-top:10px;">
        <?php if (empty($_SESSION['user_id'])): ?>
          <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
            <div class="main-white-button">
              <a href="/workwave/Controller/index.php?action=register"><i class="fa fa-plus"></i> Commencer gratuitement</a>
            </div>
            <a href="/workwave/Controller/index.php?action=login"
               style="display:inline-block;padding:12px 28px;border:2px solid rgba(255,255,255,.4);color:#fff;border-radius:6px;font-weight:600;font-size:.9rem;transition:.2s;"
               onmouseover="this.style.borderColor='#ef6f31';this.style.color='#ef6f31';"
               onmouseout="this.style.borderColor='rgba(255,255,255,.4)';this.style.color='#fff';">
              Se connecter
            </a>
          </div>
        <?php else: ?>
          <?php if ($_SESSION['user_role'] === 'job_seeker'): ?>
            <div class="main-white-button">
              <a href="/workwave/Controller/index.php?action=dashboard_seeker"><i class="fa fa-th-large"></i> Aller au tableau de bord</a>
            </div>
          <?php elseif ($_SESSION['user_role'] === 'employer'): ?>
            <div class="main-white-button">
              <a href="/workwave/Controller/index.php?action=dashboard_employer"><i class="fa fa-th-large"></i> Aller au tableau de bord</a>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- ── Popular Categories / Features ── -->
<div class="popular-categories">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-heading text-center">
          <h2>Solutions complètes de recrutement</h2>
          <h6>Tout ce dont vous avez besoin pour connecter les talents aux opportunités</h6>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="naccs">
          <div class="grid">
            <div class="row">
              <div class="col-lg-3">
                <div class="menu">
                  <div class="first-thumb active">
                    <div class="thumb">
                      <span class="icon"><i class="fa fa-search" style="font-size:1.2rem;"></i></span>
                      Trouver un emploi
                    </div>
                  </div>
                  <div>
                    <div class="thumb">
                      <span class="icon"><i class="fa fa-user" style="font-size:1.2rem;"></i></span>
                      Créer un profil
                    </div>
                  </div>
                  <div>
                    <div class="thumb">
                      <span class="icon"><i class="fa fa-briefcase" style="font-size:1.2rem;"></i></span>
                      Publier une offre
                    </div>
                  </div>
                  <div class="last-thumb">
                    <div class="thumb">
                      <span class="icon"><i class="fa fa-handshake-o" style="font-size:1.2rem;"></i></span>
                      Être recruté
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-9 align-self-center">
                <ul class="nacc">
                  <li class="active">
                    <div>
                      <div class="thumb">
                        <div class="row">
                          <div class="col-lg-5 align-self-center">
                            <div class="left-text">
                              <h4>Des milliers d'emplois vous attendent</h4>
                              <p>Parcourez des centaines d'offres actives dans tous les secteurs. Filtrez par lieu, salaire et type de contrat pour trouver exactement ce que vous cherchez.</p>
                              <div class="main-white-button"><a href="/workwave/Controller/index.php?action=register"><i class="fa fa-eye"></i> Commencer la recherche</a></div>
                            </div>
                          </div>
                          <div class="col-lg-7 align-self-center">
                            <div class="right-image">
                              <img src="/workwave/View/assets/plot-listing/images/tabs-image-01.jpg" alt="Trouver un emploi">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div>
                      <div class="thumb">
                        <div class="row">
                          <div class="col-lg-5 align-self-center">
                            <div class="left-text">
                              <h4>Créez un profil professionnel qui se démarque</h4>
                              <p>Créez un profil complet mettant en valeur vos compétences, votre expérience et vos réalisations. Laissez les meilleurs employeurs vous trouver et vous contacter directement.</p>
                              <div class="main-white-button"><a href="/workwave/Controller/index.php?action=register"><i class="fa fa-eye"></i> Créer mon profil</a></div>
                            </div>
                          </div>
                          <div class="col-lg-7 align-self-center">
                            <div class="right-image">
                              <img src="/workwave/View/assets/plot-listing/images/tabs-image-02.jpg" alt="Créer un profil">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div>
                      <div class="thumb">
                        <div class="row">
                          <div class="col-lg-5 align-self-center">
                            <div class="left-text">
                              <h4>Publiez des offres et trouvez les meilleurs candidats</h4>
                              <p>Les employeurs peuvent publier des offres détaillées en quelques minutes. Accédez à un vivier de candidats qualifiés et gérez les candidatures depuis votre tableau de bord.</p>
                              <div class="main-white-button"><a href="/workwave/Controller/index.php?action=register"><i class="fa fa-eye"></i> Publier une offre</a></div>
                            </div>
                          </div>
                          <div class="col-lg-7 align-self-center">
                            <div class="right-image">
                              <img src="/workwave/View/assets/plot-listing/images/tabs-image-03.jpg" alt="Publier une offre">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div>
                      <div class="thumb">
                        <div class="row">
                          <div class="col-lg-5 align-self-center">
                            <div class="left-text">
                              <h4>Des placements rapides et sécurisés</h4>
                              <p>Notre plateforme garantit un processus de recrutement sûr et transparent. De la candidature à l'embauche, WorkWave rend le rapprochement professionnel facile et fiable.</p>
                              <div class="main-white-button"><a href="/workwave/Controller/index.php?action=register"><i class="fa fa-eye"></i> Rejoindre maintenant</a></div>
                            </div>
                          </div>
                          <div class="col-lg-7 align-self-center">
                            <div class="right-image">
                              <img src="/workwave/View/assets/plot-listing/images/tabs-image-04.jpg" alt="Être recruté">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ── CTA Section ── -->
<div class="recent-listing" style="padding: 80px 0;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center">
        <div class="section-heading">
          <h2>Commencez à bâtir votre <span style="color:#ef6f31;">Carrière</span> aujourd'hui</h2>
          <h6>Rejoignez des milliers de professionnels déjà sur WorkWave</h6>
        </div>
        <p style="color:#777; font-size:1rem; margin:16px auto 28px; max-width:520px; line-height:1.75;">
          Que vous soyez débutant ou professionnel expérimenté — ou une entreprise cherchant à recruter — WorkWave est prêt à vous aider à atteindre vos objectifs.
        </p>
        <?php if (empty($_SESSION['user_id'])): ?>
          <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
            <div class="main-white-button">
              <a href="/workwave/Controller/index.php?action=register"><i class="fa fa-plus"></i> Créer un compte</a>
            </div>
            <a href="/workwave/Controller/index.php?action=login"
               style="display:inline-block;padding:12px 28px;border:2px solid #ddd;color:#555;border-radius:6px;font-weight:600;font-size:.9rem;">
              Déjà un compte ?
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
