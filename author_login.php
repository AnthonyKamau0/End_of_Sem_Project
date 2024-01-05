<?php

session_start();
require_once('db/constant.php');
require_once('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connection to the database
    $conn = new Database();
    $connection = $conn->getConnection();

    // Validate the user
    $sql = "SELECT * FROM authortb WHERE user_name = '$username'";
    $result = $connection->query($sql);

    if ($result->num_rows == 1) {
        // User found, verify the password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct
            if ($row['user_type'] == 'Author') {
                session_start();
                $_SESSION['user_id'] = $row['authorId'];
                $_SESSION['user_type'] = 'Author';
                header('Location: author_dashboard.php');
                exit();
            } elseif ($row['user_type'] == 'Author') {
 
                session_start();
                $_SESSION['user_id'] = $row['authorId'];
                $_SESSION['user_type'] = 'Author';
                header('Location: author_dashboard.php');
                exit();
            } else {
                // Redirect for other user types if needed
                // header('Location: other_dashboard.php');
                // exit();
            }
        } else {
            // Password is incorrect
            header('Location: author_login.php?error=1');
            exit();
        }
    } else {
        // User not found
        header('Location: author_login.php?error=1');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-card {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #007bff;
        }
        .login-card .title {
            font-size: 32px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 12px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 12px;
            transition: background-color 0.15s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .navbar-nav .nav-link {
            font-size: 18px;
            color: #007bff;
            margin-right: 15px;
        }

        .navbar-nav .nav-link:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Makala Inc</a>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                // Display "Logout" if the user is logged in as Super_User
                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'Super_User') {
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                }

                // Display "Super User Login" if the user is not logged in
                if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Super_User') {
                    echo '<li class="nav-item"><a class="nav-link" href="index.php">Super User Login</a></li>';
                }

                // Display "Author Login" if the user is not logged in
                if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Author') {
                    echo '<li class="nav-item"><a class="nav-link" href="admin_login.php">Admin Login</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>

    <div class="login-container"> 
        <div class="login-card">
            <h2 class="mb-4">Author Login</h2>

            <?php
            // Display error message if login fails
            if (isset($_GET['error']) && $_GET['error'] == '1') {
                echo '<p class="text-danger text-center">Invalid username or password.</p>';
            }
            ?>

            <form action="author_login.php" method="post">

                <div class="form-group">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
        </div>
    </div>

    <div style="background-color: #333; color: #fff; padding: 10px; text-align: center;">
        &copy; Anthony Kamau 2024
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
