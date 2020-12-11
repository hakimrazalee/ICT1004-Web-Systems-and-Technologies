<?php
include 'sessiontest.php';
include 'memberTraverseSecurity.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'header.php';
        ?>
        <title>Floured</title>
    </head>
    <body>
        <main>
        <?php
        include 'navbar.php';
        ?>
        
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">User Settings</h1>
                <p class="lead">Account Management.</p>

                <button type="button" onclick="window.location.href = 'passwordchange.php'" class="btn button_forms btn-info btn-lg btn-block">Change Password</button>
                <button type="button" onclick="window.location.href = 'deleteaccount.php'" class="btn button_forms btn-info btn-lg btn-block">Deactivate Account</button>
                <?php if ($_SESSION['verified'] == 0) { ?>
                    <button type="button" onclick="window.location.href = 'resendv.php'" class="btn btn-info button_forms btn-lg btn-block">Resend E-mail Verification</button>
                    <?php
                }
                if (isset($_GET["sent"])) {
                    if ($_GET["sent"] == "success") {
                        echo '<h2 style="color: green;">Verification E-mail has been sent!</h2>';
                    } else if ($_GET["sent"] == "nosuccess") {
                        echo '<h2 style="color: red;">Your request is unsuccessful.</h2>';
                    }
                }
                ?>


            </div>
        </div>
        </main>
        <?php
    include 'footer.php';
    ?>
    </body>

    
</html>
