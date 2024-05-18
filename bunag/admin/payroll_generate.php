<?php
include 'includes/session.php';

function generateRow($from, $to, $conn) {
    $contents = '';

    $sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid 
            FROM attendance 
            LEFT JOIN employees ON employees.id = attendance.employee_id 
            LEFT JOIN position ON position.id = employees.position_id 
            WHERE date BETWEEN '$from' AND '$to' 
            GROUP BY attendance.employee_id 
            ORDER BY employees.lastname ASC, employees.firstname ASC";

    $query = $conn->query($sql);
    $totalNetPay = 0;
    while ($row = $query->fetch_assoc()) {
        $empid = $row['empid'];

        // Fetch Cash Advance Amount for the employee
        $casql = "SELECT SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";
        $caquery = $conn->query($casql);
        $carow = $caquery->fetch_assoc();
        $cashadvance = $carow['cashamount'] ?? 0; // Use the fetched cash advance amount or default to 0 if not found

        // Calculate Gross Pay
        $gross = $row['rate'] * $row['total_hr'];

        // Calculate SSS Contribution
        $sss_contribution = ($gross) * 0.045;

        // Calculate PhilHealth Deduction based on the employee's actual salary
        $philhealth_rate = 0.05; // Default rate for all salaries
        $salary = $gross; // Use the gross pay for PhilHealth calculation
        $philhealth_contribution = $salary * $philhealth_rate / 2; // Divide by 2 for employee share

        // Calculate Withholding Tax
        $withholding_tax = calculateWithholdingTax($gross);

        // Calculate Total Deduction
        $total_deduction = $sss_contribution + $philhealth_contribution + $withholding_tax + $cashadvance;

        // Calculate Net Pay
        $net_pay = $gross - $total_deduction;
        $totalNetPay += $net_pay;

        // Build table row
        $contents .= '
            <tr>
                <td>' . $row['lastname'] . ', ' . $row['firstname'] . '</td>
                <td align="right">' . number_format($gross, 2) . '</td>
                <td align="right">' . number_format($sss_contribution, 2) . '</td>
                <td align="right">' . number_format($philhealth_contribution, 2) . '</td>
                <td align="right">' . number_format($withholding_tax, 2) . '</td>
                <td align="right">' . number_format($cashadvance, 2) . '</td>
                <td align="right">' . number_format($net_pay, 2) . '</td>
            </tr>
        ';
    }

    // Add total row
    $contents .= '
        <tr>
            <td colspan="6" align="right"><b>Total Net Pay</b></td>
            <td align="right"><b>' . number_format($totalNetPay, 2) . '</b></td>
        </tr>
    ';

    return $contents;
}

// Function to calculate withholding tax based on gross pay
function calculateWithholdingTax($gross) {
    if ($gross <= 250000) {
        return 0;
    } elseif ($gross <= 400000) {
        return $gross * 0.15;
    } elseif ($gross <= 800000) {
        return $gross * 0.20;
    } elseif ($gross <= 2000000) {
        return $gross * 0.25;
    } elseif ($gross <= 8000000) {
        return $gross * 0.30;
    } else {
        return $gross * 0.35;
    }
}

$range = isset($_POST['date_range']) ? $_POST['date_range'] : '';
if (empty($range)) {
    // Handle the case where date_range is not set or empty
    exit('Date range is not set or empty.');
}

$ex = explode(' - ', $range);
$from = date('Y-m-d', strtotime($ex[0]));
$to = date('Y-m-d', strtotime($ex[1]));

$from_title = date('M d, Y', strtotime($ex[0]));
$to_title = date('M d, Y', strtotime($ex[1]));

require_once('../tcpdf/tcpdf.php');  
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  // Set 'L' for landscape orientation
$pdf->SetCreator(PDF_CREATOR);  
$pdf->SetTitle('Payroll: '.$from_title.' - '.$to_title);  
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
$pdf->SetDefaultMonospacedFont('helvetica');  
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
$pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
$pdf->setPrintHeader(false);  
$pdf->setPrintFooter(false);  
$pdf->SetAutoPageBreak(TRUE, 10);  
$pdf->SetFont('helvetica', '', 11);  
$pdf->AddPage();  
$content = '';  
$content .= '
<h2 align="center">BUNAG-CARLOS BUILDERS</h2>
<h4 align="center">'.$from_title." - ".$to_title.'</h4>
<table border="1" cellspacing="0" cellpadding="3">  
    <tr>  
        <th width="15%" style="text-align: center;"><b>Employee Name</b></th>
        <th width="15%" style="text-align: center;"><b>Gross</b></th>
        <th width="15%" style="text-align: center;"><b>SSS Contribution</b></th>
        <th width="15%" style="text-align: center;"><b>PhilHealth Contribution</b></th>
        <th width="15%" style="text-align: center;"><b>Withholding Tax</b></th>
        <th width="15%" style="text-align: center;"><b>Cash Advance</b></th>
        <th width="10%" style="text-align: center;"><b>Net Pay</b></th> 
    </tr>  
';  

$content .= generateRow($from, $to, $conn);  
$content .= '</table>';  
$pdf->writeHTML($content);  
$pdf->Output('payroll.pdf', 'I');
?>
