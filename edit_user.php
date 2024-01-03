<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Super_User') {
    // Redirect to the login page if not logged in as a Super_User
    header('Location: index.php');
    exit();
}

if (!isset($_GET['user_id'])) {
    // Redirect to the manage_users.php page if user ID is not provided
    header('Location: manage_users.php');
    exit();
}

$user_id = $_GET['user_id'];
require_once('db/connection.php');

$conn = new Database();
$connection = $conn->getConnection();

$sql = "SELECT * FROM userstb WHERE userId = '$user_id'";
$result = $connection->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $full_name = $row['full_name'];
    $email = $row['email'];
    $phone_number = $row['phone_number'];
    $username = $row['user_name'];
    $user_type = $row['user_type'];
    $address = $row['address'];
} else {
    // Redirect to the manage_users.php page if user not found
    header('Location: manage_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit User</h2>
        <form action="process_edit_user.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" name="full_name" class="form-control" value="<?php echo $full_name; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" name="phone_number" class="form-control" value="<?php echo $phone_number; ?>" required>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="user_type">User Type:</label>
                <input type="text" name="user_type" class="form-control" value="<?php echo $user_type; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="profile_image">Profile Image:</label>
                <input type="file" name="profile_image" class="form-control-file" accept="image/*" required>
            </div>

            <div class="form-group">
        <button type="submit" class="btn btn-primary">Update User</button>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
