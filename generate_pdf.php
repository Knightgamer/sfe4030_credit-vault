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
<!DOCTYPE html>
<html>
<head>
    <title>Generate Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Your CSS styles go here */
        @media (max-width: 480px) {
            body {
                font-size: 12px;
            }
        }

        @media (min-width: 481px) and (max-width: 767px) {
            body {
                font-size: 14px;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            body {
                font-size: 16px;
            }
        }

        @media (min-width: 1025px) {
            body {
                font-size: 18px;
            }
        }
        body {
            background-color: #0056b3;
        }
        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
            text-align: center;
            padding: 30px;
            background-color: #cacaca;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
            max-width: 400px;
            margin: 0 auto;
            margin-top: 50px;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            width: 100%;
            
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        }

        .form-container label {
            width: 100%;
            font-weight: bold;
        }

        .form-container select,
        .form-container button {
            width: 100%;
            margin-top: 10px;
        }

        .generate-button {
            background-color: #185495;
            color: white;
            border: none;
            border-radius: 20px; 
            padding: 8px 16px; 
            cursor: pointer;
            transition: background-color 0.3s ease;
            padding: 5px 5px;
            width: 150px;
        }

        .generate-button:hover {
            background-color: #0b5bfc; /* Darker blue on hover */
        }

        /* Top navigation bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 10px 20px;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
        }

        .navbar-logo img {
            max-width: 100px;
            margin-right: 10px;
        }

        /* Style for navigation buttons */
        .nav-button {
            display: inline-block;
            padding: 5px 5px;
            width: 150px; /* Set a fixed width for all buttons */
            background-color: #185495;
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            border-radius: 20px;
            transition: background-color 0.3s ease;
            cursor: pointer;
            border: none; 
            outline: none; 
            text-align: center;
        }

        .nav-button:hover {
            background-color: #0b5bfc;
        }
        /* Copyright bar styles */
        .copyright-bar {
            position: fixed;
            bottom: 8px;
            left: 8px;
         
            width: 100%;
            background-color: #171515;
            color: white;
            text-align: center;
            padding: 10px 20px;
    
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#" class="navbar-logo">
            <img src="images/Volks Elevator Logo.png" alt="Logo">
           
        </a>
        <div class="navigation">
            <a href="index.php" class="nav-button">Homepage</a>
            <a href="add_client.html" class="nav-button">Add Client</a>
            <a href="view_clients.php" class="nav-button">View Clients</a>
        </div>
    </div>
    <div class="main-container">
        <h1>Generate Report</h1>
        <div class="form-container">
            <form action="generate_pdf.php" method="post">
                <label for="reportFormat">Report Format:</label>
                <select name="reportFormat" id="reportFormat">
                    <option value="pdf">PDF</option>
                </select>
                <br><br>
                <label for="reportContent">Report Content:</label>
                <select name="reportContent" id="reportContent">
                    <option value="clients">Clients</option>
                </select>
                
                <button class="generate-button" type="submit">Generate Report</button>
            </form>
        </div>
        
    </div>
    <div class="copyright-bar">
        &copy; 2023 Volks Elevator. All rights reserved.
    </div>
</body>
</html>