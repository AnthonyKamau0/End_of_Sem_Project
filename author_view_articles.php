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
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 20px;
        }

        h2 {
            color: #007bff;
        }

        p {
            color: #343a40;
        }

        hr {
            border-top: 1px solid #dee2e6;
        }

        .article {
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .export-link {
            margin-top: 10px;
            display: block;
            padding: 5px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
        }

        .export-link.export-text {
            background-color: #007bff; /* Blue color for text file */
            color: #fff;
        }

        .export-link.export-pdf {
            background-color: #28a745; /* Green color for PDF file */
            color: #fff;
        }

        .footer {
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
        <h2>View Articles</h2>

        <?php
        $db = new Database();
        $connection = $db->getConnection();

        if ($connection->ping()) {
            $sql = "SELECT * FROM articles ORDER BY article_created_date DESC LIMIT 6";
            $result = $connection->query($sql);

            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="article">';
                    echo '<h3>' . $row['article_title'] . '</h3>';
                    echo '<p>' . $row['article_full_text'] . '</p>';
                    echo '<p>Created on: ' . $row['article_created_date'] . '</p>';
                    echo '<a class="export-link export-text" href="author_export_article.php?articleId=' . $row['articleId'] . '&format=text">Export to Text File</a>';
                    echo '<a class="export-link export-pdf" href="author_export_article.php?articleId=' . $row['articleId'] . '&format=pdf">Export to PDF</a>';
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

    <div class="footer">
        &copy; Anthony Kamau 2024
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>




