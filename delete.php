<?php
    //database connection
    $$conn = mysqli_connect("localhost", "root", "", "deliverydate");
        // Check connection
        if ($$conn === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
  //get post from index.php
  $id = $_POST['delete_id'];
  //query to delete row
  $query = mysqli_query($$conn,"DELETE FROM deliverydate WHERE id='$id'");
?>



