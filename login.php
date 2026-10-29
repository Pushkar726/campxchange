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
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with this email.";
    }
}

$page_title = "Login";
include 'includes/header.php';
?>

<div class="auth-wrapper">
    <div class="auth-card shadow-lg border-0">
        <!-- Colorful Info Side -->
        <div class="auth-info d-none d-lg-flex">
            <h1 class="display-4 fw-900 text-white mb-4">Welcome Back!</h1>
            <p class="lead text-white-50 mb-5">Access your campus marketplace and start trading with fellow students today.</p>
            <div class="features-list">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <span>Secure Student Transactions</span>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <span>Real-time Messaging</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <span>Verified Campus Community</span>
                </div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="auth-form-side">
            <div class="mb-5">
                <h2 class="fw-900 text-dark mb-2">Sign In</h2>
                <p class="text-muted">Enter your credentials to continue</p>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success border-0 rounded-4 mb-4"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-danger border-0 rounded-4 mb-4"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-4">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 ps-3"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" name="email" class="form-control border-0 bg-light" placeholder="name@college.edu" required>
                    </div>
                </div>
                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">Password</label>
                        <a href="#" class="text-primary small fw-bold text-decoration-none">Forgot?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 ps-3"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control border-0 bg-light" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-3 mb-4">
                    Sign In <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </form>

            <div class="text-center">
                <p class="text-muted small">New to campXchange? <a href="register.php" class="text-primary fw-bold text-decoration-none">Create an account</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

