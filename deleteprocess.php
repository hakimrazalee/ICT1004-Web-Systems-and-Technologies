<?php
include 'sessiontest.php';
include 'memberTraverseSecurity.php';
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
        if ($_SESSION['role'] == "Admin") {
            include 'navbar.php';
        }
        ?>
        <main class="container">
            <div>
                <?php
                $email = $emailerrorMsg = "";
                $userid = $useriderrorMsg = "";
                $success = false;
                if ($_SESSION['role'] == "Admin") {
                    if (empty($_POST["userid"])) {
                        if (empty($_POST["email"])) {
                            $emailerrorMsg .= "Please enter the E-mail address or User ID of the member you wish to remove.";
                        } else {
                            $email = sanitize_input($_POST["email"]);
                            $success = true;
// Additional check to make sure e-mail address is well-formed.
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $emailerrorMsg .= "Invalid email format.<br>";
                                $success = false;
                            }
                        }
                    } else {
                        $userid = sanitize_input($_POST["userid"]);
                        $success = true;
                        if (!filter_var($userid, FILTER_SANITIZE_STRING)) {
                            $useriderrorMsg .= "Invalid contact characters";
                            $success = false;
                        }
                    }
                } else if ($_SESSION['role'] == "Member") {
                    if (empty($_POST["confirmdelete"])) {
                        $emailerrorMsg .= "Please enter 'Yes' if you wish to delete your account.";
                        $success = false;
                    } else {
                        $check = sanitize_input($_POST["confirmdelete"]);
                        if ($check == "yes" || $check == "Yes") {
                            $userid = $_SESSION['memberID'];
                            $success = true;
                        } else {
                            $emailerrorMsg .= "You did not confirm your account deletion.";
                            $success = false;
                        }
                    }
                }




                if ($success) {
                    deletefromdb();
                }
                if ($success) {
                    if ($_SESSION['role'] == "Member") {
                        session_destroy();
                        include 'navbar.php';
                    }
                    ?>
                    <br>
                    <h1 class='section_heading' style='text-align:center'>User has been removed!</h1>
                    <br>
                    <h2 style='text-align:center'>Goodbye!</h2>
                    <br>
                    <div class='form-group'><?php if ($_SESSION['role'] == "Admin") { ?>
                            <button type="button" onclick="window.location.href = 'manageuser.php'" class="btn button_forms btn-info btn-block">Return to Manage Users</button></div>
                    <?php } else { ?>
                        <button type="button" onclick="window.location.href = 'index.php'" class="btn button_forms btn-info btn-block">Redirect me to home!</button></div>

                <?php } ?>

                <?php
            } else {
                include 'navbar.php';
                echo "<br>";
                echo "<h1 class='section_heading' style='text-align:center'>CAKED!</h1>";
                echo "<h2 style='text-align:center'>The following input errors were detected:</h2>";
                echo "<br>";
                echo "<p style='text-align:center'>" . $emailerrorMsg . $useriderrorMsg . "</p>";
                echo "<br>";
                echo "<div class='form-group'>";
                echo "<br>";
                echo "<button onclick='history.back()' type='button' class='btn button_forms btn-block btn-info'>Go Back</button>";
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

            function deletefromdb() {
                global $email, $userid;
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
                    $stmt = $conn->prepare("SELECT * FROM fmembers WHERE memberID=? OR email=? ");
// Bind & execute the query statement:
                    $stmt->bind_param("is", $userid, $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $stmt = $conn->prepare("DELETE FROM fmembers WHERE memberID=? OR email=?");
                        $stmt->bind_param('is', $userid, $email);
                        if (!$stmt->execute()) {
                            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                            $success = false;
                        }
                    } else if ($result->num_rows == 0){
                        $errorMsg = "There is no such user: (" . $stmt->errno . ") " . $stmt->error;
                        $success = false;
                    }

                    $stmt->close();
                }
                $conn->close();
            }
            ?>
    </main>
    <?php
    include "footer.php";
    ?>
</body>
</html>



