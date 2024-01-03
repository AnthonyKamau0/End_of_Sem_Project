<?php
require_once('TCPDF-main\TCPDF-main/tcpdf.php');
require_once('db/constant.php');
require_once('db/connection.php');

class MYPDF extends TCPDF {
    // Load user data from the database 
    public function LoadData() {
        $conn = new Database();
        $connection = $conn->getConnection();
        $sql = "SELECT * FROM userstb";
        $result = $connection->query($sql);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                $row['userId'],
                $row['full_name'],
                $row['email']
            );
        }
        return $data;
    }

    // Colored table with user data
    public function SimpleTable($header, $data) {
        foreach ($header as $col) {
            $this->Cell(40, 7, $col, 1);
        }
        $this->Ln();

        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell(40, 6, $col, 1);
            }
            $this->Ln();
        }
    }
    
    
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('List of Users');
$pdf->SetSubject('User Data PDF Example');
$pdf->SetKeywords('TCPDF, PDF, example, users');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' User Data', PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFont('helvetica', '', 12);

$pdf->AddPage();

$header = array('User ID', 'Full Name', 'Email');

$data = $pdf->LoadData();

$pdf->SimpleTable($header, $data);
$pdf->Output('user_data.pdf', 'I');

// //Fetch all users from the database
// $conn = new Database();
// $connection = $conn->getConnection();
// $sql = "SELECT * FROM userstb";
// $result = $connection->query($sql);
// $users = $result->fetch_all(MYSQLI_ASSOC);

// // Export as Text File
// $textContent = '';
// foreach ($users as $user) {
//     $textContent .= "ID: {$user['userId']}, Full Name: {$user['full_name']}, Email: {$user['email']}\n";
// }

// // Set the content type to plain text
// header('Content-Type: text/plain');

// // Set the content-disposition to force download
// header('Content-Disposition: attachment; filename="user_list.txt"');

// // Output the text content
// echo $textContent;

// // Exit to prevent any additional output
// exit();


/* To export to a CSV or Excel file format first comment out the all text code and PDF code and 
leave the CSV code open inorder for it to work */


// Export as CSV File
// $csvContent = "User ID,Full Name,Email\n";
// foreach ($users as $user) {
//     $csvContent .= "{$user['userId']},{$user['full_name']},{$user['email']}\n";
// }

// // Set the content type for CSV
// header('Content-Type: text/csv');

// // Set the content-disposition to force download
// header('Content-Disposition: attachment; filename="user_list.csv"');

// // Output the CSV content
// echo $csvContent;

// // Exit to prevent any additional output
// exit();


?>
