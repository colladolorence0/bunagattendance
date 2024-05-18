<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){

		$sss_contribution = $_POST['sss_contribution'];
		$philhealth_contribution = $_POST['philhealth_contribution'];
		$withholding_tax = $_POST['withholding_tax'];

		$sql = "INSERT INTO deductions (sss_contribution, philhealth_contribution, withholding_tax) 
				VALUES ('$sss_contribution', '$philhealth_contribution', '$withholding_tax')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Deduction added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: deduction.php');
?>
