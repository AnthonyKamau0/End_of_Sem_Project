<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Super_User') {
    // Redirect to the login page if not logged in as a Super_User
    header('Location: index.php');
    exit();
}

require_once('db/constant.php');
require_once('db/connection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];

    $conn = new Database();
    $connection = $conn->getConnection();

    // Update user details in the database
    $sql = "UPDATE userstb
            SET full_name = '$full_name', email = '$email', phone_number = '$phone_number', password = '$password', address = '$address'
            WHERE userId = $user_id";

    if ($connection->query($sql) === TRUE) {
        header('Location: manage_users.php');
        exit();
    } else {
        echo "Error updating user: " . $connection->error;
    }
} else {
    // Redirect if the form is not submitted
    header('Location: manage_users.php');
    exit();
}
?>
