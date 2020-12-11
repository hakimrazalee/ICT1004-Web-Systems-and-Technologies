<?php
include 'sessiontest.php';
include 'memberTraverseSecurity.php';
?>
<!DOCTYPE html>
<html lang = "en">
    <head> 
        <?php
        include "header.php";
        ?>
        <style>

            .responsive {
                width: 100%;
                /*  max-width: 400px;*/
                height: auto;
            }


            #complexity {
                padding: 0;
                text-align: center;
                top: 0;
                width: 122px;
                z-index: 10;
            }

            #complexity_side {
                padding: 0; 
                vertical-align: top;
            }
        </style>
        <title>Floured - Update Profile</title>

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
                <h1 class='section_heading' style="text-align: center">Update Profile:</h1>
                <br>
                <div class ="card mb-3" >

                    <div class="row no-gutters">
                        <?php if ($_SESSION['gender'] == 'Male') { ?>
                            <img src="images/img_avatar.png" style="width: 500px" class="card-img-top" alt="profileimg"/>
                        <?php } else if ($_SESSION['gender'] == 'Female') { ?>
                            <img src="images/img_avatar2.png" style="width: 500px" class="card-img-top" alt="profileimg"/>
                        <?php } ?>
                        <div class="card-body">
                            <form action="m.updateprocess.php" method="post">  
                                <div class="row">

                                    <div class="col">

                                        <div class="form-group">
                                            <label for="fname">First Name:</label>            
                                            <input class="form-control" type="text" id="fname" required name="fname" pattern="[A-Za-z]{2,45}" title="2-45 Alphabetical Characters Only."                   
                                                   placeholder="Enter first name" value="<?php echo $_SESSION['fname'] ?>">            
                                        </div>
                                        <div class="form-group">
                                            <label for="lname">Last Name:</label>             
                                            <input class="form-control" type="text" id="lname" pattern="[A-Za-z]{2,45}" title="2-45 Alphabetical Characters Only."                   
                                                   required name="lname" placeholder="Enter last name" value="<?php echo $_SESSION['lname'] ?>">             
                                        </div>
                                        <div class="form-group">
                                            <p>Please select your gender:</p>
                                            <?php if ($_SESSION['gender'] == 'Male') { ?>
                                                <input type="radio" id="male" name="gender" checked value="Male">
                                                <label for="male">Male</label><br>
                                                <input type="radio" id="female" name="gender" value="Female">
                                                <label for="female">Female</label><br>
                                            <?php } else if ($_SESSION['gender'] == 'Female') { ?>
                                                <input type="radio" id="male" name="gender" value="Male">
                                                <label for="male">Male</label><br>
                                                <input type="radio" id="female" name="gender" checked value="Female">
                                                <label for="female">Female</label><br>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="email">Email:</label>   
                                            <input class="form-control" type="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"                  
                                                   required name="email" placeholder="Enter email" value="<?php echo $_SESSION['email'] ?>">            
                                        </div>
                                        <div class="form-group">
                                            <label for="contact">Contact:</label>            
                                            <input class="form-control" type="tel" id="contact" name="contact"                   
                                                   required pattern="[0-9]{8}" title="8 number characters only!" placeholder="Enter contact" value="<?php echo $_SESSION['contact'] ?>">            
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address:</label>   
                                            <input type="hidden" name="roleDefault" value="Member">
                                            <input class="form-control" type="text" id="address"                 
                                                   required name="address" placeholder="Enter address" value="<?php echo $_SESSION['address'] ?>">            
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check">
                                </div>
                                <br>
                                <div>
                                    <strong>Warning: Changing your email WILL reset your verification status.</strong>
                                    <br>
                                    <br>
                                    <button class="btn button_forms btn-info" type="submit">Save Changes</button>   
                                </div>
                            </form>    
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