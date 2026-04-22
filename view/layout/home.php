<!-- ── Hero Banner (uses Plot Listing main-banner style) ── -->
<div class="main-banner" style="min-height:92vh; display:flex; align-items:center;">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="top-text header-text text-center" style="margin-bottom:30px;">
          <h6>Connecting Talent With Opportunity</h6>
          <h2 style="line-height:1.2;">Find Your <span style="color:#ef6f31;">Dream Job</span><br>or Hire Top Talent</h2>
          <p style="font-size:1.05rem; color:rgba(255,255,255,.75); max-width:560px; margin:18px auto 0; line-height:1.7;">
            WorkWave brings together job seekers and employers on one smart platform. Build your professional profile, post openings, and get hired — all in one place.
          </p>
        </div>
      </div>
      <div class="col-lg-12 text-center" style="margin-top:10px;">
        <?php if (empty($_SESSION['user_id'])): ?>
          <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
            <div class="main-white-button">
              <a href="/workwave/Controller/index.php?action=register"><i class="fa fa-plus"></i> Get Started Free</a>
            </div>
            <a href="/workwave/Controller/index.php?action=login"
               style="display:inline-block;padding:12px 28px;border:2px solid rgba(255,255,255,.4);color:#fff;border-radius:6px;font-weight:600;font-size:.9rem;transition:.2s;"
               onmouseover="this.style.borderColor='#ef6f31';this.style.color='#ef6f31';"
               onmouseout="this.style.borderColor='rgba(255,255,255,.4)';this.style.color='#fff';">
              Sign In
            </a>
          </div>
        <?php else: ?>
          <?php if ($_SESSION['user_role'] === 'job_seeker'): ?>
            <div class="main-white-button">
              <a href="/workwave/Controller/index.php?action=dashboard_seeker"><i class="fa fa-th-large"></i> Go to Dashboard</a>
            </div>
          <?php elseif ($_SESSION['user_role'] === 'employer'): ?>
            <div class="main-white-button">
              <a href="/workwave/Controller/index.php?action=dashboard_employer"><i class="fa fa-th-large"></i> Go to Dashboard</a>
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
          <h2>Complete Recruitment Solutions</h2>
          <h6>Everything you need to connect talent with opportunity</h6>
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
                      Find Jobs
                    </div>
                  </div>
                  <div>
                    <div class="thumb">
                      <span class="icon"><i class="fa fa-user" style="font-size:1.2rem;"></i></span>
                      Build Profile
                    </div>
                  </div>
                  <div>
                    <div class="thumb">
                      <span class="icon"><i class="fa fa-briefcase" style="font-size:1.2rem;"></i></span>
                      Post Jobs
                    </div>
                  </div>
                  <div class="last-thumb">
                    <div class="thumb">
                      <span class="icon"><i class="fa fa-handshake-o" style="font-size:1.2rem;"></i></span>
                      Get Hired
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
                              <h4>Thousands of Jobs Waiting for You</h4>
                              <p>Browse hundreds of active job listings across all industries. Filter by location, salary, and employment type to find exactly what you're looking for.</p>
                              <div class="main-white-button"><a href="/workwave/Controller/index.php?action=register"><i class="fa fa-eye"></i> Start Searching</a></div>
                            </div>
                          </div>
                          <div class="col-lg-7 align-self-center">
                            <div class="right-image">
                              <img src="/workwave/View/assets/plot-listing/images/tabs-image-01.jpg" alt="Find Jobs">
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
                              <h4>Build a Professional Profile That Stands Out</h4>
                              <p>Create a comprehensive profile showcasing your skills, experience, and achievements. Let top employers find and reach out to you directly.</p>
                              <div class="main-white-button"><a href="/workwave/Controller/index.php?action=register"><i class="fa fa-eye"></i> Create Profile</a></div>
                            </div>
                          </div>
                          <div class="col-lg-7 align-self-center">
                            <div class="right-image">
                              <img src="/workwave/View/assets/plot-listing/images/tabs-image-02.jpg" alt="Build Profile">
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
                              <h4>Post Jobs and Find the Best Candidates</h4>
                              <p>Employers can post detailed job listings in minutes. Reach a pool of qualified candidates and manage applications all from your dashboard.</p>
                              <div class="main-white-button"><a href="/workwave/Controller/index.php?action=register"><i class="fa fa-eye"></i> Post a Job</a></div>
                            </div>
                          </div>
                          <div class="col-lg-7 align-self-center">
                            <div class="right-image">
                              <img src="/workwave/View/assets/plot-listing/images/tabs-image-03.jpg" alt="Post Jobs">
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
                              <h4>Secure and Fast Job Placements</h4>
                              <p>Our platform ensures a safe and transparent hiring process. From application to offer, WorkWave makes professional matching easy and reliable.</p>
                              <div class="main-white-button"><a href="/workwave/Controller/index.php?action=register"><i class="fa fa-eye"></i> Join Now</a></div>
                            </div>
                          </div>
                          <div class="col-lg-7 align-self-center">
                            <div class="right-image">
                              <img src="/workwave/View/assets/plot-listing/images/tabs-image-04.jpg" alt="Get Hired">
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
          <h2>Start Building Your <span style="color:#ef6f31;">Career</span> Today</h2>
          <h6>Join thousands of professionals already on WorkWave</h6>
        </div>
        <p style="color:#777; font-size:1rem; margin:16px auto 28px; max-width:520px; line-height:1.75;">
          Whether you're a first-time applicant or an experienced professional — or a company looking to hire — WorkWave is ready to help you achieve your goals.
        </p>
        <?php if (empty($_SESSION['user_id'])): ?>
          <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
            <div class="main-white-button">
              <a href="/workwave/Controller/index.php?action=register"><i class="fa fa-plus"></i> Create an Account</a>
            </div>
            <a href="/workwave/Controller/index.php?action=login"
               style="display:inline-block;padding:12px 28px;border:2px solid #ddd;color:#555;border-radius:6px;font-weight:600;font-size:.9rem;">
              Already have an account?
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
