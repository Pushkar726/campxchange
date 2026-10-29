<?php
require_once 'config.php';
require_once 'includes/db.php';

$page_title = "Home";
include 'includes/header.php';

// Fetch latest items
$latest_sql = "SELECT i.*, u.name as seller_name FROM items i JOIN users u ON i.user_id = u.id ORDER BY i.created_at DESC LIMIT 8";
$latest_result = $conn->query($latest_sql);
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start">
                <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill fw-bold">Campus Exclusive Marketplace</span>
                <h1 class="hero-title">Buy and Sell <br><span class="text-primary">Campus Essentials</span></h1>
                <p class="hero-subtitle">The most trusted student-to-student marketplace for textbooks, electronics, and study materials within our campus community.</p>
                <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                    <a href="browse.php" class="btn btn-primary btn-lg px-5">Explore Market</a>
                    <a href="add_item.php" class="btn btn-outline-primary btn-lg px-5">Start Selling</a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="position-relative">
                    <img src="https://illustrations.popsy.co/gray/studying.svg" alt="Student Life" class="img-fluid floating-animation">
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
    100% { transform: translateY(0px); }
}
.floating-animation {
    animation: float 6s ease-in-out infinite;
}
</style>

<!-- Features Section -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 text-center">
                    <div class="stats-icon mb-3 mx-auto"><i class="fas fa-hand-holding-dollar fa-2x"></i></div>
                    <h4 class="fw-bold mb-3">Save Money</h4>
                    <p class="text-muted mb-0">Get quality academic essentials at a fraction of the original price from fellow students.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 text-center">
                    <div class="stats-icon mb-3 mx-auto"><i class="fas fa-bolt fa-2x"></i></div>
                    <h4 class="fw-bold mb-3">Sell Easily</h4>
                    <p class="text-muted mb-0">Turn your used textbooks and gadgets into cash quickly within your campus circle.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 text-center">
                    <div class="stats-icon mb-3 mx-auto"><i class="fas fa-shield-check fa-2x"></i></div>
                    <h4 class="fw-bold mb-3">Trusted Community</h4>
                    <p class="text-muted mb-0">Verified student accounts ensure safe and secure transactions for everyone.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Items Section -->
<section class="py-5">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold mb-0">Latest Listings</h2>
            <a href="browse.php" class="text-primary fw-bold text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-4">
            <?php if ($latest_result->num_rows > 0): ?>
                <?php while ($item = $latest_result->fetch_assoc()): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100 border-0">
                            <div class="position-relative overflow-hidden" style="height: 220px;">
                                <img src="uploads/<?php echo $item['image']; ?>" class="card-img-top h-100 w-100" style="object-fit: cover;" alt="<?php echo htmlspecialchars($item['title']); ?>" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-white shadow-sm text-primary"><?php echo htmlspecialchars($item['category']); ?></span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold text-truncate mb-1"><?php echo htmlspecialchars($item['title']); ?></h5>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary-subtle rounded-circle p-1 me-2" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user text-primary" style="font-size: 0.7rem;"></i>
                                    </div>
                                    <span class="text-muted small"><?php echo htmlspecialchars($item['seller_name']); ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <h4 class="fw-bold text-primary mb-0">₹<?php echo number_format($item['price'], 2); ?></h4>
                                    <a href="item.php?id=<?php echo $item['id']; ?>" class="btn btn-primary btn-sm rounded-pill px-3">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No items found. Be the first to list something!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

