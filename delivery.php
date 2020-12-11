<?php
require 'dbconfig.php';
include 'sessiontest.php';
include 'memberTraverseSecurity.php';
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <?php
        $conn = OpenCon();
        // Check connection
        if ($conn === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        include 'header.php';
        ?>
        <title>Floured</title>
    </head>
    <body>
        <?php
        include 'navbar.php';
        ?>
        <br/>
        <br/>
        <br/>
        <main class="container">        
            <h1>Order Delivery Date</h1>
            <p> 
                Please select your date here. 


            </p>        
            <form action="" method="post">
                <label for="Delivery">Delivery Date:</label>              
                <input type="date" id="dateD" name="dateD"
                       min="<?php
                       $Date = $date = date("Y-m-d");
                       echo date('Y-m-d', strtotime($Date . ' + 2 days'));
                       ?>" 
                       max="<?php
                       $Date = $date = date("Y-m-d");
                       echo date('Y-m-d', strtotime($Date . ' + 14 days'));
                       ?>"
                       >
                <input type="submit" name="submit" class="btn button_forms btn-info">
            </form>  
            <a style="color: red;">
                <?php
                if (isset($_POST['submit'])) {
                    if (empty($_POST["dateD"])) {
                        echo "Date chosen is empty or unavailable. ";
                    } else {
                        $launch_date = $_POST['dateD'];
                        $id = $_SESSION['memberID'];
                        $query = "SELECT * FROM shoppingcart WHERE memberid = '$id'";
                        if ($result = $conn->query($query)) {
                            while ($row = $result->fetch_assoc()) {
                                $fieldprice = $row["price"];
                                $fieldimg = $row["imgurl"];
                                $fieldquantity = $row["quantity"];
                                $fieldname = $row["name"];


                                //echo $launch_date;
                                //echo "Date Chosen !!!";
                                $sql = "INSERT INTO checkout (name, date, memberid, price, quantity, imgurl, status) VALUES ('$fieldname', '$launch_date', '$id', '$fieldprice', '$fieldquantity', '$fieldimg', 'undelivered')";
                                if (mysqli_query($conn, $sql)) {
                                    $status = "added";
                                } else {
                                    echo "Date chosen is empty or unavailable. ";
                                }
                            }
                        } else {
                            echo "No Delivery Found";
                        }
                        if ($status == "added") {
                            $sql3 = "DELETE FROM shoppingcart WHERE memberid = " . $id;
                            $conn->query($sql3);
                            echo $launch_date;
                            echo " has been selected.";
                            echo "<br>";
                            echo "Cakes has been successfully purchased, click here to see your delivery's date";
                            ?>
                            <input class="btn button_forms btn-info" type="button" value="Delivery" onclick="window.location.href = 'viewdelivery.php';">
                            <?php
                        } else {
                            echo "Date chosen is empty or unavailable. ";
                        }
                    }
                }
                ?>
            </a>
            <br><br>
        </main>    
<?php
include 'footer.php';
?>
    </body>

</html>

