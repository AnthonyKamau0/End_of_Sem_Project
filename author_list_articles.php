<?php
require_once('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['updatedArticleId'])) {
        $updatedArticleId = $_POST['updatedArticleId'];
        $updatedArticleTitle = $_POST['updatedArticleTitle'];
        $updatedArticleText = $_POST['updatedArticleText'];

        $conn = new Database();
        $connection = $conn->getConnection();

        if ($connection->ping()) {
            // Update the article in the database
            $sql = "UPDATE articles SET article_title = '$updatedArticleTitle', article_full_text = '$updatedArticleText' WHERE articleId = $updatedArticleId";
            if ($connection->query($sql) === TRUE) {
                $successMessage = 'Article updated successfully!';
            } else {
                $errorMessage = 'Error updating article: ' . $connection->error;
            }
        } else {
            $errorMessage = 'Database connection is not valid.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Articles</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        h2 {
            color: #007bff;
        }

        .article {
            margin-bottom: 20px;
        }

        .article-form {
            display: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>List Articles</h2>

        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?= $successMessage; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $errorMessage; ?>
            </div>
        <?php endif; ?>

        <?php
        // Fetch all articles from the database
        $sql = "SELECT * FROM articles ORDER BY article_created_date DESC";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            // Output articles
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="article">
                    <h3><?= $row['article_title']; ?></h3>
                    <p><?= $row['article_full_text']; ?></p>
                    <p>Created on: <?= $row['article_created_date']; ?></p>
                    <!-- Display update form for each article -->
                    <button class="btn btn-primary" onclick="showUpdateForm('<?= $row['articleId']; ?>', '<?= $row['article_title']; ?>', '<?= $row['article_full_text']; ?>')">Update Article</button>
                    <!-- Display delete form for each article -->
                    <form action="author_list_articles.php" method="post" class="d-inline">
                        <input type="hidden" name="articleId" value="<?= $row['articleId']; ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this article?')">Delete Article</button>
                    </form>
                    <hr>
                    <!-- Update form for each article -->
                    <div class="article-form" id="updateForm<?= $row['articleId']; ?>">
                        <form action="author_list_articles.php" method="post">
                            <input type="hidden" name="updatedArticleId" value="<?= $row['articleId']; ?>">
                            <div class="form-group">
                                <label for="updatedArticleTitle">Updated Title:</label>
                                <input type="text" id="updatedArticleTitle" name="updatedArticleTitle" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="updatedArticleText">Updated Text:</label>
                                <textarea id="updatedArticleText" name="updatedArticleText" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Update Article</button>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p>No articles found.</p>';
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Function to show the update form for a specific article
        function showUpdateForm(articleId, title, text) {
            var forms = document.getElementsByClassName('article-form');
            for (var i = 0; i < forms.length; i++) {
                forms[i].style.display = 'none';
            }
            // Show the update form for the selected article
            var updateForm = document.getElementById('updateForm' + articleId);
            updateForm.style.display = 'block';

            document.getElementById('updatedArticleTitle').value = title;
            document.getElementById('updatedArticleText').value = text;
        }
    </script>

    <div style="background-color: #333; color: #fff; padding: 10px; text-align: center;">
        &copy; Anthony Kamau 2024
    </div>
</body>
</html>
