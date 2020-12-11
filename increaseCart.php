<?php

require 'dbconfig.php';
include 'sessiontest.php';
include 'memberTraverseSecurity.php';

        
        // Create connection
        $conn = OpenCon();
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        
            $cartid = $_POST["update_id"];
            $quantity = $_POST["quantity"] + 1;
            $sql5 = "UPDATE shoppingcart SET quantity = " . $quantity . " WHERE cartid = " . $cartid;
            $conn->query($sql5);    

            
            
        
?>