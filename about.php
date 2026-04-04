<?php
/* ============================================================
   about.php — About page
   ============================================================ */

require_once 'includes/config.php';

$pageTitle = 'About';
require_once 'includes/header.php';
?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <p class="page-label">About</p>
            <h1 class="page-title">Who I Am</h1>
            <p class="page-sub">Self-taught developer, practical thinker, and someone who builds things that actually work.</p>
        </div>
    </div>

    <!-- About -->
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <p class="section-label">Background</p>
                    <h2 class="section-title">The Developer</h2>
                    <p class="about-text">Self-taught developer building with <strong>PHP, Laravel, MySQL</strong>, and standard front-end technologies since 2019. 50+ projects built across social platforms, e-commerce, admin tools, brochure sites, and more.</p>
                    <p class="about-text">I got into development the practical way — by building things, breaking things, and figuring out why. No bootcamp, no shortcuts. Just real projects and the determination to get them working.</p>
                    <p class="about-text">The focus has always been on writing <strong>clean, readable, maintainable code</strong> — not clever code. Code that someone else can pick up, understand, and continue without a manual.</p>
                </div>
                <div class="col-md-5 mt-4 mt-md-0">
                    <p class="section-label">Background</p>
                    <h2 class="section-title">The Person</h2>
                    <p class="about-text">Before development, 20+ years across <strong>customer-facing, remote team coordination, client management, and project delivery</strong> roles. That background shapes how I work with clients — clearly, directly, and without unnecessary jargon.</p>
                    <p class="about-text">I understand deadlines, communication, and what it means to be accountable to someone who's counting on you to deliver.</p>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <p class="section-label">Approach</p>
                    <h2 class="section-title">How I Work</h2>
                    <div class="d-flex flex-wrap">
                        <span class="about-pill">Clean, readable code</span>
                        <span class="about-pill">PSR-12 compliant</span>
                        <span class="about-pill">Remote ready</span>
                        <span class="about-pill">Client focused</span>
                        <span class="about-pill">No bloat</span>
                        <span class="about-pill">Fast turnaround</span>
                        <span class="about-pill">Well documented</span>
                        <span class="about-pill">Bug fixing</span>
                        <span class="about-pill">No unnecessary dependencies</span>
                        <span class="about-pill">No over-engineering</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stack -->
    <section id="stack">
        <div class="container">
            <p class="section-label">Tech Stack</p>
            <h2 class="section-title">What I Work With</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <p class="stack-group-title">Backend</p>
                    <div>
                        <span class="stack-item"><i class="fab fa-php"></i> PHP</span>
                        <span class="stack-item"><i class="fas fa-layer-group"></i> Laravel</span>
                        <span class="stack-item"><i class="fas fa-database"></i> MySQL</span>
                        <span class="stack-item"><i class="fas fa-envelope"></i> PHPMailer</span>
                        <span class="stack-item"><i class="fab fa-stripe-s"></i> Stripe</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <p class="stack-group-title">Frontend</p>
                    <div>
                        <span class="stack-item"><i class="fab fa-html5"></i> HTML5</span>
                        <span class="stack-item"><i class="fab fa-css3-alt"></i> CSS3</span>
                        <span class="stack-item"><i class="fab fa-js"></i> JavaScript</span>
                        <span class="stack-item"><i class="fab fa-bootstrap"></i> Bootstrap</span>
                        <span class="stack-item"><i class="fab fa-font-awesome"></i> Font Awesome</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <p class="stack-group-title">Tools</p>
                    <div>
                        <span class="stack-item"><i class="fab fa-git-alt"></i> Git</span>
                        <span class="stack-item"><i class="fab fa-github"></i> GitHub</span>
                        <span class="stack-item"><i class="fas fa-wind"></i> Blade</span>
                        <span class="stack-item"><i class="fas fa-plug"></i> REST APIs</span>
                        <span class="stack-item"><i class="fas fa-check-circle"></i> PSR-12</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
