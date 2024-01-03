<?php
require_once('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $articleId = $_POST['articleId'];
    $updatedTitle = $_POST['updated_title'];
    $updatedFullText = $_POST['updated_full_text'];

    $conn = new Database();
    $connection = $conn->getConnection();

    // Update the article in the database
    $sql = "UPDATE articles 
            SET article_title = '$updatedTitle', article_full_text = '$updatedFullText', article_last_update = NOW()
            WHERE articleId = $articleId";

    if ($connection->query($sql) === TRUE) {
        echo "Article updated successfully!";
    } else {
        echo "Error updating article: " . $connection->error;
    }
}

if (isset($_GET['articleId'])) {
    $articleId = $_GET['articleId'];

    // Fetch article details from the database
    $sql = "SELECT * FROM articles WHERE articleId = $articleId";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Article not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Article</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Update Article</h1>

        <form action="author_update_article.php" method="post">
            <input type="hidden" name="articleId" value="<?= $articleId; ?>">

            <div class="form-group">
                <label for="updated_title">Updated Article Title:</label>
                <input type="text" id="updated_title" name="updated_title" class="form-control" value="<?= $row['article_title']; ?>" required>
            </div>

            <div class="form-group">
                <label for="updated_full_text">Updated Article Full Text:</label>
                <input type="text" id="updated_full_text" name="updated_full_text" class="form-control" value="<?= $row['article_full_text']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Article</button>
        </form>
        
        <a href="author_list_articles.php" class="btn btn-secondary mt-3">Back to List of Articles</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
