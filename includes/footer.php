</main>
<footer class="footer mt-auto py-5 bg-white border-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-primary mb-3"><?php echo APP_NAME; ?></h5>
                <p class="text-muted small">The trusted campus marketplace for students to buy and sell academic essentials with ease.</p>
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li><a href="<?php echo BASE_URL; ?>index.php" class="text-decoration-none text-muted">Home</a></li>
                    <li><a href="<?php echo BASE_URL; ?>browse.php" class="text-decoration-none text-muted">Browse Items</a></li>
                    <li><a href="<?php echo BASE_URL; ?>register.php" class="text-decoration-none text-muted">Register</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Categories</h6>
                <ul class="list-unstyled small">
                    <li><a href="<?php echo BASE_URL; ?>browse.php?category=Textbooks" class="text-decoration-none text-muted">Textbooks</a></li>
                    <li><a href="<?php echo BASE_URL; ?>browse.php?category=Electronics" class="text-decoration-none text-muted">Electronics</a></li>
                    <li><a href="<?php echo BASE_URL; ?>browse.php?category=Stationery" class="text-decoration-none text-muted">Stationery</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Contact Us</h6>
                <p class="text-muted small mb-1"><i class="fas fa-envelope me-2"></i> support@campxchange.com</p>
                <div class="mt-3">
                    <a href="#" class="text-muted me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-muted me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-muted"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 text-muted">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-muted small mb-0">&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="text-muted small mb-0">Designed for Students, by Students.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?php echo BASE_URL; ?>js/script.js"></script>
</body>
</html>
