<?php
require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

requireLogin();

$user_id = $_SESSION['user_id'];

// Fetch stats
$total_items_sql = "SELECT COUNT(*) as total FROM items WHERE user_id = '$user_id'";
$total_items = $conn->query($total_items_sql)->fetch_assoc()['total'];

$total_messages_sql = "SELECT COUNT(*) as total FROM messages WHERE receiver_id = '$user_id'";
$total_messages = $conn->query($total_messages_sql)->fetch_assoc()['total'];

$latest_listings_sql = "SELECT * FROM items WHERE user_id = '$user_id' ORDER BY created_at DESC LIMIT 5";
$latest_listings = $conn->query($latest_listings_sql);

$page_title = "Student Dashboard";
include 'includes/header.php';
?>

<div class="container my-5 py-4">
    <!-- Welcome Header -->
    <div class="row mb-5 align-items-center">
        <div class="col-lg-8 text-center text-lg-start mb-4 mb-lg-0">
            <h1 class="hero-title mb-2">Hey, <?php echo explode(' ', $_SESSION['user_name'])[0]; ?>! 👋</h1>
            <p class="lead text-muted">Welcome back to your campus command center.</p>
        </div>
        <div class="col-lg-4 text-center text-lg-end">
            <a href="add_item.php" class="btn btn-primary btn-lg shadow-lg">
                <i class="fas fa-plus-circle me-2"></i> List New Item
            </a>
        </div>
    </div>

    <!-- Vibrant Stats Grid -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stats-card border-0 shadow-lg h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-box"></i>
                    </div>
                    <h5 class="text-muted fw-bold mb-1">My Listings</h5>
                    <div class="stats-number text-primary"><?php echo $total_items; ?></div>
                    <div class="mt-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Active Items</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card border-0 shadow-lg h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="stats-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h5 class="text-muted fw-bold mb-1">Messages</h5>
                    <div class="stats-number text-success"><?php echo $total_messages; ?></div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">New Inquiries</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card border-0 shadow-lg h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-star"></i>
                    </div>
                    <h5 class="text-muted fw-bold mb-1">Account Status</h5>
                    <div class="stats-number text-warning" style="font-size: 2.5rem;">Verified</div>
                    <div class="mt-3">
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Premium Member</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
                    <h4 class="fw-900 mb-0 text-dark">Recent Listings</h4>
                    <a href="my_items.php" class="btn btn-light btn-sm rounded-pill px-4">Manage All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table premium-table mb-0 px-4">
                            <thead>
                                <tr class="bg-light">
                                    <th class="ps-4 border-0 py-3 text-muted small fw-bold">ITEM</th>
                                    <th class="border-0 py-3 text-muted small fw-bold">CATEGORY</th>
                                    <th class="border-0 py-3 text-muted small fw-bold">PRICE</th>
                                    <th class="border-0 py-3 text-muted small fw-bold">STATUS</th>
                                    <th class="pe-4 border-0 py-3 text-muted small fw-bold text-end">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($latest_listings->num_rows > 0): ?>
                                    <?php while ($item = $latest_listings->fetch_assoc()): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="uploads/<?php echo $item['image']; ?>" class="rounded-3 shadow-sm me-3" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.src='https://placehold.co/100x100?text=Item'">
                                                    <div>
                                                        <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($item['title']); ?></h6>
                                                        <span class="text-muted small"><?php echo date('M d, Y', strtotime($item['created_at'])); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-primary bg-opacity-10 text-primary px-3"><?php echo htmlspecialchars($item['category']); ?></span></td>
                                            <td><h6 class="fw-bold mb-0 text-primary">₹<?php echo number_format($item['price'], 2); ?></h6></td>
                                            <td><span class="badge bg-success bg-opacity-10 text-success px-3">Live</span></td>
                                            <td class="pe-4 text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-light btn-sm rounded-circle p-2" type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                                        <li><a class="dropdown-item py-2" href="edit_item.php?id=<?php echo $item['id']; ?>"><i class="fas fa-edit me-2 text-primary"></i> Edit</a></li>
                                                        <li><a class="dropdown-item py-2" href="item.php?id=<?php echo $item['id']; ?>"><i class="fas fa-eye me-2 text-success"></i> View</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item py-2 text-danger" href="delete_item.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Delete this listing?')"><i class="fas fa-trash-alt me-2"></i> Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <div class="mb-3"><i class="fas fa-folder-open fa-3x opacity-25"></i></div>
                                            <p class="mb-0">No listings found. Start selling today!</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

