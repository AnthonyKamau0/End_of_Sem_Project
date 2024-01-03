<?php
require_once('db/connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>View Articles</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        h3 {
            color: #007bff;
        }

        p {
            color: #343a40;
        }

        hr {
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>View Articles</h2>

        <?php
        $db = new Database();
        $connection = $db->getConnection();
        if ($connection->ping()) {
            // Fetch the last 6 articles in descending order by article_created_date
            $sql = "SELECT * FROM articles ORDER BY article_created_date DESC LIMIT 6";
            $result = $connection->query($sql);

            // Check if articles are found
            if ($result->num_rows > 0) {
                // Output articles
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="article">';
                    echo '<h3>' . $row['article_title'] . '</h3>';
                    echo '<p>' . $row['article_full_text'] . '</p>';
                    echo '<p>Created on: ' . $row['article_created_date'] . '</p>';
                    echo '<hr>';
                    echo '</div>';
                }
            } else {
                echo '<p>No articles found.</p>';
            }
        } else {
            echo '<p>Database connection is not valid.</p>';
        }
        ?>

    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
