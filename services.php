<?php
/* ============================================================
   services.php — Services page
   ============================================================ */

require_once 'includes/config.php';

$pageTitle = 'Services';
require_once 'includes/header.php';
?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <p class="page-label">Services</p>
            <h1 class="page-title">What I Do</h1>
            <p class="page-sub">Practical web development services focused on clean code, real results, and no unnecessary complexity.</p>
        </div>
    </div>

    <!-- Services -->
    <section id="services">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-globe"></i></div>
                        <h5>Brochure &amp; Landing Sites</h5>
                        <p>Clean, responsive, mobile-first websites for businesses that need a professional online presence without the bloat.</p>
                        <ul class="service-list">
                            <li>Single page landing sites</li>
                            <li>Multi-page brochure sites</li>
                            <li>Bootstrap 5, custom CSS</li>
                            <li>Mobile first, fully responsive</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-server"></i></div>
                        <h5>PHP &amp; Laravel Development</h5>
                        <p>Backend development for projects that need real functionality — forms, authentication, admin tools, and more.</p>
                        <ul class="service-list">
                            <li>Laravel applications</li>
                            <li>PHP scripting and logic</li>
                            <li>REST API integration</li>
                            <li>PHPMailer contact forms</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-database"></i></div>
                        <h5>Database &amp; Authentication</h5>
                        <p>MySQL database design and implementation, user authentication, role management, and secure data handling.</p>
                        <ul class="service-list">
                            <li>MySQL schema design</li>
                            <li>User auth — register, login, roles</li>
                            <li>Admin panels</li>
                            <li>Laravel migrations</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-bug"></i></div>
                        <h5>Bug Fixing &amp; Takeovers</h5>
                        <p>Inherited a broken or abandoned project? Happy to dig in, understand existing code, fix what's broken, and take it forward cleanly.</p>
                        <ul class="service-list">
                            <li>Code review and diagnosis</li>
                            <li>Bug identification and fixes</li>
                            <li>Project continuation</li>
                            <li>Refactoring and cleanup</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Notes -->
    <section id="notes">
        <div class="container">
            <p class="section-label">Good to Know</p>
            <h2 class="section-title">How I Approach Projects</h2>
            <div class="notes-box">
                <p>
                    <strong>No hosting, domains, or server management.</strong> My focus is purely on the code — writing it, structuring it, and making it work. Hosting and infrastructure are outside scope.<br><br>
                    <strong>No unnecessary dependencies.</strong> Every tool used has a reason. If Bootstrap handles it, a plugin won't be added. If vanilla PHP works, a framework won't be forced in.<br><br>
                    <strong>Clean, documented code.</strong> Everything written is commented and structured so it can be handed over, maintained, or continued by anyone.
                </p>
            </div>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
