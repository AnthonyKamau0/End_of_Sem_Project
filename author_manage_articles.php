<?php
require_once('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_title = $_POST['article_title'];
    $article_full_text = $_POST['article_full_text'];

    $conn = new Database();
    $connection = $conn->getConnection();

    $sql = "INSERT INTO articles (article_title, article_full_text, article_created_date, article_last_update, article_display, article_order)
            VALUES ('$article_title', '$article_full_text', NOW(), NOW(), 1, 1)";

    if ($connection->query($sql) === TRUE) {
        echo "Article inserted successfully!";
    } else {
        echo "Error inserting article: " . $connection->error;
    }
}

// Fetch articles from the database
$sql = "SELECT * FROM articles ORDER BY article_created_date DESC";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Articles</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4"> 
        <h1>Manage Articles</h1>

        <!-- Button to see the list of articles -->
        <a href="author_list_articles.php" class="btn btn-success mb-3">See List of Articles</a>

        <!-- Article insertion form with Bootstrap styling -->
        <form action="insert_article.php" method="post">
            <div class="form-group">
                <label for="article_title">Article Title:</label>
                <input type="text" id="article_title" name="article_title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="article_full_text">Article Full Text:</label>
                <input type="text" id="article_full_text" name="article_full_text" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Insert Article</button>
        </form>
    </div>

    <div style="background-color: #333; color: #fff; padding: 10px; text-align: center;">
        &copy; Anthony Kamau 2024
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
