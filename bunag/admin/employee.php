<?php include 'includes/session.php'; ?>
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
        Employee List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Employees</li>
        <li class="active">Employee List</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
       <div class="row">
        <div class="col-md-3">
          <!-- Shortened Search Bar -->
          <div class="form-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Employee ID</th>
                  <th>Photo</th>
                  <th>QR Code</th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Schedule</th>
                  <th>Member Since</th>
                  <th>Tools</th>
                
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT *, employees.id AS empid, employees.qrimage AS qrimage FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      ?>
                      <tr id="row_<?php echo $row['empid']; ?>">
                          <td id="employee_id_<?php echo $row['empid']; ?>" class="employee_id_<?php echo $row['empid']; ?>"><?php echo $row['employee_id']; ?></td>
                          <td>
                              <img src="<?php echo (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg'; ?>" width="30px" height="30px">
                              <a href="#edit_photo" data-toggle="modal" class="pull-right photo" data-id="<?php echo $row['empid']; ?>"><span class="fa fa-edit"></span></a>
                          </td>
                          <td>
                          <img src="<?php echo (!empty($row['qrtext'])) ? './images/'.$row['qrtext'] : './images/default_qrcode.png'; ?>" width="30px" height="30px" class="qr-code">

                              <!-- Button to generate QR code -->
                              <button class="btn btn-info btn-sm generate-qr-btn btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-qrcode"></i> Generate QR</button>

                          </td>
                          <td><?php echo $row['firstname'].' '.$row['lastname']; ?></td>
                          <td><?php echo $row['description']; ?></td>
                          <td><?php echo date('h:i A', strtotime($row['time_in'])).' - '.date('h:i A', strtotime($row['time_out'])); ?></td>
                          <td><?php echo date('M d, Y', strtotime($row['created_on'])) ?></td>
                          <td>
                              <button class="btn btn-success btn-sm edit btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-edit"></i> Edit</button>
                              <button class="btn btn-danger btn-sm delete btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-trash"></i> Delete</button>
                              <button class="btn btn-primary btn-sm print btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-print"></i> Print ID</button>
                              <button class="btn btn-info btn-sm view-profile btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-eye"></i> View Profile</button></td>
                              <!-- Add this button within the Tools column -->
                              <!-- <button class="btn btn-info btn-sm generate-qr-btn btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-qrcode"></i> Generate QR</button> -->
                  
                          </td>
                      </tr>
                  <?php
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
  <?php include 'includes/employee_modal.php'; ?>

  <!-- Add the modal code here -->
<div id="view_profile_modal" class="modal fade">
  <div class="modal-dialog modal-lg"> <!-- Updated to modal-lg for larger modal -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Employee Profile</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <img src="" id="view_photo" class="img-responsive" alt="Employee Photo">
           
            <img src="" id="view_qr_text" class="img-responsive" alt="QR Code"></td>


          </div>
          <div class="col-md-8">
            <table class="table table-bordered">
              <tr>
                <th>Employee ID</th>
                <td id="view_employee_id"></td>
              </tr>
              <tr>
                <th>Name</th>
                <td id="view_fullname"></td> <!-- Combined first name and last name -->
              </tr>
              <tr>
                <th>Address</th>
                <td id="view_address"></td>
              </tr>
              <tr>
                <th>Birthdate</th>
                <td id="view_birthdate"></td>
              </tr>
              <tr>
                <th>Contact Info</th>
                <td id="view_contact_info"></td>
              </tr>
              <tr>
                <th>Gender</th>
                <td id="view_gender"></td>
              </tr>
              <tr>
                <th>Password</th>
                <td id="view_password"></td>
              </tr>
              <!-- Add more fields if needed -->
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>


<?php include 'includes/scripts.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>

$(document).ready(function(){
  $('#searchInput').on('keyup', function(){
    var searchText = $(this).val().toLowerCase();
    $('#example1 tbody tr').filter(function(){
      $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
    });
  });
});

$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.photo').click(function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  // New function to handle Generate QR button click
  $('.generate-qr-btn').click(function(e){
    e.preventDefault(); // Prevent default link behavior
    var id = $(this).data('id');
    var employee_id = $('#employee_id_' + id).text(); // Get employee_id from the table row
    
    // Send AJAX request to generate QR code
    generateQRCode(id, employee_id);
  });

  function generateQRCode(id, employee_id) {
    $.ajax({
      type: 'POST',
      url: 'qr.php',
      data: {
        employee_id: employee_id // Send the employee_id
      },
      dataType: 'json',
      success: function(response){
        // Handle success response if needed
        if (response.success) {
          // Update the QR code image in the corresponding row
          var rowId = '#row_' + id;
          $(rowId + ' .qr-code').attr('src', response.qrimage);
          $(rowId + ' .qr-code').show(); // Show the QR code image if hidden
          alert('QR code generated successfully!');
        } else {
          alert('Error generating QR code!');
        }
      },
      error: function(xhr, status, error) {
        // Handle error response if needed
        alert('Error generating QR code!');
      }
    });
  }

  // Function to handle Print ID button click
  $('.print').click(function(e){
    e.preventDefault(); 
    var id = $(this).data('id');
    
    // Open a new window and connect to print_id.php
    window.open('print_id.php?id=' + id, '_blank');
  });

  $('.view-profile').click(function(e){
    e.preventDefault();
    var id = $(this).data('id');
    viewProfile(id);
  });

  function viewProfile(id) {
  $.ajax({
    type: 'POST',
    url: 'employee_profile.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      // Show the employee information in a modal or a separate page
      $('#view_employee_id').html(response.employee.employee_id);
      $('#view_firstname').html(response.employee.firstname);
      $('#view_lastname').html(response.employee.lastname);
      $('#view_fullname').html(response.employee.firstname + ' ' + response.employee.lastname); // Update full name
      $('#view_address').html(response.employee.address);
      $('#view_birthdate').html(response.employee.birthdate);
      $('#view_contact').html(response.employee.contact_info);
      $('#view_gender').html(response.employee.gender);
      $('#view_position').html(response.employee.position);
      $('#view_schedule').html(response.employee.schedule);
      $('#view_photo').attr('src', '../images/' + response.employee.photo);
      
      // Update QR code image source
      $('#view_qr_text').attr('src', './images/' + response.employee.qrtext);
      
      $('#view_password').html(response.employee.password);
      $('#view_profile_modal').modal('show');
    }
  });
}

  function getRow(id){
    $.ajax({
      type: 'POST',
      url: 'employee_row.php',
      data: {id:id},
      dataType: 'json',
      success: function(response){
        $('.empid').val(response.empid);
        $('.employee_id').html(response.employee_id);
        $('.del_employee_name').html(response.firstname+' '+response.lastname);
        $('#employee_name').html(response.firstname+' '+response.lastname);
        $('#edit_firstname').val(response.firstname);
        $('#edit_lastname').val(response.lastname);
        $('#edit_address').val(response.address);
        $('#datepicker_edit').val(response.birthdate);
        $('#edit_contact').val(response.contact_info);
        $('#gender_val').val(response.gender).html(response.gender);
        $('#position_val').val(response.position_id).html(response.description);
        $('#schedule_val').val(response.schedule_id).html(response.time_in+' - '+response.time_out);
      }
    });
  }
});
</script>
</body>
</html>
