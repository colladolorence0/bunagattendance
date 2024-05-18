<?php
include 'includes/session.php';

$range = $_POST['date_range'];
$ex = explode(' - ', $range);
$from = date('Y-m-d', strtotime($ex[0]));
$to = date('Y-m-d', strtotime($ex[1]));

$from_title = date('M d, Y', strtotime($ex[0]));
$to_title = date('M d, Y', strtotime($ex[1]));

require_once('../tcpdf/tcpdf.php');
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Payslip: '.$from_title.' - '.$to_title); 
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont('helvetica');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('helvetica', '', 11);
$contents = '';

$sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid, employees.employee_id AS employee, position.description AS position_desc 
        FROM attendance 
        LEFT JOIN employees ON employees.id = attendance.employee_id 
        LEFT JOIN position ON position.id = employees.position_id 
        WHERE date BETWEEN '$from' AND '$to' 
        GROUP BY attendance.employee_id 
        ORDER BY employees.lastname ASC, employees.firstname ASC";

$query = $conn->query($sql);
$overall_net_pay = 0; // Initialize overall net pay to zero

while ($row = $query->fetch_assoc()) {
    $empid = $row['empid'];
    
    $casql = "SELECT *, SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";
    $caquery = $conn->query($casql);
    $carow = $caquery->fetch_assoc();
    $cashadvance = $carow['cashamount'];

    $gross = $row['rate'] * $row['total_hr'];

    // Calculate SSS Contribution
    $sss_contribution = ($gross) * 0.045;

    // Calculate PhilHealth Deduction based on the employee's actual salary
    $philhealth_rate = 0.05; // Default rate for all salaries
    $salary = $gross; // Calculate the employee's salary
    $philhealth_contribution = $salary * $philhealth_rate / 2; // Divide by 2 for employee share

    // Calculate Withholding Tax
    $gross = $row['rate'] * $row['total_hr'];
    if ($gross <= 250000) {
      $withholding_tax = 0;
    } elseif ($gross <= 400000) {
      $withholding_tax = $gross  * 0.15;
    } elseif ($gross <= 800000) {
      $withholding_tax = $gross * 0.20;
    } elseif ($gross <= 2000000) {
      $withholding_tax = $gross * 0.25;
    } elseif ($gross <= 8000000) {
      $withholding_tax = $gross * 0.30;
    } else {
      $withholding_tax = $gross * 0.35;
    }
    
    $total_deduction = $sss_contribution + $philhealth_contribution + $withholding_tax + $cashadvance;
    $net = $gross - $total_deduction;

    $total_earnings = $gross; // Compute total earnings as gross pay

    $overall_net_pay += $net; // Add net pay to overall net pay

   // Fetch Other Earnings Data with Error Checking
   $oe_sql = "SELECT * FROM other_earnings WHERE employee_id='$empid' AND created_at BETWEEN '$from' AND '$to'";
   $oe_query = $conn->query($oe_sql);
   if ($oe_query && $oe_query->num_rows > 0) {
       $oe_row = $oe_query->fetch_assoc();
       $bonus = $oe_row['bonus'];
       $overtime = $oe_row['overtime'];
       $transportation_allowance = $oe_row['transportation_allowance'];
   } else {
       // Handle the case when other earnings data is not available
       $bonus = 0;
       $overtime = 0;
       $transportation_allowance = 0;
   }

  // Update Total Earnings Calculation to include Bonus, Overtime, and Transportation Allowance
$total_earnings = $gross + $bonus + $overtime + $transportation_allowance; // Include other earnings in total earnings

// Define Deductions including SSS, PhilHealth, Tax, and Cash Advance
$sss_deduction = $sss_contribution;
$philhealth_deduction = $philhealth_contribution;
$tax_deduction = $withholding_tax;
$cashadvance_deduction = $cashadvance;

// Calculate Total Deduction including Cash Advance
$total_deduction = $sss_contribution + $philhealth_contribution + $withholding_tax + $cashadvance_deduction;

// Calculate Net Pay including Bonus, Overtime, Transpo Allowance, and Cash Advance
$net = $total_earnings - $total_deduction;

// Update Overall Net Pay by adding the current net pay
$overall_net_pay += $net;

   $contents .= '
    <h2 align="center">BUNAG-CARLOS BUILDERS</h2>
    <h4 align="center">'.$from_title." - ".$to_title.'</h4>
    <table cellspacing="0" cellpadding="5" width="100%">
        <h2 align="center">Payslip</h2>
        <tr>
            <td align="right" width="25%"><b>Employee Name:</b></td>
            <td width="25%">' . $row['firstname'] . " " . $row['lastname'] . '</td>
            <td align="right"><b>Total Hours:</b></td>
            <td>' . number_format($row['total_hr'], 2) . '</td>
        </tr>
        <tr>
            <td align="right" width="25%"><b>Employee Position:</b></td>
            <td width="25%">' . $row['position_desc'] . '</td>
            <td align="right" width="25%"><b>Rate per Hour:</b></td>
            <td>' . number_format($row['rate'], 2) . '</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td align="right" width="25%"><b>Employee ID:</b></td>
            <td width="25%">' . $row['employee'] . '</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="right"><b>Gross Pay:</b></td>
            <td>' . number_format(($row['rate'] * $row['total_hr']), 2) . '</td>
        </tr>
    </table>
    <br><hr>
    <table width="100%">
        <tr>
            <td width="50%" style="vertical-align: top;">
                <h3 align="center">Earnings</h3>
                <table cellspacing="0" cellpadding="5" border="1" width="100%">
                    <tr>
                        <th align="left">Description</th>
                        <th align="right">Amount</th>
                    </tr>
                    <tr>
                        <td align="left">Basic Pay</td>
                        <td align="right">' . number_format($gross, 2) . '</td>
                    </tr>
                    <tr>
                        <td align="left">Bonus</td>
                        <td align="right">' . number_format($bonus, 2) . '</td>
                    </tr>
                    <tr>
                        <td align="left">Overtime</td>
                        <td align="right">' . number_format($overtime, 2) . '</td>
                    </tr>
                    <tr>
                        <td align="left">Transpo. Allowance</td>
                        <td align="right">' . number_format($transportation_allowance, 2) . '</td>
                    </tr>
                    <tr>
                        <td align="left"><b>Total Earnings</b></td>
                        <td align="right"><b>' . number_format($total_earnings, 2) . '</b></td>
                    </tr>
                </table>
            </td>
            <td width="50%" style="vertical-align: top;">
                <h3 align="center">Deductions</h3>
                <table cellspacing="0" cellpadding="5" border="1" width="100%">
                    <tr>
                        <th align="left">Description</th>
                        <th align="right">Amount</th>
                    </tr>
                    <tr>
                        <td align="left">SSS Contribution</td>
                        <td align="right">' . number_format($sss_deduction, 2) . '</td>
                    </tr>
                    <tr>
                        <td align="left">PhilHealth Contribution</td>
                        <td align="right">' . number_format($philhealth_deduction, 2) . '</td>
                    </tr>
                    <tr>
                        <td align="left">Withholding Tax</td>
                        <td align="right">' . number_format($tax_deduction, 2) . '</td>
                    </tr>
                    <tr>
                        <td align="left">Cash Advance</td>
                        <td align="right">' . number_format($cashadvance, 2) . '</td>
                    </tr>
                    <tr>
                        <td align="left"><b>Total Deduction</b></td>
                        <td align="right"><b>' . number_format($total_deduction, 2) . '</b></td>
                    </tr>
                    <tr>
                        <td align="left"><b>Total Netpay</b></td>
                        <td align="right"><b>' . number_format($net, 2) . '</b></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    
    <table width="100%" style="margin-top: 120px;">
        <tr>
            <td width="50%" align="center"><b>______________________</b></td>
            <td width="50%" align="center"><b>______________________</b></td>
        </tr>
        <tr>
            <td width="50%" align="center"><b>Employer Signature</b></td>
            <td width="50%" align="center"><b>Employee Signature</b></td>
        </tr>
    </table>
    ';

    $pdf->AddPage();
    $pdf->writeHTML($contents);
    $contents = '';
}

$pdf->Output('payslip.pdf', 'I');
?>
