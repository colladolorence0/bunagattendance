<?php
include 'includes/session.php';

if(isset($_POST['id'])){
  $id = $_POST['id'];
  $sql = "SELECT *, employees.id AS empid, employees.qrimage AS qrimage FROM employees WHERE id = '$id'";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();

  echo json_encode(['success' => true, 'employee' => $row]);
}
else{
  echo json_encode(['success' => false, 'message' => 'Error: Employee not found.']);
}
