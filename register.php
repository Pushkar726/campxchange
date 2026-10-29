<?php
require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $check_email = "SELECT id FROM users WHERE email = '$email'";
        $result = $conn->query($check_email);
        if ($result->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$hashed_password')";
            if ($conn->query($sql)) {
                $_SESSION['success'] = "Registration successful! Please login.";
                header("Location: login.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}

$page_title = "Register";
include 'includes/header.php';
?>

<div class="auth-wrapper">
    <div class="auth-card shadow-lg border-0">
        <!-- Colorful Info Side -->
        <div class="auth-info d-none d-lg-flex">
            <h1 class="display-4 fw-900 text-white mb-4">Join the Club!</h1>
            <p class="lead text-white-50 mb-5">Create your student account and join thousands of students already trading on campus.</p>
            <div class="features-list">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                        <i class="fas fa-rocket text-white"></i>
                    </div>
                    <span>Fast & Easy Setup</span>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                        <i class="fas fa-shield-alt text-white"></i>
                    </div>
                    <span>Secure Transactions</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                        <i class="fas fa-heart text-white"></i>
                    </div>
                    <span>Built for Students</span>
                </div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="auth-form-side">
            <div class="mb-5">
                <h2 class="fw-900 text-dark mb-2">Create Account</h2>
                <p class="text-muted">Start your journey with campXchange</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger border-0 rounded-4 mb-4"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 ps-3"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" name="name" class="form-control border-0 bg-light" placeholder="John Doe" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control border-0 bg-light" placeholder="name@college.edu" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control border-0 bg-light" placeholder="1234567890" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control border-0 bg-light" placeholder="••••••••" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control border-0 bg-light" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-3 mt-4 mb-4">
                    Create Account <i class="fas fa-user-plus ms-2"></i>
                </button>
            </form>

            <div class="text-center">
                <p class="text-muted small">Already have an account? <a href="login.php" class="text-primary fw-bold text-decoration-none">Sign in here</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

