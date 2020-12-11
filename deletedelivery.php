<?php
require 'dbconfig.php';
include 'sessiontest.php';
include 'adminTraverseSecurity.php';

 $conn = OpenCon();
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
   
  $id = $_POST['delete_id'];
  $query = mysqli_query($conn,"UPDATE checkout SET status = 'delivered' WHERE checkoutid='$id'");
   //$sql2 = "UPDATE checkout SET date = '$launch_date' WHERE checkoutid = " . $rowid;
?>

