<?php include 'includes/session.php'; ?>
<?php
include '../timezone.php';
if (isset($_POST['date_range'])) {
    $_SESSION['date_range'] = $_POST['date_range'];
}

// Set default date range if not already set
if (!isset($_SESSION['date_range'])) {
    $_SESSION['date_range'] = date('m/d/Y', strtotime('-30 day')) . ' - ' . date('m/d/Y');
}

$range = $_SESSION['date_range'];
$ex = explode(' - ', $range);
$range_from = $ex[0];
$range_to = $ex[1];
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payroll
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Payroll</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
      if (isset($_SESSION['error'])) {
        echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
        unset($_SESSION['error']);
      }
      if (isset($_SESSION['success'])) {
        echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
        unset($_SESSION['success']);
      }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <div class="pull-right">
                <form method="POST" class="form-inline" id="payForm">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range"
                           value="<?php echo (isset($_GET['range'])) ? $_GET['range'] : $range_from . ' - ' . $range_to; ?>">
                  </div>
                  <button type="button" class="btn btn-success btn-sm btn-flat" id="payroll"><span
                              class="glyphicon glyphicon-print"></span> Payroll
                  </button>
                  <button type="button" class="btn btn-primary btn-sm btn-flat" id="payslip"><span
                              class="glyphicon glyphicon-print"></span> Payslip
                  </button>
                </form>
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Gross</th>
                <th>SSS Contribution</th>
                <th>PhilHealth Deduction</th>
                <th>Withholding Tax</th>
                <th>Cash Advance</th>
                <th>Net Pay</th>
                </thead>
                <tbody>
                <?php

                $to = date('Y-m-d');
                $from = date('Y-m-d', strtotime('-30 day', strtotime($to)));

                if (isset($_GET['range'])) {
                  $range = $_GET['range'];
                  $ex = explode(' - ', $range);
                  $from = date('Y-m-d', strtotime($ex[0]));
                  $to = date('Y-m-d', strtotime($ex[1]));
                }

                $sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid 
                        FROM attendance 
                        LEFT JOIN employees ON employees.id=attendance.employee_id 
                        LEFT JOIN position ON position.id=employees.position_id 
                        WHERE date BETWEEN '$from' AND '$to' 
                        GROUP BY attendance.employee_id 
                        ORDER BY employees.lastname ASC, employees.firstname ASC";

                $query = $conn->query($sql);
                $total = 0;
                while ($row = $query->fetch_assoc()) {
                  $empid = $row['empid'];

                  // Calculate SSS Contribution
                  $sss_contribution = ($row['rate'] * $row['total_hr']) * 0.045;

               // Calculate PhilHealth Deduction based on the employee's actual salary
                    $philhealth_rate = 0.05; // Default rate for all salaries
                     $salary = $row['rate'] * $row['total_hr']; // Calculate the employee's salary

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

                  // Fetch Cash Advance Amount for the employee
                  $casql = "SELECT SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";
                  $caquery = $conn->query($casql);
                  $carow = $caquery->fetch_assoc();
                  $cashadvance = $carow['cashamount'] ?? 0; // Use the fetched cash advance amount or default to 0 if not found

                  $total_deduction = $sss_contribution + $philhealth_contribution + $withholding_tax;
                  $net = $gross - $total_deduction - $cashadvance;

                  echo "
                        <tr>
                          <td>" . $row['lastname'] . ", " . $row['firstname'] . "</td>
                          <td>" . $row['employee_id'] . "</td>
                          <td>" . number_format($gross, 2) . "</td>
                          <td>" . number_format($sss_contribution, 2) . "</td>
                          <td>" . number_format($philhealth_contribution, 2) . "</td>
                          <td>" . number_format($withholding_tax, 2) . "</td>
                          <td>" . number_format($cashadvance, 2) . "</td>
                          <td>" . number_format($net, 2) . "</td>
                        </tr>
                      ";
                }

                ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php include 'includes/footer.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
    $(function () {
        $('.edit').click(function (e) {
            e.preventDefault();
            $('#edit').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.delete').click(function (e) {
            e.preventDefault();
            $('#delete').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $("#reservation").on('change', function () {
            var range = encodeURI($(this).val());
            window.location = 'payroll.php?range=' + range;
        });

        $('#payroll').click(function (e) {
            e.preventDefault();
            $('#payForm').attr('action', 'payroll_generate.php');
            $('#payForm').submit();
        });

        $('#payslip').click(function (e) {
            e.preventDefault();
            $('#payForm').attr('action', 'payslip_generate.php');
            $('#payForm').submit();
        });

    });

    function getRow(id) {
        $.ajax({
            type: 'POST',
            url: 'position_row.php',
            data: {id: id},
            dataType: 'json',
            success: function (response) {
                $('#posid').val(response.id);
                $('#edit_title').val(response.description);
                $('#edit_rate').val(response.rate);
                $('#del_posid').val(response.id);
                $('#del_position').html(response.description);
            }
        });
    }


</script>
</body>
</html>
