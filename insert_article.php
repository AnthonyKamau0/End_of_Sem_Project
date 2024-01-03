<?php
require_once('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_title = $_POST['article_title'];
    $article_full_text = $_POST['article_full_text'];

    $conn = new Database();
    $connection = $conn->getConnection();

    // Insert the article into the database
    $sql = "INSERT INTO articles (article_title, article_full_text, article_created_date, article_last_update, article_display, article_order)
            VALUES ('$article_title', '$article_full_text', NOW(), NOW(), 1, 1)";

    if ($connection->query($sql) === TRUE) {
        echo "Article inserted successfully!";

        // Notify administrators by email
        notifyAdministrators($article_title, $article_full_text);
    } else {
        echo "Error inserting article: " . $connection->error;
    }

}

// Fetch articles from the database
$sql = "SELECT * FROM articles ORDER BY article_created_date DESC LIMIT 10";
$result = $connection->query($sql);

// Function to notify administrators by email
function notifyAdministrators($title, $fullText) {
    $mail_subject = "New Article Posted: {$title}";
    $mail_body = "Full Article: {$fullText}";
    $mail_to = "antonygaza6@gmail.com";
    // Send email to each administrator
    sendEmail("$mail_to","$mail_subject","$mail_body");
}
function sendEmail($mail_to,$mail_subject,$mail_body){
    $cURL_key ='';
    $mail_from ='';

    $curl =curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL =>"https://api.sendgrid.com/v3/mail/send",
        CURLOPT_RETURNTRANSFER =>true,
        CURLOPT_ENCODING =>"",
        CURLOPT_MAXREDIRS =>10,
        CURLOPT_TIMEOUT =>30,
        CURLOPT_HTTP_VERSION =>CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST =>"POST",
        CURLOPT_POSTFIELDS => "{\"personalizations\":[{\"to\": [{\"email\": \"$mail_to\"}]}],\"from\": {\"email\": \"$mail_from\"},\"subject\": \"$mail_subject\",\"content\": [{\"type\": \"text/plain\", \"value\": \"$mail_body\"}]}",           
        CURLOPT_HTTPHEADER =>array(
            "authorization: Bearer $cURL_key",
            "cache-control: no-cache",
            "content-type: application/json"
        ),

    ));


    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if($err){
    echo "cURL Error #:" .$err;
    }else{
        echo $response;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Article</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-4">
        <!-- Display articles fetched from the database -->
        <?php while ($row = $result->fetch_assoc()): ?>
            <article>
                <h2><?= $row['article_title']; ?></h2>
                <p><?= $row['article_full_text']; ?></p>
            </article>
        <?php endwhile; ?>

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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
