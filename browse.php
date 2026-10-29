<?php
require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';

$sql = "SELECT i.*, u.name as seller_name FROM items i JOIN users u ON i.user_id = u.id WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (i.title LIKE '%$search%' OR i.description LIKE '%$search%')";
}
if (!empty($category)) {
    $sql .= " AND i.category = '$category'";
}

$sql .= " ORDER BY i.created_at DESC";
$result = $conn->query($sql);

$page_title = "Browse Items";
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-5">
            <h1 class="fw-bold display-5">Marketplace</h1>
            <p class="text-muted lead">Discover great deals from students on your campus.</p>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-white">
                <form action="browse.php" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search items..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select border-0 bg-light">
                            <option value="">All Categories</option>
                            <option value="Textbooks" <?php echo $category == 'Textbooks' ? 'selected' : ''; ?>>Textbooks</option>
                            <option value="Calculators" <?php echo $category == 'Calculators' ? 'selected' : ''; ?>>Calculators</option>
                            <option value="Electronics" <?php echo $category == 'Electronics' ? 'selected' : ''; ?>>Electronics</option>
                            <option value="Lab Equipment" <?php echo $category == 'Lab Equipment' ? 'selected' : ''; ?>>Lab Equipment</option>
                            <option value="Stationery" <?php echo $category == 'Stationery' ? 'selected' : ''; ?>>Stationery</option>
                            <option value="Other" <?php echo $category == 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill shadow-sm">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($item = $result->fetch_assoc()): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden rounded-4">
                        <div class="position-relative" style="height: 220px;">
                            <img src="uploads/<?php echo $item['image']; ?>" class="card-img-top h-100 w-100" style="object-fit: cover;" alt="<?php echo htmlspecialchars($item['title']); ?>" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-white shadow-sm text-primary"><?php echo htmlspecialchars($item['category']); ?></span>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="card-title fw-bold text-truncate mb-2"><?php echo htmlspecialchars($item['title']); ?></h5>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary-subtle rounded-circle p-1 me-2" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user text-primary" style="font-size: 0.8rem;"></i>
                                </div>
                                <span class="text-muted small"><?php echo htmlspecialchars($item['seller_name']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <h4 class="fw-bold text-primary mb-0">₹<?php echo number_format($item['price'], 2); ?></h4>
                                <a href="item.php?id=<?php echo $item['id']; ?>" class="btn btn-primary btn-sm rounded-pill px-4">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <img src="https://illustrations.popsy.co/gray/empty-cart.svg" alt="No items" style="max-width: 250px;" class="mb-4">
                <h3 class="fw-bold">No items found</h3>
                <p class="text-muted">Try adjusting your search or category filter.</p>
                <a href="browse.php" class="btn btn-primary mt-3 px-5">Clear Filters</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

