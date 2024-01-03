<?php
require_once('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $articleId = $_POST['articleId'];

    $conn = new Database();
    $connection = $conn->getConnection();

    if ($connection->ping()) {
        echo '<script>';
        echo 'if (confirm("Are you sure you want to delete this article?")) {';
        // Delete the article if the user confirms
        $sql = "DELETE FROM articles WHERE articleId = $articleId";
        if ($connection->query($sql) === TRUE) {
            echo 'alert("Article deleted successfully!");';
        } else {
            echo 'alert("Error deleting article: ' . $connection->error . '");';
        }
        echo '}';
        echo 'window.location.href = "author_list_articles.php";'; // Redirect to the list of articles
        echo '</script>';
    } else {
        echo '<p>Database connection is not valid.</p>';
    }
}
?>
