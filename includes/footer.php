<?php

/**
 * footer.php
 *
 * Reusable footer include — outputs the footer, Bootstrap JS, and closing tags.
 * Include this at the bottom of every page.
 */

?>

<!-- ===========================
     Footer
=========================== -->
<footer>
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <span>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</span>
        <div>
            <a href="../about.php">About</a>
            <a href="../services.php">Services</a>
            <a href="../contact.php">Contact</a>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<!-- Custom scripts -->
<script src="../script.js"></script>

</body>
</html>
