<?php
require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

requireLogin();

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $contact_info = mysqli_real_escape_string($conn, $_POST['contact_info']);
    $user_id = $_SESSION['user_id'];

    // Handle Image Upload
    $image = 'default_item.jpg';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Simple validation
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
        $sql = "INSERT INTO items (user_id, title, description, price, category, contact_info, image) 
                VALUES ('$user_id', '$title', '$description', '$price', '$category', '$contact_info', '$image')";
        
        if ($conn->query($sql)) {
            header("Location: my_items.php");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

$page_title = "Add New Item";
include 'includes/header.php';
?>

<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                <div class="bg-primary p-5 text-white">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-tag fa-2x me-3"></i>
                        <h2 class="fw-bold mb-0">List Your Item</h2>
                    </div>
                    <p class="text-white-50 mb-0">Fill in the details below to reach thousands of campus buyers.</p>
                </div>
                <div class="card-body p-5 bg-white">
                    <?php if ($error): ?>
                        <div class="alert alert-danger border-0 rounded-4 py-3 mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Item Title</label>
                                <input type="text" name="title" class="form-control py-3" placeholder="What are you selling? (e.g. iPad Pro 2023)" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category" class="form-select py-3 bg-light border-0" required>
                                    <option value="" selected disabled>Select Category</option>
                                    <option value="Textbooks">Textbooks</option>
                                    <option value="Calculators">Calculators</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Lab Equipment">Lab Equipment</option>
                                    <option value="Stationery">Stationery</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Price (₹)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-rupee-sign text-muted"></i></span>
                                    <input type="number" step="0.01" name="price" class="form-control py-3 border-0 bg-light" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Detailed Description</label>
                                <textarea name="description" class="form-control py-3" rows="5" placeholder="Describe the item's condition, usage, and any defects..." required></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Contact Details (Phone/Email)</label>
                                <input type="text" name="contact_info" class="form-control py-3" placeholder="How should buyers reach you? (e.g. WhatsApp: +91...)" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Item Photo</label>
                                <div class="upload-area rounded-4 p-4 text-center border-2 border-dashed bg-light">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                    <input type="file" name="image" class="form-control" accept="image/*" id="imageInput">
                                    <p class="text-muted small mt-2 mb-0">Drag and drop or click to upload (JPG, PNG, max 5MB)</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mt-5">
                            <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow">
                                <i class="fas fa-plus-circle me-2"></i> Post Listing
                            </button>
                            <a href="dashboard.php" class="btn btn-light px-5 py-3 rounded-pill fw-bold">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.upload-area {
    border-style: dashed !important;
    border-color: #dee2e6 !important;
    transition: var(--transition);
}
.upload-area:hover {
    background-color: #f1f5f9 !important;
    border-color: var(--primary-color) !important;
}
</style>

<?php include 'includes/footer.php'; ?>

