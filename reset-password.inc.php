<?php
if (isset($_POST["reset-password-submit"])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];
    $success = true;
    $pcerrorMsg = "";

    if (empty($password) || empty($passwordRepeat)) {
        header("Location: register.php");
        exit();
    } else if ($password != $passwordRepeat) {
        $success = false;
        $pcerrorMsg = 'Passwords do not Match!<br>';
    }

    $currentDate = date("U");

    require 'dbconfig.php';
    $conn = OpenCon();
    if ($success) {
        $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= $currentDate";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
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
                        <h1 class='section_heading' style='text-align:center'>Caked!</h1>
                        <br>
                        <h2 style='text-align:center'>Something went wrong!</h2>
                        <p style='text-align:center'>There was a connection error. Please try again later.</p>
                        <button class='btn btn-info button_forms btn-block' onclick="window.location.href = 'login.php'" >Acknowledge</button>
                    </main>   
                    <?php
                    include 'footer.php';
                    ?>
                    <br>
                </body>


            </html>
            <?php
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $selector);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if (!$row = mysqli_fetch_assoc($result)) {
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
                            <h1 class='section_heading' style='text-align:center'>Caked!</h1>
                            <br>
                            <h2 style='text-align:center'>Something went wrong!</h2>
                            <p style='text-align:center'>Your request may be expired. Please resubmit your request.</p>
                            <button class='btn btn-info button_forms btn-block' onclick="window.location.href = 'login.php'" >Acknowledge</button>
                        </main>  
                        <?php
                        include 'footer.php';
                        ?>
                        <br>
                    </body>


                </html>
                <?php
                exit();
            } else {

                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

                if ($tokenCheck === false) {
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
                                <h1 class='section_heading' style='text-align:center'>Caked!</h1>
                                <br>
                                <h2 style='text-align:center'>Something went wrong!</h2>
                                <p style='text-align:center'>Your request may be expired. Please resubmit your request.</p>
                                <button class='btn btn-info button_forms btn-block' onclick="window.location.href = 'login.php'" >Acknowledge</button>
                            </main>  
                            <?php
                            include 'footer.php';
                            ?>
                            <br>
                        </body>


                    </html>
                    <?php
                    exit();
                } else if ($tokenCheck === true) {
                    $tokenEmail = $row['pwdResetEmail'];

                    $sql = "SELECT * FROM fmembers WHERE email=?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
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
                                    <h1 class='section_heading' style='text-align:center'>Caked!</h1>
                                    <br>
                                    <h2 style='text-align:center'>Something went wrong!</h2>
                                    <p style='text-align:center'>The account that sent the request is no longer associated with us.</p>
                                    <button class='btn btn-info button_forms btn-block' onclick="window.location.href = 'login.php'" >Acknowledge</button>
                                </main>  
                                <?php
                                include 'footer.php';
                                ?>
                                <br>
                            </body>
                        </html>
                        <?php
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if (!$row = mysqli_fetch_assoc($result)) {
                            echo "YThere was an error!.";
                            exit();
                        } else {
                            $sql = "UPDATE fmembers SET password=? WHERE email=?";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "There was an error!";
                                exit();
                            } else {
                                $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                                mysqli_stmt_execute($stmt);

                                $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                                $stmt = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    echo "There was an error!";
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: login.php?newpwd=passwordupdated");
                                }
                            }
                        }
                    }
                }
            }
        }
    } else if (!$success) {
        ?>
        <!DOCTYPE html>
        <html lang = "en">
            <head>
                <?php
                include 'header.php';
                ?>
                <title>Floured Unsuccessful</title>
            </head>
            <body>
                <?php include "navbar.php"; ?>
                <main class="container"> <?php
                    echo "<br>";
                    echo "<h1 class='section_heading' style='text-align:center'>CAKED!</h1>";
                    echo "<br>";
                    echo "<h2 style='text-align:center'>" . $pcerrorMsg . "</h2>";
                    echo "<br>";
                    echo "<div class='form-group'>";
                    echo "<button onclick='history.back()' type='button' class='btn button_forms btn-info btn-block'>Go Back</button>";
                    echo "</div>";
                    echo "<br>";
                    ?>
                </main>
                <?php
                include 'footer.php';
                ?>
            </body>
        </html>
        <?php
    }
} else {
    header("Location: index.php");
}   

