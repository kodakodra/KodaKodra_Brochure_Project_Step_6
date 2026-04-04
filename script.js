/**
 * script.js
 *
 * Client-side JavaScript for the KodaKodra portfolio site.
 * Handles contact form validation and submission via fetch().
 */

document.addEventListener('DOMContentLoaded', () => {

    /* ===========================
       Contact Form
    =========================== */

    // Cache the form and feedback elements so we aren't querying the DOM repeatedly
    const form     = document.getElementById('contact-form');
    const feedback = document.getElementById('form-feedback');
    const btn      = document.getElementById('form-submit');

    // Only run if the contact form exists on the current page
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        // Stop the browser from submitting the form the old-fashioned way
        e.preventDefault();

        // Clear any previous feedback
        feedback.textContent = '';
        feedback.className   = 'mt-3 form-feedback';

        /* ===========================
           Client-side Validation
        =========================== */

        const name    = form.name.value.trim();
        const email   = form.email.value.trim();
        const message = form.message.value.trim();

        // Basic checks before we bother hitting the server
        if (!name) {
            showFeedback('Please enter your name.', false);
            return;
        }

        // Simple email format check using a regex
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email || !emailRegex.test(email)) {
            showFeedback('Please enter a valid email address.', false);
            return;
        }

        if (!message) {
            showFeedback('Please enter a message.', false);
            return;
        }

        /* ===========================
           Submit via Fetch
        =========================== */

        // Disable the button and show a loading state while we wait
        btn.disabled     = true;
        btn.textContent  = 'Sending...';

        try {
            const res  = await fetch('contact-handler.php', {
                method : 'POST',
                body   : new FormData(form)
            });

            const data = await res.json();

            if (data.success) {
                // Success — clear the form and show the confirmation
                form.reset();
                showFeedback(data.message, true);
            } else {
                // Server returned an error — show it to the user
                showFeedback(data.message, false);
            }

        } catch (err) {
            // Network or unexpected error
            showFeedback('Something went wrong. Please try again.', false);
        } finally {
            // Re-enable the button regardless of outcome
            btn.disabled    = false;
            btn.textContent = 'Send Message';
        }
    });

    /**
     * showFeedback
     *
     * Displays a feedback message below the form.
     *
     * @param {string}  msg     - The message to display
     * @param {boolean} success - True for a success message, false for an error
     */
    const showFeedback = (msg, success) => {
        feedback.textContent = msg;
        feedback.className   = `mt-3 form-feedback ${success ? 'feedback-success' : 'feedback-error'}`;
    };

});
