<?php
require 'dbconfig.php';
include 'sessiontest.php';
include 'adminTraverseSecurity.php';
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
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <main class="container">        
                    <h1 class="display-4">View Delivery Date</h1>
                    <div class="card border-dark mb-3">
                        <div class="card-header"> &nbsp;Your Date</div>
                        <div class="card-body text-primary">
                            <main role="main" class="col-md-9 ml-sm-auto col-lg-auto px-md-auto">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm" id="tabledate">
                                        <thead>
                                            <tr>
                                                <th>Member's name</th>
                                                <th>Email</th>
                                                <th>Cake</th>
                                                <th>Quantity</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $status = 1;
                                            //$id = $_SESSION['memberID'];
                                            //$query2 = "SELECT * FROM checkout WHERE memberid = '$id'";
                                            $query = "SELECT checkout.checkoutid, fmembers.fname, fmembers.email, checkout.name, checkout.quantity, checkout.date, checkout.status 
FROM Floured.checkout
INNER JOIN Floured.fmembers ON checkout.memberid = fmembers.memberid";
                                            if ($result = $conn->query($query)) {

                                                while ($row = $result->fetch_assoc()) {
                                                    $field1id = $row["checkoutid"];
                                                    $fieldfname = $row["fname"];
                                                    $fieldemail = $row["email"];
                                                    $fieldcakename = $row["name"];
                                                    $fieldquantity = $row["quantity"];
                                                    $fielddate = $row["date"];
                                                    $fieldstatus = $row["status"];
                                                    $status = 0;
                                                    ?>     
                                                    <tr id="delete<?php echo $field1id; ?>"> 
                                                        <td><?php echo $fieldfname; ?></td>
                                                        <td><?php echo $fieldemail; ?></td> 
                                                        <td><?php echo $fieldcakename; ?></td>
                                                        <td><?php echo $fieldquantity; ?></td>
                                                        <td><?php echo $fielddate; ?></td>
                                                        <td><?php echo $fieldstatus; ?></td>
            <!--                                            <td style="text-align:right;">                                    
                                                            <form action="deliveryedit.php" method="POST">
                                                                <button name="editdate" value="<?php echo $field1name; ?>" >Change date</button>
                                                            </form>
                                                        </td>-->
                                                        <?php
                                                        if ($fieldstatus == "undelivered") {
                                                            ?>
                                                            <td style="text-align:right;">                                         
                                                                <button class="btn button_forms btn-info" name="deletedate" onclick="deleteAjax(<?php echo $field1id; ?>)">Delivered Cake</button>
                                                            </td>
                                                            <?php
                                                        }
                                                        ?>

                                                    </tr>
                                                    <?php
                                                }
                                                //$result->free();
                                            } else {
                                                echo "<a>No Delivery Found</a>";
                                            }
                                            ?>
                                        </tbody>
                                        <script type="text/javascript">

                                            function deleteAjax(id) {
                                                var confirmalert = confirm("Confirmed Delivery?");
                                                if (confirmalert == true) {
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'deletedelivery.php',
                                                        data: {delete_id: id},
                                                        success: function (data) {
                                                            //$('#delete' + id).hide('slow');
                                                            location.reload();
                                                        }
                                                    });
                                                }
                                            }
                                        </script>
                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                                    </table>
                                    <?php
                                    if ($status == 1) {
                                        ?>
                                        <a id="todelete">No Delivery cakes found</a>
                                        <?php
                                    } else {
                                        echo "";
                                    }
                                    ?>

                                </div>
                        </div>
                    </div>
            </div>
        </div>
    </main> 
    <?php
    include 'footer.php';
    ?>                           
</body>

</html>



