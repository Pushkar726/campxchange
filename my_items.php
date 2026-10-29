<?php
require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

requireLogin();

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM items WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = $conn->query($sql);

$page_title = "My Listings";
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h1 class="fw-bold">My Listings</h1>
            <p class="text-muted">Manage all the items you've posted for sale.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="add_item.php" class="btn btn-primary px-4 py-2"><i class="fas fa-plus me-2"></i> Post New Item</a>
        </div>
    </div>

    <div class="row g-4">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($item = $result->fetch_assoc()): ?>
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-2">
                                <img src="uploads/<?php echo $item['image']; ?>" class="img-fluid rounded-start w-100 h-100" style="object-fit: cover; min-height: 150px;" alt="<?php echo htmlspecialchars($item['title']); ?>" onerror="this.src='https://placehold.co/300x200?text=Item'">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge bg-primary-subtle text-primary px-2 py-1"><?php echo htmlspecialchars($item['category']); ?></span>
                                        <span class="text-muted small">• Posted on <?php echo date('M d, Y', strtotime($item['created_at'])); ?></span>
                                    </div>
                                    <h5 class="card-title fw-bold mb-2"><?php echo htmlspecialchars($item['title']); ?></h5>
                                    <p class="card-text text-muted text-truncate" style="max-width: 500px;"><?php echo htmlspecialchars($item['description']); ?></p>
                                    <h4 class="text-primary fw-bold mb-0">₹<?php echo number_format($item['price'], 2); ?></h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-body p-4 text-md-end">
                                    <div class="d-flex flex-wrap justify-content-md-end gap-2">
                                        <a href="item.php?id=<?php echo $item['id']; ?>" class="btn btn-light btn-sm px-3"><i class="fas fa-eye me-1"></i> View</a>
                                        <a href="edit_item.php?id=<?php echo $item['id']; ?>" class="btn btn-outline-primary btn-sm px-3"><i class="fas fa-edit me-1"></i> Edit</a>
                                        <a href="delete_item.php?id=<?php echo $item['id']; ?>" class="btn btn-outline-danger btn-sm px-3" onclick="return confirm('Are you sure you want to delete this listing?')"><i class="fas fa-trash-alt me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <img src="https://illustrations.popsy.co/gray/creative-work.svg" alt="Empty" style="max-width: 250px;" class="mb-4">
                <h3 class="fw-bold">No listings yet</h3>
                <p class="text-muted">You haven't posted any items for sale yet.</p>
                <a href="add_item.php" class="btn btn-primary mt-3 px-5">Start Selling</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

