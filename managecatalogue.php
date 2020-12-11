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
        <title>Floured - Manage Items</title>
    </head>
    <body>
        <?php
        include 'navbar.php';
        ?>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">Manage Items</h1>
                <p class="lead">Navigate using the buttons below.</p>

                <button type="button" onclick="window.location.href = 'm.additem.php'" class="btn button_forms btn-info btn-block">Add New Item</button>

                <button type="button" onclick="window.location.href = 'm.itemupdate.php'" class="btn button_forms btn-info btn-block">Update/Remove Item Information</button>

            </div>
        </div>

    </body>
    <?php
    include 'footer.php';
    ?>
</html>
