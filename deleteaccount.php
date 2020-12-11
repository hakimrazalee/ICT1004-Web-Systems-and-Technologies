<?php
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
        <?php include 'navbar.php'; ?>
        <main>
        <?php
//        include 'navbar.php';
        ?>
            <div class="container">
                <br>
                <h1 class="section_heading" style="text-align: center">Are you sure you wish to delete your account?</h1>
                <h2 style="text-align: center">We hate to see you go!</h2>
                <br>
                <p style="text-align: center">Type "Yes" and click on the Confirm button below to confirm your deletion.</p>
                <form action="deleteprocess.php" method="post"> 

                    <div class="form-group">
                        <label for="confirmdelete">Confirm Deletion of Account:</label>            
                        <input class="form-control" type="text" id="confirmdelete" name="confirmdelete" pattern="[A-Za-z]{3}" title="Please input 'yes' if you wish to confirm."                  
                               placeholder="Type 'yes' to confirm your deletion">            
                    </div>
                    <br>
                    <div>
                        <button class="btn button_forms btn-info btn-block" type="submit">Confirm</button>   
                    </div>
                    <br>
                </form>

            </div>
        </main>
<?php
include 'footer.php';
?>
    </body>

</html>
