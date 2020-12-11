<?php
require 'dbconfig.php';
include 'sessiontest.php';
include 'memberTraverseSecurity.php';
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <?php
        include 'header.php';
        ?>
        <title>Floured</title>
    </head>
    <body class="skin-light">
    <?php
        include 'navbar.php';
    ?>
    <!--Main Navigation-->
    <!--Main layout-->
    <main>

        <?php
        $conn = OpenCon();
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT dimension, price, imgurl, quantity, name, cartid FROM shoppingcart WHERE memberid = " . $_SESSION['memberID'];
        $result = $conn->query($sql);
        ?>

        <div class="jumbotron color-grey-light mt-70">
            <div class="d-flex align-items-center h-100">
                <div class="container text-center py-1">
                    <h1 class="mb-0"><strong>Shopping Cart</strong></h1>
                </div>
            </div>
        </div>
        <div class="container" id="mydiv">
            <!--Section: Block Content-->
            <section class="mt-5 mb-4">
                <!--Grid row-->
                <div class="row">
                    <!--Grid column-->
                    <div class="col-lg-8">
                        <!-- Card -->
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <div class="card wish-list mb-4" id="delete<?php echo $row["cartid"]; ?>">
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-5 col-lg-3 col-xl-3">
                                            <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                                                <img class="img-fluid w-100" src="<?php echo $row["imgurl"]; ?>" alt="Sample">
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-lg-9 col-xl-9">
                                            <div>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p><b><?php echo $row["name"]; ?></b></p>
                                                        <p class="mb-2 text-muted text-uppercase small"><?php echo "Dimension: " . $row["dimension"]; ?></p>
                                                    </div>
                                                    <div>
                                                        <div>
                                                            <button type="submit" class="fa fa-plus" onclick="increaseAjax(<?php echo $row["cartid"]; ?>,<?php echo $row["quantity"]; ?>)"
                                                                    style="border-color:transparent; background-color:transparent; float:right; height:30px"></button>
                                                            <input onchange="updateAjax(<?php echo $row["cartid"]; ?>, this.value)" min="0" value="<?php echo $row["quantity"]; ?>" 
                                                                   type="number" style="text-align:center; width:50%; float:right; height:30px">
                                                            <button type="submit" class="fa fa-minus" onclick="decreaseAjax(<?php echo $row["cartid"]; ?>,<?php echo $row["quantity"]; ?>)"
                                                                    style="border-color:transparent; background-color:transparent; float:right; height:30px" ></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <button style="border-color:transparent; background-color:transparent; color:blue;" id="deleteItem" name="deleteItem" type="submit" class="card-link-secondary small text-uppercase mr-3" 
                                                                onclick="deleteAjax(<?php echo $row["cartid"]; ?>)" ><i class="fas fa-trash-alt mr-1" ></i>Remove Item</button>
                                                    </div>
                                                    <p class="mb-0"><span><strong>$ <?php echo $row["price"]; ?></strong></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?> 
                        <script type="text/javascript">
                            function deleteAjax(id) {
                                $.ajax({
                                    type: 'post',
                                    url: 'deleteCart.php',
                                    data: {delete_id: id},
                                    success: function (data) {
                                        $('#mydiv').load(location.href + " #mydiv");
                                    }
                                });
                            }
                            function decreaseAjax(id, quantity) {
                                $.ajax({
                                    type: 'post',
                                    url: 'decreaseCart.php',
                                    data: {update_id: id,
                                        quantity: quantity},
                                    success: function (data) {
                                        $('#mydiv').load(location.href + " #mydiv");
                                    }
                                });
                            }
                            function increaseAjax(id, quantity) {
                                $.ajax({
                                    type: 'post',
                                    url: 'increaseCart.php',
                                    data: {update_id: id,
                                        quantity: quantity},
                                    success: function (data) {
                                        $('#mydiv').load(location.href + " #mydiv");
                                    }
                                });
                            }
                            function updateAjax(id, quantity) {
                                $.ajax({
                                    type: 'post',
                                    url: 'updateCart.php',
                                    data: {update_id: id,
                                        quantity: quantity},
                                    success: function (data) {
                                        $('#mydiv').load(location.href + " #mydiv");
                                    }
                                });
                            }
                        </script>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                        <!-- Card -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-4"><b>We accept</b></div>
                                <img alt="Credit card options" class="img-responsive cc-img" src="http://www.prepbootstrap.com/Content/images/shared/misc/creditcardicons.png" width='200'>
                            </div>
                        </div>
                        <!-- Card -->
                    </div>
                    <!--Grid column-->
                    <div class="col-lg-4">
                        <!-- Card -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3"><b>Total amount:</b></div>
                                <?php
                                $sql = "SELECT name, (price*quantity) AS tPrice FROM shoppingcart WHERE memberid = " . $_SESSION['memberID'];
                                $result = $conn->query($sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <ul class="list-group list-group-flush">
                                        <li id="item" class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                            <?php echo $row["name"]; ?>
                                            <span>$ <?php echo $row["tPrice"]; ?></span>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                        <div>
                                        </div>
                                        <span><strong>$
                                                <?php
                                                $sql2 = "SELECT (SUM(price*quantity)) AS totalsum FROM shoppingcart WHERE memberid = " . $_SESSION['memberID'];
                                                $result2 = $conn->query($sql2);
                                                $row2 = mysqli_fetch_assoc($result2);
                                                $sum = $row2['totalsum'];
                                                echo $sum;
                                                ?>
                                            </strong></span>
                                    </li>
                                </ul>
                                <form action="payment.php" method="POST">
                                    <button type="submit" class="btn button_forms btn-info btn-block">Checkout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </section>
            <!--Section: Block Content-->
        </div>
    </main>
    <!--Main layout-->
    <?php
        include 'footer.php';
    ?>
</body>


</html>