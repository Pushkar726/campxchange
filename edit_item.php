<?php
require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

requireLogin();

if (!isset($_GET['id'])) {
    header("Location: my_items.php");
    exit();
}

$item_id = mysqli_real_escape_string($conn, $_GET['id']);
$user_id = $_SESSION['user_id'];

// Fetch current item details
$sql = "SELECT * FROM items WHERE id = '$item_id' AND user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: my_items.php");
    exit();
}

$item = $result->fetch_assoc();

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $contact_info = mysqli_real_escape_string($conn, $_POST['contact_info']);

    // Handle Image Upload if provided
    $image = $item['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $file_name;
            } else {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "File is not an image.";
        }
    }

    if (empty($error)) {
        $update_sql = "UPDATE items SET title = '$title', category = '$category', price = '$price', description = '$description', contact_info = '$contact_info', image = '$image' 
                       WHERE id = '$item_id' AND user_id = '$user_id'";
        
        if ($conn->query($update_sql)) {
            $_SESSION['success'] = "Listing updated successfully!";
            header("Location: my_items.php");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

$page_title = "Edit Item";
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4">Edit Listing</h2>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Item Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($item['title']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="Textbooks" <?php echo $item['category'] == 'Textbooks' ? 'selected' : ''; ?>>Textbooks</option>
                                    <option value="Calculators" <?php echo $item['category'] == 'Calculators' ? 'selected' : ''; ?>>Calculators</option>
                                    <option value="Electronics" <?php echo $item['category'] == 'Electronics' ? 'selected' : ''; ?>>Electronics</option>
                                    <option value="Lab Equipment" <?php echo $item['category'] == 'Lab Equipment' ? 'selected' : ''; ?>>Lab Equipment</option>
                                    <option value="Stationery" <?php echo $item['category'] == 'Stationery' ? 'selected' : ''; ?>>Stationery</option>
                                    <option value="Other" <?php echo $item['category'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price (₹)</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $item['price']; ?>" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($item['description']); ?></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Contact Details (Phone/Email)</label>
                                <input type="text" name="contact_info" class="form-control" value="<?php echo htmlspecialchars($item['contact_info']); ?>" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Current Image</label>
                                <div class="mb-2">
                                    <img src="uploads/<?php echo $item['image']; ?>" class="rounded-2" style="width: 150px; height: 100px; object-fit: cover;" onerror="this.src='https://placehold.co/150x100?text=No+Image'">
                                </div>
                                <label class="form-label">Change Image (Optional)</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary px-5 py-2">Update Listing</button>
                            <a href="my_items.php" class="btn btn-light px-5 py-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

