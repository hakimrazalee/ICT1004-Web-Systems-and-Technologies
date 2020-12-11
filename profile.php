<?php
include 'sessiontest.php';
include 'memberTraverseSecurity.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head> 
        <style >

            .responsive {
                width: 100%;
                /*  max-width: 400px;*/
                height: auto;
            }
        </style>
        <?php
        include "header.php";
        ?>
        <title>Floured - Profile</title>

    </head>

    <body>    
        <?php
        include "navbar.php";
        ?>    
        <br/>
        <br/>
        <br/>

        <div class="row">

            <main class="container">   
                <h1 class='section_heading' style="text-align: center">Profile:</h1>
                <br>
                <div class ="card mb-3" >
                    <div class="row no-gutters">

                        <?php if ($_SESSION['gender'] == 'Male') { ?>
                            <img src="images/img_avatar.png" style="width: 500px" class="card-img-top" alt="profileimg"/>
                        <?php } else if ($_SESSION['gender'] == 'Female') { ?>
                            <img src="images/img_avatar2.png" style="width: 500px" class="card-img-top" alt="profileimg"/>
                        <?php } ?>
                        <div class="card-body">
                            <div class="row">

                                <div class="col">

                                    <div class="form-group">
                                        <p><b>Name:</b></p> 
                                        <p><?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] ?>   </p>       
                                    </div>

                                    <div class="form-group">
                                        <p><b>Email:</b></p> 
                                        <p><?php echo $_SESSION['email'] ?>     </p>  
                                    </div>
                                    <div class="form-group">
                                        <p><b>Contact:</b></p>  
                                        <p><?php echo $_SESSION['contact'] ?>   </p>         
                                    </div>
                                    <div class="form-group">
                                        <p><b>Address:</b></p>  
                                        <p><?php echo $_SESSION['address'] ?>   </p>         
                                    </div>
                                    <div>
                                        <button onclick="window.location.href='updateprofile.php'" type='button' class='btn button_forms btn-info'>Update My Profile</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>  
        </div>
        <?php
        include "footer.php";
        ?>
    </body>
</html>