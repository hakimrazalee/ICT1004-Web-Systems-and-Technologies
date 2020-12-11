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
        
        $cakeId = $_POST["cakeId"];
        $imgurl = $_POST["imgurl"];
        $price = substr($_POST["price"], 1);
        $dimension = $_POST["dimension"];
        $name = $_POST["name"];
        $memberId = $_SESSION['memberID'];
        $quantity = $_POST["quantity"];
        //$memberId = 2;

        $sql3 = "INSERT INTO shoppingcart (cakeid, price, imgurl, memberid, quantity, name, dimension) "
                . "VALUES ($cakeId, $price, '$imgurl', $memberId, $quantity, '$name', '$dimension')";
        
        //INSERT INTO `shoppingcart`(`CakeId`, `Price`, `Imgurl`, `MemberId`, `CartId`, `Quantity`, `Name`, `Dimension`) 
                //VALUES (31,40,'/images/forest.jpg',2,1,3,'Forest', '20 x 10 x 5');

        $result5 = $conn->query($sql3);
        if($result5){
            echo 'Successfully added item to cart!';
        }    
        else{
            echo "Error adding item to cart!";
        }
        

?>

