<?php
include 'sessiontest.php';
require "dbconfig.php";
if (isset($_GET['vkey'])) {
    $vkey = $_GET['vkey'];

    $conn = OpenCon();
    $result = $conn->query("SELECT vkey, verified FROM fmembers WHERE verified=0 AND vkey='$vkey'");
    if ($result->num_rows > 0) {
        $update = $conn->query("UPDATE fmembers SET verified = 1 WHERE vkey='$vkey' LIMIT 1");

        if ($update) {
            if (isset($_SESSION['role'])) {
                session_destroy();
            }
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
                        <div class="jumbotron jumbotron-fluid">
                            <div class="container">
                                <h1 class='section_heading' style='text-align:center'>Congratulations!</h1>
                                <br>
                                <h2 style='text-align:center'>Your account has been verified!</h2>
                                <button class='btn btn-info button_forms btn-block' onclick="window.location.href = 'login.php'" >Login Now!</button>
                            </div>
                        </div>
                    </main>
                    <?php
                include 'footer.php';
                ?>
                </body>
                
            </html>

            <?php
        } else {
            echo $mysqli->error;
        }
    } else {
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
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <h1 class='section_heading' style='text-align:center'>Caked!</h1>
                            <br>
                            <h2 style='text-align:center'>Something went wrong!</h2>
                            <p style='text-align:center'>Your account has already been verified or your request is invalid. Resend your verification request.</p>
                            <button class='btn btn-info button_forms btn-block' onclick="window.location.href = 'login.php'" >Login Now!</button>
                        </div>
                    </div>
                </main>
                <?php
                include 'footer.php';
                ?>
            </body>

        </html>
        <?php
    }
} else {
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
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <h1 class='section_heading' style='text-align:center'>Caked!</h1>
                        <br>
                        <h2 style='text-align:center'>Something went wrong!</h2>
                        <p style='text-align:center'>Your account has already been verified or your request is invalid. Resend your verification request.</p>
                        <button class='btn btn-info button_forms btn-block' onclick="window.location.href = 'login.php'" >Login Now!</button>
                    </div>
                </div>
            </main>
            <?php
            include 'footer.php';
            ?>
        </body>

    </html>
    <?php
}    