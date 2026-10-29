<?php
require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

requireLogin();

if (!isset($_GET['item_id'])) {
    header("Location: browse.php");
    exit();
}

$item_id = mysqli_real_escape_string($conn, $_GET['item_id']);
$user_id = $_SESSION['user_id'];

// Fetch item and seller details
$item_sql = "SELECT i.*, u.name as seller_name, u.id as seller_id FROM items i JOIN users u ON i.user_id = u.id WHERE i.id = '$item_id'";
$item_result = $conn->query($item_sql);

if ($item_result->num_rows == 0) {
    header("Location: browse.php");
    exit();
}

$item = $item_result->fetch_assoc();

// Prevent users from messaging themselves
if ($item['seller_id'] == $user_id) {
    header("Location: item.php?id=" . $item_id);
    exit();
}

$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $receiver_id = $item['seller_id'];

    if (!empty($message)) {
        $sql = "INSERT INTO messages (sender_id, receiver_id, item_id, message) 
                VALUES ('$user_id', '$receiver_id', '$item_id', '$message')";
        
        if ($conn->query($sql)) {
            $success = "Message sent successfully! The seller will contact you.";
        } else {
            $error = "Failed to send message. Please try again.";
        }
    } else {
        $error = "Message cannot be empty.";
    }
}

$page_title = "Contact Seller";
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="bg-primary p-4 text-white text-center">
                    <h3 class="fw-bold mb-0">Contact Seller</h3>
                </div>
                <div class="card-body p-5">
                    <?php if ($success): ?>
                        <div class="alert alert-success py-3 rounded-3 mb-4">
                            <i class="fas fa-check-circle me-2"></i> <?php echo $success; ?>
                            <div class="mt-3">
                                <a href="item.php?id=<?php echo $item_id; ?>" class="btn btn-sm btn-success px-4">Back to Item</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                            <img src="uploads/<?php echo $item['image']; ?>" class="rounded-2" style="width: 60px; height: 60px; object-fit: cover;" onerror="this.src='https://placehold.co/100x100?text=Item'">
                            <div class="ms-3">
                                <h6 class="fw-bold mb-1"><?php echo htmlspecialchars($item['title']); ?></h6>
                                <p class="text-primary fw-bold mb-0">₹<?php echo number_format($item['price'], 2); ?></p>
                                <p class="text-muted small mb-0">Seller: <?php echo htmlspecialchars($item['seller_name']); ?></p>
                            </div>
                        </div>

                        <form method="POST" action="">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Your Message</label>
                                <textarea name="message" class="form-control" rows="5" placeholder="Hi, I'm interested in this item. Is it still available?" required></textarea>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-3 fw-bold">
                                    <i class="fas fa-paper-plane me-2"></i> Send Message
                                </button>
                                <a href="item.php?id=<?php echo $item_id; ?>" class="btn btn-light py-3">Cancel</a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

