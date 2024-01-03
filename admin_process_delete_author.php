<?php
require_once('db/constant.php');
require_once('db/connection.php');

if (isset($_GET['author_id'])) {
    $author_id = $_GET['author_id'];

    // Connection to the database
    $conn = new Database();
    $connection = $conn->getConnection();

    // Delete the user from the database
    $sql = "DELETE FROM authortb WHERE authorId = '$author_id'";
    
    if ($connection->query($sql) === TRUE) {
        // Redirect back to the manage_users.php page after successful deletion
        header('Location: admin_manage_authors.php');
        exit();
    } else {
        echo "Error deleting user: " . $connection->error;
    }
} else {
    // Redirect to manage_users.php if user ID is not provided
    header('Location: admin_manage_authors.php');
    exit();
}
?>
