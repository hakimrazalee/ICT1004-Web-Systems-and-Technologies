<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require "dbconfig.php";
if (isset($_POST["reset-request-submit"])) {
    $conn = OpenCon();
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $errorMsg = "";

    //$url = "localhost:8000/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $url = "http://54.145.106.172/1004Project/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;
    $success = true;
    if (empty($_POST["email"])) {
        $errorMsg .= "Email is required.<br>";
        $success = false;
    } else {
        $userEmail = sanitize_input($_POST["email"]);
// Additional check to make sure e-mail address is well-formed.
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format.<br>";
            $success = false;
        }
    }



    if ($success) {

        $stmt = $conn->prepare("SELECT * FROM fmembers WHERE email=?");
// Bind & execute the query statement:
        $stmt->bind_param("s", $userEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['verified'] == 1) {
                $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "There was an error!";
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $userEmail);
                    mysqli_stmt_execute($stmt);
                }

                $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "There was an Insert error!";
                    exit();
                } else {
                    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
                    mysqli_stmt_execute($stmt);
                }

                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                $to = $userEmail;

                $subject = 'Reset your password for Floured!';

                $message = '<p>We recieved a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email</p>';
                $message .= '<p>Here is your password reset link: </br>';
                $message .= '<a href="' . $url . '">' . $url . '</a></p>';

                $headers = "From: Floured <floured1004@gmail.com>\r\n";
                $headers .= "Reply-To: floured1004@gmail.com\r\n";
                $headers .= "Content-type: text/html\r\n";

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Mailer = "smtp";
                $mail->SMTPAuth = true;
                $mail->SMTPDebug = 1;
                $mail->SMTPSecure = 'tls';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = '587';
                $mail->isHTML();
                $mail->Username = 'floured1004@gmail.com';
                $mail->Password = 'ICT1004ICT1004';
                $mail->SetFrom("floured1004@gmail.com");
                $mail->Subject = $subject;
                $mail->Body = $message;
                $mail->AddAddress($to);

                $mail->Send();

                header("Location: reset-password.php?reset=success");
            } else if ($row['verified'] == 0) {
                header("Location: reset-password.php?reset=unverified");
            }
        } else {
            header("Location: reset-password.php?reset=unknown");
        }
    } else if ($success === false) {
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
                <br>
                <br>
                <main class="container">  
                    <h1 class='section_heading' style='text-align:center'>Error:</h1>
                    <br>
                    <h3 style='text-align:center'><?php echo $errorMsg; ?></h3>
                    <br>
                    <button type="button" onclick="goBack()" class="btn btn-info btn-lg btn-block">Return to Previous Page</button>
                </main>
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
            </body>
            <br>
            <?php
            include 'footer.php';
            ?>
        </html>
        <?php
    }
} else {
    header("Location: index.php");
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function checkEmail($email) {
    
}
