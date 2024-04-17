<?php
    if(isset($_POST['name'])){
        $server="localhost";
        $username= "root";
        $password="";
        $database = "jploka";
        $con = mysqli_connect($server, $username, $password,$database);

        if(!$con){
            die("Connection to this database failed due to" . mysqli_connect_error());
        }

        $date = $_POST['date'];
        
        // Check if a record with the same date already exists
        $check_sql = "SELECT COUNT(*) AS count FROM `event` WHERE `date` = '$date'";
        $check_result = mysqli_query($con, $check_sql);
        $count = mysqli_fetch_assoc($check_result)['count'];
        if($count > 0 && !isset($_GET['error'])) {
            // Redirect back to the form page with an error message
            header("Location: EventBooking.php?error=A record with the same date already exists. Please choose a different date.");
            exit();
        } else {
            // Insert the new record if no record with the same date exists
            $time = $_POST['time'];
            $eve = $_POST['eve'];
            $no = $_POST['no'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $aadhar = $_POST['aadhar'];

            $sql = "INSERT INTO `event` (`date`, `time`, `eve`, `no`, `name`, `em`, `ph`, `aadhar`,`Timestamp`) VALUES ('$date', '$time', '$eve', '$no','$name', '$email', '$phone', '$aadhar',current_timestamp())";
            if($con->query($sql) === TRUE){
                // Data inserted successfully, redirect to payment.html
                header("Location: payment.html");
                exit; // Make sure to stop script execution after redirection
            } else {
                // Handle the case where insertion failed
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        }

        $con->close();
    }
?>
