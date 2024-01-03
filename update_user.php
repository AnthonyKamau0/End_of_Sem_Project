<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Super_User') {
    // Redirect to the login page if not logged in as a Super_User
    header('Location: index.php');
    exit();
}

require_once('db/constant.php');
require_once('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
    // Retrieve user ID from the query parameters
    $user_id = $_GET['user_id'];

    $conn = new Database();
    $connection = $conn->getConnection();

    // Fetch user details for editing
    $sql = "SELECT * FROM userstb WHERE userId = '$user_id'";
    $result = $connection->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        // Redirect to manage users if user not found
        header('Location: manage_users.php');
        exit();
    }
} else {
    // Redirect to manage users if user ID is not provided
    header('Location: manage_users.php');
    exit();
}

// Handle form submission for updating user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = $_POST['user_type'];
    $address = $_POST['address'];

    // Update user details in the database
    $sql = "UPDATE userstb SET full_name = '$full_name', email = '$email', phone_number = '$phone_number',
            password = '$password', user_type = '$user_type', address = '$address' WHERE userId = '$user_id'";

    if ($connection->query($sql) === TRUE) {
        // Redirect to manage users after successful update
        header('Location: manage_users.php');
        exit();
    } else {
        echo "Error updating user: " . $connection->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-4">
        <h2>Update User</h2>

        <!-- Display user details for editing -->
        <form action="process_edit_user.php?user_id=<?= $user_id; ?>" method="post">


            <div class="form-group">
                <label for="user_type">User Type:</label>
                <input type="text" id="user_type" name="user_type" class="form-control" value="<?= $user['user_type']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="<?= $user['full_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= $user['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" id="phone_number" name="phone_number" class="form-control" value="<?= $user['phone_number']; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" class="form-control" value="<?= $user['address']; ?>" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>

        </form>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
