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
    <body>
        <?php
        include 'navbar.php';
        ?>
        <main>
        <?php
            $conn = OpenCon();
            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
        
            $sql2 = "SELECT (SUM(price*quantity)) AS totalsum FROM shoppingcart WHERE memberid = " . $_SESSION['memberID']; 
            $result2 = $conn->query($sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $sum = $row2['totalsum'];
            
        ?>
            <div class="jumbotron color-grey-light mt-70">
            <div class="d-flex align-items-center h-100">
                <div class="container text-center py-1">
                    <h1 class="mb-0"><strong>Payment</strong></h1>
                </div>
            </div>
        </div>
            
<div class="container py-5">
    <!-- For demo purpose -->
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card ">
                <div class="card-header">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                        <!-- Credit card form tabs -->
                        <ul role="tablist" class="btn button_forms btn-info btn-block">
                            <li class="nav-item"> <a data-toggle="pill" href="#credit-card" class="nav-link active " style="color:white"> <i class="fas fa-credit-card mr-2" style="color:white"></i> Credit Card </a> </li>
                        </ul>
                    </div> <!-- End -->
                    <!-- Credit card form content -->
                    <div class="tab-content">
                        <!-- credit card info-->
                        <div id="credit-card" class="tab-pane fade show active pt-3">
                            <form>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group"> 
                                        <label for="username"><strong>Card Owner</strong></label>
                                        <input type="text" name="username" id="username" placeholder="Card Owner Name" required class="form-control "> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                <div class="form-group"> 
                                    <label for="cardNumber"><strong>Card number</strong></label>
                                    <div class="input-group"> 
                                        <input type="text" name="cardNumber" id="cardNumber" placeholder="Valid card number" class="form-control " required>
                                        <div class="input-group-append"> 
                                            <span class="input-group-text text-muted"> 
                                                <i class="fab fa-cc-visa mx-1"></i> 
                                                <i class="fab fa-cc-mastercard mx-1"></i> 
                                                <i class="fab fa-cc-amex mx-1"></i> 
                                            </span> 
                                        </div>
                                    </div>
                                </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group"> 
                                            <label for="expiry">
                                                <span class="hidden-xs">
                                                    <strong>Expiration Date</strong>
                                                </span>
                                            </label>
                                            <div class="input-group"> 
                                                <input type="number" placeholder="MM" name="expiry" id="expiry" class="form-control" required> 
                                                <input type="number" placeholder="YY" name="expiry2" id="expiry2" class="form-control" required> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group mb-4"> 
                                            <label data-toggle="tooltip" for="cvv" title="Three digit CV code on the back of your card">
                                                <strong>CVV</strong>
                                            </label> 
                                            <input type="text" required class="form-control" id="cvv"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <strong>Total amount:</strong>
                                            <p class="mb-0"><span><strong>$ <?php echo $sum; ?></strong></span></p><br>
                                            <div class="card-footer"> 
                                                <button type="button" class="btn button_forms btn-info btn-block"> Confirm Payment </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div id="paypal-payment-button"></div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
     
    <script src="https://www.paypal.com/sdk/js?client-id=AUh4NMuhyjUVD1PGQsgBsNUEVgSq2NXdOgqQRLTbQ9roPyJwsMHLHvlStaj_NuGIP3VSyKoGm8GzUS7_&disable-funding=credit,card"></script>
    <script>
        paypal.Buttons({
            style :{
                color:'blue',
                shape:'pill'
            },
            createOrder:function(data, actions){
                return actions.order.create({
                    purchase_units:[{
                        amount:{
                            value:'<?php echo $sum; ?>'
                        }
                    }]
                });
            },
            onApprove:function(data, actions){
                return actions.order.capture().then(function(details){
                    console.log(details);
                    window.location.replace("http://54.145.106.172/1004Project/delivery.php");
                });
            },
            onCancel:function(data){
                window.location.replace("http://54.145.106.172/1004Project/cart.php");
            }
        }).render('#paypal-payment-button');
    </script>
    </main>
    <?php
        include 'footer.php';
    ?>
    </body>
    
</html>
