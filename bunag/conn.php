<?php
	$conn = new mysqli('localhost', 'root', '', 'apsystem');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>

<?php 
$con = mysqli_connect("localhost", "root", "", "apsystem");
if(!$con){
die("Error");
}

?>