<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    // Redirect to the login page if not logged in as an Admin
    header('Location: admin_login.php');
    exit();
}
require_once('db/constant.php');
require_once('db/connection.php');

// Fetch all users from the database
$conn = new Database();
$connection = $conn->getConnection();
$sql = "SELECT * FROM authortb";
$result = $connection->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Authors</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-4"> 
        <h2>Manage Authors</h2>

        <!-- Display user list -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Author ID</th>
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
                        <td><?= $user['authorId']; ?></td>
                        <td><?= $user['full_name']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= $user['phone_number']; ?></td>
                        <td><?= $user['user_name']; ?></td>
                        <td><?= $user['user_type']; ?></td>
                        <td>
                            <!--Action buttons for update and delete -->
                            <a href="admin_edit_author.php?author_id=<?= $user['authorId']; ?>" class="btn btn-primary btn-sm">Update</a>
                            <a href="admin_process_delete_author.php?author_id=<?= $user['authorId']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="mb-3">
            <a href="admin_add_author.php" class="btn btn-success">Add New Author</a>
            <a href="admin_export_author.php" class="btn btn-info">Export Author</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
