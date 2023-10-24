<?php
// Include the TCPDF library
//require_once('tcpdf/tcpdf.php');

require_once('./tcpdf/tcpdf.php');


// Define content for the PDF report
$content = '
<h1>Client Report</h1>
<table border="1">
    <tr>
        <th>Client Name</th>
        <th>Amount Payable</th>
        <th>Payment Status</th>
        <th>Total Amount Paid</th>
        <th>Remaining Value</th>
    </tr>';

// Fetch data from the database or any source
include 'database.php';
$sql = "SELECT * FROM clients";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $content .= '
    <tr>
        <td>' . $row['client_name'] . '</td>
        <td>' . $row['amount_payable'] . '</td>
        <td>' . $row['payment_status'] . '</td>
        <td>' . $row['total_amount_paid'] . '</td>
        <td>' . $row['remainingValue'] . '</td>
    </tr>';
}
$content .= '</table>';

// Create a new PDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Generate Report');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Client Report');
$pdf->SetSubject('Client Data');
$pdf->SetKeywords('Client, Report, PDF');

// Add a page
$pdf->AddPage();

// Set content using HTML
$pdf->writeHTML($content, true, false, true, false, '');

// Output the PDF
$pdf->Output('client_report.pdf', 'I'); // 'I' to display in browser, 'D' to force download 
?>
