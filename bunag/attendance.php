<?php
if (isset($_POST['employee'])) {
    $output = array('error' => false);

    include 'conn.php'; // Include database connection file
    include 'timezone.php'; // Include timezone configuration file if needed

    $employee = $_POST['employee']; // Get employee ID from POST data
    $status = $_POST['status']; // Get status (Time In or Time Out) from POST data

    // Query to check if the employee exists in the database
    $sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
    $query = $conn->query($sql);

    if ($query->num_rows > 0) { // If employee exists
        $row = $query->fetch_assoc();
        $id = $row['id']; // Get employee's ID

        $date_now = date('Y-m-d'); // Get current date

        if ($status == 'in') { // If status is Time In
            // Check if the employee has already timed in for today
            $sql = "SELECT * FROM attendance WHERE employee_id = '$id' AND date = '$date_now' AND time_in IS NOT NULL";
            $query = $conn->query($sql);
            if ($query->num_rows > 0) {
                $output['error'] = true;
                $output['message'] = 'You have already timed in for today';
            } else {
                // Update employee's attendance record with Time In
                $sched = $row['schedule_id']; // Get employee's schedule ID
                $lognow = date('H:i:s'); // Get current time
                $sql = "SELECT * FROM schedules WHERE id = '$sched'";
                $squery = $conn->query($sql);
                $srow = $squery->fetch_assoc();
                $logstatus = ($lognow > $srow['time_in']) ? 0 : 1; // Determine log status based on time
                $sql = "INSERT INTO attendance (employee_id, date, time_in, status) VALUES ('$id', '$date_now', NOW(), '$logstatus')";
                if ($conn->query($sql)) {
                    $output['message'] = 'TIME IN: ' . strtoupper($row['firstname']) . ' ' . strtoupper($row['lastname']);

                } else {
                    $output['error'] = true;
                    $output['message'] = $conn->error;
                }
            }
        } else { // If status is Time Out
            // Check if the employee has already timed out for today
            $sql = "SELECT *, attendance.id AS uid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id WHERE attendance.employee_id = '$id' AND date = '$date_now'";
            $query = $conn->query($sql);
            if ($query->num_rows < 1) {
                $output['error'] = true;
                $output['message'] = 'Cannot Time Out. No time in recorded.';
            } else {
                $row = $query->fetch_assoc();
                if ($row['time_out'] != '00:00:00') {
                    $output['error'] = true;
                    $output['message'] = 'You have already timed out for today';
                } else {
                    // Update employee's attendance record with Time Out
                    $sql = "UPDATE attendance SET time_out = NOW() WHERE id = '" . $row['uid'] . "'";
                    if ($conn->query($sql)) {
                        $output['message'] = 'TIME OUT: ' . strtoupper($row['firstname']) . ' ' . strtoupper($row['lastname']);


                        // Calculate hours worked and update attendance record
                        $sql = "SELECT * FROM attendance WHERE id = '" . $row['uid'] . "'";
                        $query = $conn->query($sql);
                        $urow = $query->fetch_assoc();

                        $time_in = $urow['time_in'];
                        $time_out = $urow['time_out'];

                        $sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";
                        $query = $conn->query($sql);
                        $srow = $query->fetch_assoc();

                        if ($srow['time_in'] > $urow['time_in']) {
                            $time_in = $srow['time_in'];
                        }

                        if ($srow['time_out'] < $urow['time_in']) {
                            $time_out = $srow['time_out'];
                        }

                        $time_in = new DateTime($time_in);
                        $time_out = new DateTime($time_out);
                        $interval = $time_in->diff($time_out);
                        $hrs = $interval->format('%h');
                        $mins = $interval->format('%i');
                        $mins = $mins / 60;
                        $int = $hrs + $mins;
                        if ($int > 4) {
                            $int = $int - 1;
                        }

                        $sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '" . $row['uid'] . "'";
                        $conn->query($sql);
                    } else {
                        $output['error'] = true;
                        $output['message'] = $conn->error;
                    }
                }
            }
        }
    } else {
        $output['error'] = true;
        $output['message'] = 'Employee ID not found';
    }
}

echo json_encode($output);
?>
