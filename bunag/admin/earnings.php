<?php
include 'includes/session.php';
include 'includes/header.php';
?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/menubar.php'; ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Other Earnings</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Other Earnings</li>
                </ol>
            </section>
            <section class="content">
                <?php
                if (isset($_SESSION['error'])) {
                    echo "<div class='alert alert-danger alert-dismissible'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <h4><i class='icon fa fa-warning'></i> Error!</h4>" . $_SESSION['error'] . "
                          </div>";
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    echo "<div class='alert alert-success alert-dismissible'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <h4><i class='icon fa fa-check'></i> Success!</h4>" . $_SESSION['success'] . "
                          </div>";
                    unset($_SESSION['success']);
                }
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <a href="#addOtherEarnings" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Add Other Earnings</a>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th>Employee ID</th>
                                        <th>Bonus</th>
                                        <th>Transportation Allowance</th>
                                        <th>Overtime</th>
                                        <th>Tools</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT oe.id, e.employee_id, oe.bonus, oe.transportation_allowance, oe.overtime 
                                                    FROM other_earnings oe 
                                                    INNER JOIN employees e ON oe.employee_id = e.id";
                                            $query = $conn->query($sql);
                                            while ($row = $query->fetch_assoc()) {
                                                echo "
                                                    <tr>
                                                        <td>" . $row['employee_id'] . "</td>
                                                        <td>₱" . number_format($row['bonus'], 2) . "</td>
                                                        <td>₱" . number_format($row['transportation_allowance'], 2) . "</td>
                                                        <td>₱" . number_format($row['overtime'], 2) . "</td>
                                                        <td>
                                                        <button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i> Edit</button>
                                                        <button class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Delete</button>
                                                    </td>
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
        <?php include 'includes/scripts.php'; ?>
    </div>
    <?php include 'includes/earnings_modal.php'; ?>
    <script>
        $(document).on('click', '.edit', function (e) {
            e.preventDefault();
            $('#editOtherEarnings').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#deleteConfirmation').modal('show');

            $('#confirmDelete').click(function () {
                $.ajax({
                    type: 'POST',
                    url: 'earnings_delete.php',
                    data: {
                        id: id
                    },
                    success: function (response) {
                        location.reload(); // Reload the page after successful deletion
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
        function getRow(id) {
  $.ajax({
    type: 'POST',
    url: 'earnings_row.php',
    data: { id: id },
    dataType: 'json',
    success: function(response) {
      $('#edit_id').val(response.id);
      $('#edit_bonus').val(response.bonus);
      $('#edit_transportation').val(response.transportation_allowance);
      $('#edit_overtime').val(response.overtime);
    }
  });
}
</script>
</body>
</html>
