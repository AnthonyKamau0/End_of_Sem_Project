<?php
require_once('TCPDF-main/TCPDF-main/tcpdf.php');
require_once('db/constant.php');
require_once('db/connection.php');

class MYPDF extends TCPDF {
    public function LoadData() {
        $conn = new Database();
        $connection = $conn->getConnection();
        $sql = "SELECT * FROM authortb";
        $result = $connection->query($sql);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                $row['authorId'],
                $row['full_name'],
                $row['email']
            );
        }
        return $data;
    }

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

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('List of Authors');
$pdf->SetSubject('Author Data PDF Example');
$pdf->SetKeywords('TCPDF, PDF, example, authors');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' Author Data', PDF_HEADER_STRING);
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
$header = array('Author ID', 'Full Name', 'Email');

$data = $pdf->LoadData();

$pdf->SimpleTable($header, $data);

$pdf->Output('author_data.pdf', 'I');
?>
