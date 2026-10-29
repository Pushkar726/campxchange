<?php
require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

if (!isset($_GET['id'])) {
    header("Location: browse.php");
    exit();
}

$item_id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT i.*, u.name as seller_name, u.email as seller_email, u.phone as seller_phone 
        FROM items i 
        JOIN users u ON i.user_id = u.id 
        WHERE i.id = '$item_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: browse.php");
    exit();
}

$item = $result->fetch_assoc();
$page_title = $item['title'];
include 'includes/header.php';
?>

<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb bg-white p-3 rounded-pill shadow-sm px-4">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="browse.php" class="text-decoration-none text-muted">Marketplace</a></li>
            <li class="breadcrumb-item active fw-bold text-primary" aria-current="page"><?php echo htmlspecialchars($item['category']); ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-lg-7">
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                <div class="position-relative">
                    <img src="uploads/<?php echo $item['image']; ?>" class="img-fluid w-100" style="max-height: 600px; object-fit: cover;" alt="<?php echo htmlspecialchars($item['title']); ?>" onerror="this.src='https://placehold.co/800x600?text=No+Image'">
                    <div class="position-absolute top-0 end-0 m-4">
                        <span class="badge bg-white text-primary shadow-sm px-4 py-2 rounded-pill fs-6">₹<?php echo number_format($item['price'], 2); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="ps-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill"><?php echo htmlspecialchars($item['category']); ?></span>
                    <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> Posted <?php echo date('M d, Y', strtotime($item['created_at'])); ?></span>
                </div>
                
                <h1 class="fw-bold display-6 mb-3"><?php echo htmlspecialchars($item['title']); ?></h1>
                
                <div class="card border-0 bg-white shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-3">About this item</h5>
                    <p class="text-muted lh-lg mb-3"><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
                    
                    <hr class="opacity-10 mb-3">
                    
                    <h6 class="fw-bold mb-2">Seller Contact Information:</h6>
                    <div class="p-3 bg-light rounded-3 border-start border-primary border-4">
                        <p class="mb-0 fw-semibold text-primary"><i class="fas fa-phone-alt me-2"></i><?php echo htmlspecialchars($item['contact_info']); ?></p>
                    </div>
                </div>
                
                <div class="card border-0 bg-primary text-white shadow-lg rounded-4 p-4 mb-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 56px; height: 56px; font-size: 1.2rem;">
                                <?php echo strtoupper(substr($item['seller_name'], 0, 1)); ?>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0 fw-bold"><?php echo htmlspecialchars($item['seller_name']); ?></h5>
                            <p class="text-white-50 small mb-0">Campus Seller</p>
                        </div>
                    </div>
                    
                    <?php if (isLoggedIn()): ?>
                        <?php if ($_SESSION['user_id'] != $item['user_id']): ?>
                            <a href="contact_seller.php?item_id=<?php echo $item['id']; ?>" class="btn btn-white w-100 py-3 fw-bold rounded-pill">
                                <i class="fas fa-paper-plane me-2 text-primary"></i> Send Message
                            </a>
                        <?php else: ?>
                            <a href="edit_item.php?id=<?php echo $item['id']; ?>" class="btn btn-white w-100 py-3 fw-bold rounded-pill text-primary">
                                <i class="fas fa-edit me-2"></i> Manage My Listing
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-white w-100 py-3 fw-bold rounded-pill text-primary">
                            Login to Contact Seller
                        </a>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-3 text-muted small px-2">
                    <span><i class="fas fa-shield-alt me-1 text-success"></i> Secure Campus Deal</span>
                    <span><i class="fas fa-check-circle me-1 text-success"></i> Verified Student</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-white {
    background-color: white;
    color: var(--primary-color);
    border: none;
}
.btn-white:hover {
    background-color: #f8fafc;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>

<?php include 'includes/footer.php'; ?>

