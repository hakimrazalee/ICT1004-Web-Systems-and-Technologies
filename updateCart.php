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
            $quantity = $_POST["quantity"];
            if ($quantity == 0){
                $sql3 = "DELETE FROM shoppingcart WHERE cartid = " . $cartid;
                $conn->query($sql3);    
            }
            else{
                $sql3 = "UPDATE shoppingcart SET quantity = " . $quantity . " WHERE cartid = " . $cartid;
                $conn->query($sql3);    
            } 

            
            
        
?>

