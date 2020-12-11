<?php
include 'sessiontest.php';
if (isset($_SESSION['fname'])) {
    header('Location: profile.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Floured - Login</title>
        <?php
        include 'header.php';
        
        ?>

    </head>
    <body>
        <?php include 'navbar.php';?>
        <br>
        <br>
        <main class="container">        
            <h1 class="section_heading" style="margin-bottom:0px;">Member Login</h1>
            <p class="subtext" style="color: black"> 
                For new members, head to the <a style="color: black" href="register.php"><strong>Registration</strong></a> page to start your cake journey!        
            </p>        
            <form action="loginprocess.php" method="post">            
                <div class="form-group">
                    <label for="email">Email:</label>            
                    <input class="form-control" type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"                 
                           required placeholder="Enter email">            
                </div>
                <div class="form-group ">
                    <label for="pwd">Password:</label>            
                    <input class="form-control" type="password" id="pwd"                   
                           required name="pwd" placeholder="Enter password">             
                </div>
                <div>
                    <button class="btn button_forms btn-info " type="submit">Submit</button>   
                </div>
                <div >
                    <br>
                    <?php
                    if (isset($_GET["newpwd"])) {
                        if ($_GET["newpwd"] == "passwordupdated") {
                            ?>
                            <h2 style="color: green;">Your password has been reset!</h2>
                            <?php
                        }
                    }
                    ?>
                    <a style="color: black" href ="reset-password.php"><strong>Forgot your password?</strong></a>
                </div>
                <br>
                <br>

            </form>    
        </main>    

        <?php
        include "footer.php";
        ?>
    </body>
</html>
