<?php

require 'dbconfig.php';
include 'sessiontest.php';
include 'memberTraverseSecurity.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$success = true;
//send verification e-mail:
$to = ($_SESSION['email']);
$email = $_SESSION['email'];
$vkey = md5(time() . $_SESSION['email']);
resend();
if ($success) {
    $subject = "Floured E-mail Verification!";
//    $url = "localhost:8000/verify.php?vkey=$vkey";
$url = "http://54.145.106.172/1004Project/verify.php?vkey=$vkey";
    $message = '<p>Thank you for registering with Floured!. The link to verify your e-mail is below. If you did not make this request, you can ignore this email</p>';
    $message .= '<p>Here is your e-mail verification link: </br>';

    $message .= '<a href="' . $url . '">' . $url . '</a></p>';



    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPAuth = true;
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

    header("Location: settings.php?sent=success");
} else {
    header("Location: settings.php?sent=nosuccess");
}

function resend() {
    global $email, $vkey, $success;
    $conn = OpenCon();
// Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
// Prepare the statement:
// Bind & execute the query statements           
        $stmt = $conn->prepare("UPDATE fmembers SET vkey='$vkey' WHERE email='$email'");
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

?>