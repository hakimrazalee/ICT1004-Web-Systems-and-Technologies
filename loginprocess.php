<!DOCTYPE html>
<html lang="en">
    <title>Login</title>
    <?php
    include 'sessiontest.php';
    require 'dbconfig.php';
    include "header.php";
    ?>
    <body>

        <main class="container">
            <?php echo "<div>"; 
                
                $fname = '';
                $lname = '';
                $email = '';
                $memberID = '';
                $role = '';
                $contact = '';
                $address = '';
                $gender = '';
                $pwd = '';
                $pwd_hashed = '';
                $errorMsg = '';
                $success = True;

                //check if E-mail is empty
                if (empty($_POST["email"])) {
                    $errorMsg .= "Email is required.<br>";
                    $success = false;
                } else {
                    $email = sanitize_input($_POST["email"]);
// Additional check to make sure e-mail address is well-formed.
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errorMsg .= "Invalid email format.<br>";
                        $success = false;
                    }
                }

                if (empty($_POST["pwd"])) {
                    $errorMsg .= "Password is required.<br>";
                    $success = false;
                }

                authenticateUser();
                ?>
                <?php
                if ($success) {
                    $_SESSION['fname'] = $fname;
                    $_SESSION['lname'] = $lname;
                    $_SESSION['memberID'] = $memberID;
                    $_SESSION['role'] = $role;
                    $_SESSION['contact'] = $contact;
                    $_SESSION['email'] = $email;
                    $_SESSION['address'] = $address;
                    $_SESSION['gender'] = $gender;
                    $_SESSION['verified'] = $verified;
                    
                    include "navbar.php"; 
                    echo "<br>";
                    echo "<h1 class='section_heading' style='text-align:center'>Login successful!</h1>";
                    echo "<br>";
                    echo "<h2 style='text-align:center'>Welcome back, $fname $lname</h2>";
                    echo "<br>";
                    echo "<div class='form-group'>";
                    ?> <button class='btn button_forms btn-info btn-lg btn-block' onclick="window.location.href = 'index.php'">Start Browsing!</button>
                    <?php
                    echo "</div>";
                    echo "<br>";
                } else {
                    include "navbar.php"; 
                    echo "<br>";
                    echo "<h1 class='section_heading' style='text-align:center'>CAKED!</h1>";
                    echo "<br>";
                    echo "<h2 style='text-align:center'>". $errorMsg ."</h2>";
                    echo "<br>";
                    echo "<div class='form-group'>";
                    echo "<button onclick='history.back()' type='button' class='btn button_forms btn-info btn-lg btn-block'>Go Back</button>";
                    echo "</div>";
                    echo "<br>";
                }

                //Helper function that checks input for malicious or unwanted content.
                function sanitize_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                /*
                 * Helper function to authenticate the login.
                 */

                function authenticateUser() {
                    global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success, $memberID, $role, $contact, $address, $gender, $verified;
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
                        $stmt = $conn->prepare("SELECT * FROM fmembers WHERE email=?");
// Bind & execute the query statement:
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
// Note that email field is unique, so should only have
// one row in the result set.
                            $row = $result->fetch_assoc();
                            $fname = $row["fname"];
                            $lname = $row["lname"];
                            $pwd_hashed = $row["password"];
                            $memberID = $row["memberID"];
                            $role = $row["role"];
                            $contact = $row["contact"];
                            $address = $row["address"];
                            $gender = $row["gender"];
                            $verified = $row["verified"];




// Check if the password matches:
                            if (!password_verify($_POST["pwd"], $pwd_hashed)) {
// Don't be too specific with the error message - hackers don't
// need to know which one they got right or wrong. :)
                                $errorMsg = "Invalid E-mail/Password.";
                                $success = false;
                            }
                        } else {
                            $errorMsg = "Invalid E-mail/Password.";
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



