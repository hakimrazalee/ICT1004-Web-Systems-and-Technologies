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
        include 'navbar.php';
        ?>
        <main class="container">
            <div>
                <?php
                $id = $_SESSION['memberID'];

                $pwd = $pwderrorMsg = "";
                $pwd_old = "";
                $pwd_confirm = $pcerrorMsg = "";
                $pwdolderrorMsg = "";
                $pwdsuccess = true;
                $pwdoldsuccess = true;
                $pcsuccess = true;
                $success = true;
                $pwd_hashed = '';
                $pwd_check = '';
                $errorMsg = '';

                if (empty($_POST["pwd_old"])) {
                    $pwdolderrorMsgerrorMsg .= "Old Password is required.<br>";
                    $pwdoldsuccess = false;
                } else {
                    $pwd_old = $_POST["pwd_old"];
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

                if ($pwd !== $pwd_confirm) {
                    $pwdsuccess = False;
                    $pcsuccess = False;
                    $pcerrorMsg = 'Passwords do not Match!';
                } else {
                    $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
                }

                // check for database
                if ($pwdsuccess && $pcsuccess && $pwdoldsuccess) {
                    authenticateUser();
                }

                if ($pwdsuccess && $pcsuccess && $pwdoldsuccess && $success) {
                    echo "<br>";
                    echo "<h1 class='section_heading' style='text-align:center'>Success!</h1>";
                    echo "<br>";
                    echo "<h2 style='text-align:center'>Password has been changed.</h2>";
                    echo "<br>";
                    echo "<div class='form-group'>";
                    ?> <button class='btn btn-info button_forms btn-lg btn-block' onclick="window.location.href = 'index.php'">Redirect me to home!</button>
                        <?php
                        echo "</div>";
                    } else {

                        echo "<br>";
                        echo "<h1 class='section_heading' style='text-align:center'>CAKED!</h1>";
                        echo "<h2 style='text-align:center'>The following input errors were detected:</h2>";
                        echo "<p style='text-align:center'>" . $pwdolderrorMsg . $pwderrorMsg . $pcerrorMsg . $errorMsg . "</p>";
                        echo "<div class='form-group'>";
                        echo "<button onclick='history.back()' type='button' class='btn button_forms btn-info btn-block'>Go Back</button>";
                        echo "</div>";
                    }

                    function authenticateUser() {
                        global $id, $pwd_hashed, $pwd_old, $errorMsg, $pwd_check, $success;
// Create database connection.
//                    $config = parse_ini_file('../../private/db-config.ini');
//                    $conn = new mysqli($config['servername'], $config['username'],
//                            $config['password'], $config['dbname']);
//                            
// Check connection
                        $conn = OpenCon();
                        if ($conn->connect_error) {
                            $errorMsg = "Connection failed: " . $conn->connect_error;
                            $success = false;
                        } else {
// Prepare the statement:
                            $stmt = $conn->prepare("SELECT * FROM fmembers WHERE memberID=?");
// Bind & execute the query statement:
                            $stmt->bind_param("i", $id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
// Note that email field is unique, so should only have
// one row in the result set.
                                $row = $result->fetch_assoc();
                                $pwd_check = $row["password"];


// Check if the password matches:
                                if (!password_verify($pwd_old, $pwd_check)) {
// Don't be too specific with the error message - hackers don't
// need to know which one they got right or wrong. :)
                                    $errorMsg = "Incorrect Password";
                                    $success = false;
                                } else {
                                    $stmt = $conn->prepare("UPDATE fmembers SET password='$pwd_hashed' WHERE memberID='$id'");

                                    if (!$stmt->execute()) {
                                        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                                        $success = false;
                                    }
                                }
                            } else {
                                $errorMsg = "Email not found";
                                $success = false;
                            }
                            $stmt->close();
                        }
                        $conn->close();
                    }

                    /*
                     * Helper function to update the data to the DB
                     */
                    ?>
            </div>
        </main>
        <?php
        include "footer.php";
        ?>
    </body>
</html>



