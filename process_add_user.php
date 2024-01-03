<?php
require_once('db/constant.php');
require_once('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = 'Administrator';
    $access_time = date('Y-m-d H:i:s');
    $address = $_POST['address'];

    // Create a connection to the database
    $conn = new Database();
    $connection = $conn->getConnection();

    $sql = "INSERT INTO userstb (full_name, email, phone_number, user_name, password, user_type, access_time, profile_image, address)
            VALUES ('$full_name', '$email', '$phone_number', '$username', '$password', '$user_type', '$access_time', '$target_file', '$address')";

    if ($connection->query($sql) === TRUE) {
        // Redirect to manage_users.php after successful addition
        header('Location: manage_users.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}
?>
