<?php
/* ============================================================
   index.php — Home page
   ============================================================ */

require_once 'includes/config.php';

// No $pageTitle set here — falls back to SITE_NAME alone in header.php
require_once 'includes/header.php';
?>

    <!-- Hero -->
    <section id="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <p class="hero-label">Available for freelance &amp; remote work</p>
                    <h1 class="hero-title">Clean code.<br>Simple solutions.<br><span>Things that just work.</span></h1>
                    <p class="hero-sub">Full-stack PHP &amp; Laravel developer building backends, brochure sites, admin tools, e-commerce, and everything in between. No fluff, no unnecessary dependencies.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="contact.php" class="btn btn-accent">Get In Touch</a>
                        <a href="services.php" class="btn btn-outline-accent">View Services</a>
                    </div>
                </div>
                <div class="col-md-4 mt-5 mt-md-0">
                    <div class="d-flex flex-column gap-4">
                        <div class="hero-stat"><div class="num">50+</div><div class="label">Projects Built</div></div>
                        <div class="hero-stat"><div class="num">6+</div><div class="label">Years Experience</div></div>
                        <div class="hero-stat"><div class="num">100%</div><div class="label">Remote Ready</div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Snapshot -->
    <section id="snapshot">
        <div class="container">
            <p class="section-label">Overview</p>
            <h2 class="section-title">What KodaKodra Offers</h2>
            <p class="section-sub">A quick look at who I am and what I do. Follow the links to find out more.</p>
            <div class="row g-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="snapshot-card">
                        <div class="snapshot-icon"><i class="fas fa-user"></i></div>
                        <h5>About</h5>
                        <p>Self-taught developer with 6+ years building real projects and 20+ years of people experience behind the code.</p>
                        <a href="about.php">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="snapshot-card">
                        <div class="snapshot-icon"><i class="fas fa-code"></i></div>
                        <h5>Services</h5>
                        <p>Web development, PHP &amp; Laravel backends, database design, bug fixing, and project takeovers.</p>
                        <a href="services.php">View Services <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="snapshot-card">
                        <div class="snapshot-icon"><i class="fas fa-layer-group"></i></div>
                        <h5>Tech Stack</h5>
                        <p>PHP, Laravel, MySQL, Bootstrap, JavaScript, and more. Clean, practical choices that get the job done.</p>
                        <a href="about.php#stack">View Stack <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="snapshot-card">
                        <div class="snapshot-icon"><i class="fas fa-envelope"></i></div>
                        <h5>Contact</h5>
                        <p>Open to remote freelance projects, bug fixes, takeovers, and team collaboration. Let's talk.</p>
                        <a href="contact.php">Get In Touch <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
