<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    // Redirect to the login page if not logged in as an Admin
    header('Location: admin_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0; 
        }

        .container {
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            display: block;
            padding: 10px 15px;
            margin: 0 auto; 
            border: 2px solid #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
            background-color: #007bff;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Welcome, Admin</h2>

        <ul>
            <li><a href="admin_update_profile.php">Update Profile</a></li>
            <li><a href="admin_manage_authors.php">Manage Authors</a></li>
            <li><a href="admin_view_articles.php">View Articles</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

    </div>

    <footer>
        &copy; Anthony Kamau 2024
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
