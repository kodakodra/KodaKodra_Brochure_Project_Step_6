<?php

/**
 * contact.php
 *
 * Contact page — displays the contact form and social links.
 * Form submission is handled by contact-handler.php via fetch() in script.js.
 */

require_once 'includes/config.php';

$pageTitle = 'Contact';
require_once 'includes/header.php';

?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <p class="page-label">Contact</p>
            <h1 class="page-title">Get In Touch</h1>
            <p class="page-sub">Open to remote freelance projects, bug fixes, takeovers, and team collaboration. Fill in the form or reach out via any of the links below.</p>
        </div>
    </div>

    <!-- Contact -->
    <section id="contact">
        <div class="container">
            <div class="row g-5">

                <!-- Contact Form -->
                <div class="col-md-7">
                    <form id="contact-form" novalidate>

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label">Name <span class="text-danger ms-1">*</span></label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control"
                                placeholder="Your name"
                                maxlength="100"
                                required
                                autofocus
                            >
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address <span class="text-danger ms-1">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                placeholder="your@email.com"
                                required
                            >
                        </div>

                        <!-- Message -->
                        <div class="mb-4">
                            <label for="message" class="form-label">Message <span class="text-danger ms-1">*</span></label>
                            <textarea
                                id="message"
                                name="message"
                                class="form-control"
                                rows="6"
                                placeholder="Tell me about your project..."
                                maxlength="5000"
                                required
                            ></textarea>
                        </div>

                        <!-- Submit -->
                        <button type="submit" id="form-submit" class="btn btn-accent">Send Message</button>

                        <!-- Feedback message injected here by script.js -->
                        <div id="form-feedback" class="mt-3 form-feedback"></div>

                    </form>
                </div>

                <!-- Social Links & Availability -->
                <div class="col-md-5">

                    <div class="contact-card mb-4">
                        <div class="contact-detail">
                            <i class="fab fa-github"></i>
                            <div>
                                <span class="contact-label">GitHub</span>
                                <a href="https://github.com/kodakodra" target="_blank" rel="noopener">github.com/kodakodra</a>
                            </div>
                        </div>
                        <div class="contact-detail">
                            <i class="fab fa-twitter"></i>
                            <div>
                                <span class="contact-label">Twitter / X</span>
                                <a href="https://twitter.com/kodakodra" target="_blank" rel="noopener">@kodakodra</a>
                            </div>
                        </div>
                        <div class="contact-detail">
                            <i class="fab fa-instagram"></i>
                            <div>
                                <span class="contact-label">Instagram</span>
                                <a href="https://www.instagram.com/kodakodra" target="_blank" rel="noopener">@kodakodra</a>
                            </div>
                        </div>
                        <div class="contact-detail">
                            <i class="fab fa-youtube"></i>
                            <div>
                                <span class="contact-label">YouTube</span>
                                <a href="https://www.youtube.com/@kodakodra" target="_blank" rel="noopener">@kodakodra</a>
                            </div>
                        </div>
                        <div class="contact-detail">
                            <i class="fa-solid fa-link"></i>
                            <div>
                                <span class="contact-label">All Links</span>
                                <a href="https://linktr.ee/kodakodra" target="_blank" rel="noopener">linktr.ee/kodakodra</a>
                            </div>
                        </div>
                    </div>

                    <div class="availability-box">
                        <p>
                            <strong>Currently available</strong> for remote freelance work, contract projects, and collaboration.<br><br>
                            Whether you need a site built from scratch, an existing project rescued, or just a specific problem solved — get in touch and we'll figure out if it's a good fit.<br><br>
                            <strong>Response time:</strong> typically within 24 hours.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
