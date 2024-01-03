<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    // Redirect to the login page if not logged in as a Admin
    header('Location: admin_update_profile.php');
    exit();
}
require_once('db/constant.php');
require_once('db/connection.php');

// Fetch the current user's details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM userstb WHERE userId = '$user_id'";
$result = $connection->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    header('Location: admin_login.php?error=1');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    // Check if the password field is not empty
    if (!empty($password)) {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update user details in the database with the new password
        $update_sql = "UPDATE userstb 
                       SET full_name = '$full_name', email = '$email', phone_number = '$phone_number', password = '$hashed_password', address = '$address'
                       WHERE userId = '$user_id'";
    } else {
        // Update user details in the database without changing the password
        $update_sql = "UPDATE userstb 
                       SET full_name = '$full_name', email = '$email', phone_number = '$phone_number', address = '$address'
                       WHERE userId = '$user_id'";
    }

    if ($connection->query($update_sql) === TRUE) {
        // Redirect to the dashboard after successful update
        header('Location: admin_dashboard.php');
        exit();
    } else {
        // Handle the case where the update fails
        echo "Error updating profile: " . $connection->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-4">
        <h2>Update Profile</h2>

        <form action="admin_update_profile.php" method="post">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" name="full_name" class="form-control" value="<?php echo $user['full_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" name="phone_number" class="form-control" value="<?php echo $user['phone_number']; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" class="form-control" value="<?php echo $user['address']; ?>" required>
            </div>

            <div class="form-group">
                <label for="profile_image">Profile Image:</label>
                <input type="file" name="profile_image" class="form-control-file" accept="image/*" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
