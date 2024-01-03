<?php
require_once('db/connection.php');

if (isset($_GET['articleId'])) {
    $articleId = $_GET['articleId'];
    $db = new Database();


    $connection = $db->getConnection();

    if ($connection->ping()) {
        $sql = "SELECT * FROM articles WHERE articleId = $articleId";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $article = $result->fetch_assoc();

            // Check the export format (text or pdf)
            $format = isset($_GET['format']) ? $_GET['format'] : 'text';

            if ($format === 'text') {
                // Set the content type to plain text
                header('Content-Type: text/plain');

                header('Content-Disposition: attachment; filename="article_export.txt"');

                // Open a file handle for writing
                $fp = fopen('php://output', 'w');

                // Write the content to the file handle
                fwrite($fp, "Article ID: {$article['articleId']}\n");
                fwrite($fp, "Title: {$article['article_title']}\n");
                fwrite($fp, "Full Text: {$article['article_full_text']}\n");
                fwrite($fp, "Created on: {$article['article_created_date']}\n");


                fclose($fp);

                exit();
            } elseif ($format === 'pdf') {
                // Use TCPDF to generate PDF
                require_once('TCPDF-main/TCPDF-main/tcpdf.php');

                class PDF extends TCPDF {
                    public function Header() {
                    }

                    public function Footer() {
                    }
                }

                $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // Set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('Your Name');
                $pdf->SetTitle('Article Export');
                $pdf->SetSubject('Article Data PDF Export');
                $pdf->SetKeywords('TCPDF, PDF, article, export');
                $pdf->SetFont('helvetica', '', 12);

                $pdf->AddPage();

                $pdf->Cell(0, 10, "Article ID: {$article['articleId']}", 0, 1);
                $pdf->Cell(0, 10, "Title: {$article['article_title']}", 0, 1);
                $pdf->Cell(0, 10, "Full Text: {$article['article_full_text']}", 0, 1);
                $pdf->Cell(0, 10, "Created on: {$article['article_created_date']}", 0, 1);

                // Output PDF to the browser
                $pdf->Output('article_export.pdf', 'D');
            } else {
                echo 'Invalid export format.';
            }
        } else {
            echo 'Article not found.';
        }
    } else {
        echo 'Database connection is not valid.';
    }
} else {
    echo 'Article ID not provided.';
}
?>
