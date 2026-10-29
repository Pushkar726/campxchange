<?php
require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

requireLogin();

if (isset($_GET['id'])) {
    $item_id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Ensure the item belongs to the user
    $sql = "DELETE FROM items WHERE id = '$item_id' AND user_id = '$user_id'";
    
    if ($conn->query($sql)) {
        header("Location: my_items.php");
        exit();
    } else {
        die("Error deleting item.");
    }
} else {
    header("Location: my_items.php");
    exit();
}
?>