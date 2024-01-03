<?php
require_once('db/constant.php');
require_once('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = 'Author';
    $access_time = date('Y-m-d H:i:s');
    $address = $_POST['address'];

    // Connection to the database
    $conn = new Database();
    $connection = $conn->getConnection();

    $sql = "INSERT INTO authortb (full_name, email, phone_number, user_name, password, user_type, access_time, profile_image, address)
            VALUES ('$full_name', '$email', '$phone_number', '$username', '$password', '$user_type', '$access_time', '$target_file', '$address')";

    if ($connection->query($sql) === TRUE) {
        // Redirect to admin_manage_authors.php after successful addition
        header('Location: admin_manage_authors.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}
?>
