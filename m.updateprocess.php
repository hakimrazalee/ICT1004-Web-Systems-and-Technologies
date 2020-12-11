<?php
include 'sessiontest.php';
include 'memberTraverseSecurity.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php
        require 'dbconfig.php';
        include 'header.php';
        ?>
        <title>Floured</title>
    </head>
    <body>
        <?php
        include 'navbar.php';
        ?>
        <main class="container">
            <div>
                <?php
                $email = $emailerrorMsg = "";
                $lname = $lnameerrorMsg = "";
                $fname = $fnameerrorMsg = "";
                $address = $addresserrorMsg = "";
                $contact = $contacterrorMsg = "";
                $gender = $gendererrorMsg = "";
                $role = "";
                $flag = 0;

                $lnamesuccess = true;
                $contactsuccess = true;
                $addresssuccess = true;
                $gendersuccess = true;

                $emailsuccess = true;
                $fnamesuccess = true;
                $success = true;
                $pwd_hashed = '';
                $errorMsg = '';


                if (empty($_POST["fname"])) {
                    $fnameerrorMsg .= "First name is required.<br>";
                    $fnamesuccess = false;
                } else {
                    $fname = sanitize_input($_POST["fname"]);
                    if (!filter_var($fname, FILTER_SANITIZE_STRING)) {
                        $fnameerrorMsg .= "Invalid first name characters";
                        $fnamesuccess = false;
                    }
                }

                if (empty($_POST["gender"])) {
                    $gendererrorMsg .= "Gender is required.<br>";
                    $gendersuccess = false;
                } else {
                    $gender = sanitize_input($_POST["gender"]);
                    if (!filter_var($gender, FILTER_SANITIZE_STRING)) {
                        $gendererrorMsg .= "Invalid Gender characters";
                        $gendersuccess = false;
                    }
                }

                if (empty($_POST["contact"])) {
                    $contacterrorMsg .= "contact is required.<br>";
                    $contactsuccess = false;
                } else {
                    $contact = sanitize_input($_POST["contact"]);
                    if (!filter_var($contact, FILTER_SANITIZE_STRING)) {
                        $contacterrorMsg .= "Invalid contact characters";
                        $contactsuccess = false;
                    }
                }

                if (empty($_POST["lname"])) {
                    $lnameerrorMsg .= "Last Name is required.<br>";
                    $lnamesuccess = false;
                } else {
                    $lname = sanitize_input($_POST["lname"]);
                    if (!filter_var($lname, FILTER_SANITIZE_STRING)) {
                        $lnameerrorMsg .= "Invalid last name characters";
                        $lnamesuccess = false;
                    }
                }

                if (empty($_POST["address"])) {
                    $addresserrorMsg .= "Last Name is required.<br>";
                    $addresssuccess = false;
                } else {
                    $address = sanitize_input($_POST["address"]);
                    if (!filter_var($address, FILTER_SANITIZE_STRING)) {
                        $addresserrorMsg .= "Invalid last name characters";
                        $addresssuccess = false;
                    }
                }

                if (empty($_POST["role"])) {
                    $role = "Member";
                } else {
                    $role = sanitize_input($_POST["role"]);
                }



                if (empty($_POST["email"])) {
                    $emailerrorMsg .= "Email is required.<br>";
                    $emailsuccess = false;
                } else {
                    $email = sanitize_input($_POST["email"]);
// Additional check to make sure e-mail address is well-formed.
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emailerrorMsg .= "Invalid email format.<br>";
                        $emailsuccess = false;
                    }
                }

                if (empty($_POST["role"])) {
                    $role = "Member";
                } else {
                    $role = sanitize_input($_POST["role"]);
                }

                if ($_SESSION['role'] == "Admin") {
                    $id = $_SESSION['updatekey'];
                    $verified = $_SESSION['userverified'];
                    $userEmail = $_SESSION['useremail'];
                    if ($userEmail != $email) {
                        $verified = 0;
                        $flag = 1;
                    }
                } else {
                    $id = $_SESSION['memberID'];
                    $verified = $_SESSION['verified'];
                    if ($_SESSION['email'] != $email) {
                        $verified = 0;
                        $flag = 1;
                    }
                }
                // check for database
                if ($contactsuccess && $addresssuccess && $emailsuccess && $fnamesuccess && $lnamesuccess && $gendersuccess) {
                    updateMemberToDB();
                }
                if ($success) {
                    if ($flag == 1) {
                        $to = $email;
                        $email = $email;
                        $vkey = md5(time() . $email);
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
                        }
                    }
                }
                    if ($contactsuccess && $addresssuccess && $emailsuccess && $lnamesuccess && $fnamesuccess && $success && $gendersuccess) {

                        if ($_SESSION['role'] == 'Member') {
                            $_SESSION['fname'] = $fname;
                            $_SESSION['lname'] = $lname;
                            $_SESSION['role'] = $role;
                            $_SESSION['contact'] = $contact;
                            $_SESSION['email'] = $email;
                            $_SESSION['address'] = $address;
                            $_SESSION['gender'] = $gender;

                            echo "<br>";
                            echo "<h1 class='section_heading' style='text-align:center'>Your Profile is Successfully Updated!</h1>";
                            echo "<br>";
                            echo "<h2 style='text-align:center'>Account with email: $email, has been updated</h2>";
                            echo "<br>";
                            echo "<div class='form-group'>";
                            ?> <button class='btn btn-info button_forms btn-block' onclick="window.location.href = 'index.php'">Redirect me to home!</button>

                            <?php
                            echo "</div>";
                            echo "<br>";
                        } else {
                            echo "<br>";
                            echo "<h1 class='section_heading' style='text-align:center'>Profile is Successfully Updated!</h1>";
                            echo "<br>";
                            echo "<h2 style='text-align:center'>Account with email: $email, has been updated</h2>";
                            echo "<br>";
                            echo "<div class='form-group'>";
                            ?> <button class='btn btn-info button_forms btn-block' onclick="window.location.href = 'manageuser.php'">Go back</button>

                            <?php
                            echo "</div>";
                            echo "<br>";
                        }
                    } else {
                        echo "<br>";
                        echo "<h1 class='section_heading' style='text-align:center'>Oops!</h1>";
                        echo "<br>";
                        echo "<h2 style='text-align:center'>The following input errors were detected:</h2>";
                        echo "<p style='text-align:center'>" . $emailerrorMsg . $fnameerrorMsg . $addresserrorMsg . $contacterrorMsg . $lnameerrorMsg . $errorMsg . $gendererrorMsg . "</p>";
                        echo "<div class='form-group'>";
                        echo "<button onclick='history.back()' type='button' class='btn btn-info button_forms btn-block'>Go Back</button>";
                        echo "</div>";
                    }

//Helper function that checks input for malicious or unwanted content.
                    function sanitize_input($data) {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
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

                    function updateMemberToDB() {
                        global $role, $fname, $lname, $email, $errorMsg, $success, $address, $contact, $id, $gender, $verified;
// Create database connection.
                        //$config = parse_ini_file('../../private/db-config.ini');
                        // $conn = new mysqli($config['servername'], $config['username'],
                        //        $config['password'], $config['dbname']);
                        $conn = OpenCon();
// Check connection
                        if ($conn->connect_error) {
                            $errorMsg = "Connection failed: " . $conn->connect_error;
                            $success = false;
                        } else {
// Prepare the statement:   
// Bind & execute the query statements           
                            $stmt = $conn->prepare("UPDATE fmembers SET fname='$fname', lname='$lname', email='$email', address='$address', contact='$contact', role='$role', gender='$gender', verified='$verified' WHERE memberID='$id'");
//                        $stmt->bind_param('sssssii', $fname, $lname, $email, $pwd_hashed, $address, $contact, $id);

                            if (!$stmt->execute()) {
                                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                                $success = false;
                            }


                            $stmt->close();
                        }
                        $conn->close();
                    }
                    ?>
                </div>
            </main>
            <?php
            include "footer.php";
            ?>
    </body>
</html>



