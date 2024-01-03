<?php
require_once('db/constant.php');
require_once('db/connection.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super User Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .dashboard-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .dashboard-card {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .dashboard-card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .nav-link {
            display: block;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 5px;
            color: #007bff;
        }

        .nav-link:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <div class="dashboard-card">
            <h2>Welcome, Super User!</h2>

            <nav>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="update_profile.php">Update Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_other_users.php">Manage Other Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_articles.php">View Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
