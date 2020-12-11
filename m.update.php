<?php
include 'sessiontest.php';
include 'adminTraverseSecurity.php';
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <?php
        include 'header.php';
        ?>
        <title>Floured - Manager Update</title>
    </head>
    <body>
        <?php
        include 'navbar.php';
        ?>
        <br>
        <main class="container">
            <h1 class="section_heading" style="text-align: center">Update Member Information</h1>
            <br>
            <form action="m.updateKeyed.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" id="email"
                           name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Enter email">
                </div>
                <br>
                <h2 class="section_heading" style="text-align: center">OR</h2>
                <br>
                <div class="form-group">
                    <label for="userid">User ID:</label>
                    <input class="form-control" type="text" id="userid"
                           name="userid" pattern="[0-9]{,8}" title="number characters only!" placeholder="Enter User ID">
                </div>

                <br>
                <div class="form-group">
                    <button class="btn btn-info button_forms btn-block" type="submit">Submit</button>
                </div>
            </form>
        </main>
        <?php
        include 'footer.php';
        ?>
    </body>

</html>
