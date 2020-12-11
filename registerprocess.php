<?php
include 'sessiontest.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
?>
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
                $role = "";
                $gender = $gendererrorMsg = "";
                $pwd = $pwderrorMsg = "";
                $pwd_confirm = $pcerrorMsg = "";
                $lnamesuccess = true;
                $contactsuccess = true;
                $addresssuccess = true;
                $pwdsuccess = true;
                $pcsuccess = true;
                $emailsuccess = true;
                $gendersuccess = true;
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
                        $fnameerrorMsg .= "Invalid first name characters<br>";
                        $fnamesuccess = false;
                    }
                }

                if (empty($_POST["gender"])) {
                    $gendererrorMsg .= "Gender is required.<br>";
                    $gendersuccess = false;
                } else {
                    $gender = sanitize_input($_POST["gender"]);
                    if (!filter_var($gender, FILTER_SANITIZE_STRING)) {
                        $gendererrorMsg .= "Invalid Gender characters<br>";
                        $gendersuccess = false;
                    }
                }

                if (empty($_POST["contact"])) {
                    $contacterrorMsg .= "contact is required.<br>";
                    $contactsuccess = false;
                } else {
                    $contact = sanitize_input($_POST["contact"]);
                    if (!filter_var($contact, FILTER_SANITIZE_STRING)) {
                        $contacterrorMsg .= "Invalid contact characters<br>";
                        $contactsuccess = false;
                    }
                }

                if (empty($_POST["lname"])) {
                    $lnameerrorMsg .= "Last Name is required.<br>";
                    $lnamesuccess = false;
                } else {
                    $lname = sanitize_input($_POST["lname"]);
                    if (!filter_var($lname, FILTER_SANITIZE_STRING)) {
                        $lnameerrorMsg .= "Invalid last name characters.<br>";
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



                if (empty($_POST["pwd"])) {
                    $pwderrorMsg .= "Password is required.<br>";
                    $pwdsuccess = false;
                } else {
                    $pwd = $_POST["pwd"];
                }
                if (empty($_POST["pwd_confirm"])) {
                    $pcerrorMsg .= "Confirm Password is required.<br>";
                    $pcsuccess = false;
                } else {
                    // Remove HTML tags from string

                    $pwd_confirm = $_POST["pwd_confirm"];
                }

                if (empty($_POST["email"])) {
                    $emailerrorMsg .= "Email is required.<br>";
                    $emailsuccess = false;
                } else {
                    $email = sanitize_input($_POST["email"]);
                    $vkey = md5(time() . $email);
// Additional check to make sure e-mail address is well-formed.
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emailerrorMsg .= "Invalid email format.<br>";
                        $emailsuccess = false;
                    }
                }
                if ($pwd !== $pwd_confirm) {
                    $pwdsuccess = False;
                    $pcsuccess = False;
                    $pcerrorMsg = 'Passwords do not Match!<br>';
                } else {
                    $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
                }

                // check for database
                if ($contactsuccess && $addresssuccess && $emailsuccess && $fnamesuccess && $lnamesuccess && $pwdsuccess && $pcsuccess && $gendersuccess) {
                    saveMemberToDB();
                }

                if ($contactsuccess && $addresssuccess && $emailsuccess && $lnamesuccess && $fnamesuccess && $pwdsuccess && $pcsuccess && $success && $gendersuccess) {

                    //send verification e-mail:
                    $to = $email;
                    $subject = "Floured E-mail Verification!";
//                    $url = "localhost:8000/verify.php?vkey=$vkey";
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


                    echo "<br>";
                    echo "<h1 class='section_heading' style='text-align:center'>Registration is successful!</h1>";
                    echo "<br>";
                    echo "<h2 style='text-align:center'>Amazing cakes await you!, $fname $lname</h2>";
                    echo "<p style='text-align:center'>Verify your account to allow e-mail based functions!</p>";
                    echo "<br>";
                    echo "<div class='form-group'>";
                    if (isset($_SESSION['role'])) {
                        if ($_SESSION['role'] == 'Admin') {
                            ?> <button class='btn btn-info button_forms btn-block' onclick="window.location.href = 'manageuser.php'"  >Return to manage Users</button>
                            <?php
                        }
                    } else {
                        ?> <button class='btn btn-info button_forms btn-block' onclick="window.location.href = 'login.php'" >Login Now!</button>
                                <?php
                            }

                            echo "</div>";
                        } else {
                            echo "<br>";
                            echo "<h1 class='section_heading' style='text-align:center'>CAKED!</h1>";
                            echo "<br>";
                            echo "<h2 style='text-align:center'>The following input errors were detected:</h2>";
                            echo "<p style='text-align:center'>" . $emailerrorMsg . $fnameerrorMsg . $addresserrorMsg . $contacterrorMsg . $lnameerrorMsg . $pwderrorMsg . $pcerrorMsg . $gendererrorMsg . $errorMsg . "</p>";
                            echo "<div class='form-group'>";
                            echo "<button onclick='history.back()' type='button' class='btn btn-info button_forms btn-block'  type='button'>Return to Sign Up</button>";
                            echo "</div>";
                        }

//Helper function that checks input for malicious or unwanted content.
                        function sanitize_input($data) {
                            $data = trim($data);
                            $data = stripslashes($data);
                            $data = htmlspecialchars($data);
                            return $data;
                        }

                        /*
                         * Helper function to write the member data to the DB
                         */

                        function saveMemberToDB() {
                            global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success, $address, $contact, $role, $gender, $vkey;
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
                                $stmt = $conn->prepare("INSERT INTO fmembers (fname, lname, email, password, address, contact, role, gender, vkey) VALUES (?,?,?,?,?,?,?,?,?)");
                                $stmt->bind_param('sssssisss', $fname, $lname, $email, $pwd_hashed, $address, $contact, $role, $gender, $vkey);
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



