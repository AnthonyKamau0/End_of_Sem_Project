<?php
session_start();

// Check if the Admin is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    // Redirect to the login page if not logged in as a Admin
    header('Location: admin_login.php');
    exit();
}

require_once('db/constant.php');
require_once('db/connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $author_id = $_POST['author_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];

    // Connection to the database
    $conn = new Database();
    $connection = $conn->getConnection();

    // Update user details in the database
    $sql = "UPDATE authortb
            SET full_name = '$full_name', email = '$email', phone_number = '$phone_number', password = '$password', address = '$address'
            WHERE authorId = $author_id";

    if ($connection->query($sql) === TRUE) {
        header('Location: admin_manage_authors.php');
        exit();
    } else {
        echo "Error updating Author: " . $connection->error;
    }
} else {
    // Redirect if the form is not submitted
    header('Location: admin_manage_authors.php');
    exit();
}
?>
