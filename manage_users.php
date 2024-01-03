<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Super_User') {
    // Redirect to the login page if not logged in as a Super_User
    header('Location: index.php');
    exit();
}

require_once('db/constant.php');
require_once('db/connection.php');

// Fetch all users from the database
$conn = new Database();
$connection = $conn->getConnection();
$sql = "SELECT * FROM userstb";
$result = $connection->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-4">
        <h2>Manage Users</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Username</th>
                    <th>User Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['userId']; ?></td>
                        <td><?= $user['full_name']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= $user['phone_number']; ?></td>
                        <td><?= $user['user_name']; ?></td>
                        <td><?= $user['user_type']; ?></td>
                        <td>
                            <!-- Action buttons for update and delete -->
                            <a href="edit_user.php?user_id=<?= $user['userId']; ?>" class="btn btn-primary btn-sm">Update</a>
                            <a href="process_delete_user.php?user_id=<?= $user['userId']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mb-3">
            <a href="add_user.php" class="btn btn-success">Add New User</a>
            <a href="export_users.php" class="btn btn-info">Export Users</a>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
