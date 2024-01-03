<?php
require_once('db/constant.php');
require_once('db/connection.php');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $conn = new Database();
    $connection = $conn->getConnection();

    // Delete the user from the database
    $sql = "DELETE FROM userstb WHERE userId = '$user_id'";
    
    if ($connection->query($sql) === TRUE) {
        // Redirect back to the manage_users.php page after successful deletion
        header('Location: manage_users.php');
        exit();
    } else {
        echo "Error deleting user: " . $connection->error;
    }
} else {
    // Redirect to manage_users.php if user ID is not provided
    header('Location: manage_users.php');
    exit();
}
?>
