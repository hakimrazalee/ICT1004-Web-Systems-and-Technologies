<?php
include 'sessiontest.php';
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
        <br>
        <main class="container"> 
            <br>
            <h1 class='section_heading'>Password Reset</h1>
            <p> 
                An e-mail will be sent to you with instructions on how to reset your password.        
            </p>        
            <form action="reset-request.inc.php" method="post">            
                <div class="form-group">
                    <label for="email"><b>Email:</b></label>            
                    <input class="form-control" type="text" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"                  
                           required name="email" placeholder="Enter your e-mail adress">   
                </div>
                <div>
                    <button class="btn btn-info button_forms" name="reset-request-submit" type="submit">Receive new password by e-mail</button>   
                </div>
                <br>
            </form>   
            <?php
            if (isset($_GET["reset"])) {
                if ($_GET["reset"] == "success") {
                    echo '<p style="color:green;" >E-mail has been successfully sent!</p>';
                } else if ($_GET["reset"] == "unknown") {
                    echo '<p style="color:red;">There is no account associated with that e-mail!</p>';
                } else if ($_GET["reset"] == "unverified") {
                    echo '<p style="color:red;">This e-mail is not verified!</p>';
                }
            }
            ?>
            <br>
            <br>
        </main>  
        <?php
        include 'footer.php';
        ?>
    </body>

</html>
