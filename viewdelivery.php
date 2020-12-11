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
            <h1>View Delivery Date</h1>
            <div class="card border-dark mb-3">
                <div class="card-header"> &nbsp;Your Date</div>
                <div class="card-body text-primary">
                    <main role="main" class="col-md-9 ml-sm-auto col-lg-auto px-md-auto">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="tabledate">
                                <thead>
                                    <tr>
                                        <th>Cakes</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $status = 1;
                                    $id = $_SESSION['memberID'];
                                    $query = "SELECT * FROM checkout WHERE memberid = '$id' and status = 'undelivered'";
                                    if ($result = $conn->query($query)) {

                                        while ($row = $result->fetch_assoc()) {
                                            $field1name = $row["checkoutid"];
                                            $fieldname = $row["name"];
                                            $fieldquantity = $row["quantity"];
                                            $fielddate = $row["date"];
                                            $field1img = $row["imgurl"];
                                            $status = 0;
                                            ?>     
                                            <tr id="delete<?php echo $field1name; ?>"> 
                                                <td><img class="img" src="<?php echo $row["imgurl"]; ?>" alt="cakes" width="100px" height="100px"></td>
                                                <td><?php echo $fieldname; ?></td>
                                                <td><?php echo $fieldquantity; ?></td>
                                                <td><?php echo $fielddate; ?></td>
                                                <td style="text-align:right;">                                    
                                                    <form action="deliveryedit.php" method="POST">
                                                        <button class="btn button_forms btn-info" name="editdate" value="<?php echo $field1name; ?>" >Change date</button>
                                                    </form>
                                                </td>
            <!--                                                <td style="text-align:right;">                                         
                                                    <button name="deletedate" onclick="deleteAjax(<?php //echo $field1name;   ?>)">Delete date</button>
                                                </td>-->
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
                                        $.ajax({
                                            type: 'post',
                                            url: 'deletedelivery.php',
                                            data: {delete_id: id},
                                            success: function (data) {
                                                $('#delete' + id).hide('slow');
                                            }
                                        });
                                    }
                                </script>
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                            </table>
                            <?php
                            if ($status == 1) {
                                ?>
                                <a id="todelete">No Delivery cakes found, <a href="catalogue.php" style="color: red;">Click here to add some cakes</a></a>
                                <?php
                            } else {
                                echo "";
                            }
                            ?>

                        </div>
                </div>
            </div>
        </main>  
<?php
include 'footer.php';
?>                
    </body>

</html>

