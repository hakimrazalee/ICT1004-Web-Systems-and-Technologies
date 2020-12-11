
<?php
require 'dbconfig.php';
include 'sessiontest.php';
include 'adminTraverseSecurity.php';
$userid = '';
$email = '';
$success = false;
$emailerrorMsg = '';
$thisfName = '';
$thislName = '';
$thisemail = '';
$thiscontact = '';
$thisaddress = '';
$thisrole = '';
$thisgender = '';

if (empty($_POST["userid"])) {
    if (empty($_POST["email"])) {
        $emailerrorMsg .= "Please enter the E-mail address or User ID of the member you wish to update.";
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

if ($success) {
    getUser();
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getUser() {
    global $success, $userid, $email, $thisfName, $thislName, $thisemail, $thiscontact, $thisaddress, $thisrole, $thisgender, $thisverification;
    $conn = OpenCon();
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
// Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM fmembers WHERE email=? OR memberID=?");
// Bind & execute the query statement:
        $stmt->bind_param('ss', $email, $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
// Note that email field is unique, so should only have
// one row in the result set.
            $row = $result->fetch_assoc();
            $thisfName = $row["fname"];
            $thislName = $row["lname"];
            $thisemail = $row['email'];
            $thiscontact = $row["contact"];
            $thisaddress = $row["address"];
            $thisrole = $row["role"];
            $thisgender = $row["gender"];

            $_SESSION['updatekey'] = $row["memberID"];
            $_SESSION['userverified'] = $row["verified"];
            $_SESSION['useremail'] = $row["email"];
        } else {
            $errorMsg = "User not found.";
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            .responsive {
                width: 100%;
                /*  max-width: 400px;*/
                height: auto;

            }
        </style>
        <?php
        include 'header.php';
        ?>
        <title>Floured - Update</title>
    </head>

    <body>

        <?php
        include 'navbar.php';
        ?>
        <br/>
        <br/>
        <br/>

        <div class="row">

            <main class="container">  
                <h1 class='section_heading' style="text-align: center">Update <?php echo $thisfName; ?>'s Profile:</h1>
                <br>
                <div class ="card mb-3" >
                    <div class="row no-gutters">
                        <?php if ($success) { ?>
                            <?php if ($thisgender == 'Male') { ?>
                                <img src="images/img_avatar.png" style="width: 500px " class="card-img-top" alt="profileimg"/>
                            <?php } else if ($thisgender == 'Female') { ?>
                                <img src="images/img_avatar2.png" style="width: 500px" class="card-img-top" alt="profileimg"/>
                            <?php } ?>
                            <div class="card-body">
                                <form action="m.updateprocess.php" method="post">
                                    <div class="row">

                                        <div class="col">




                                            <div class="form-group">
                                                <label for="fname">First Name:</label>            
                                                <input class="form-control" type="text" id="fname" name="fname" pattern="[A-Za-z]{2,45}" title="2-45 Alphabetical Characters Only."                   
                                                       placeholder="Enter first name" value="<?php echo $thisfName ?>">            
                                            </div>
                                            <div class="form-group">
                                                <label for="lname">Last Name:</label>             
                                                <input class="form-control" type="text" id="lname" name="lname" pattern="[A-Za-z]{2,45}" title="2-45 Alphabetical Characters Only."                  
                                                       required placeholder="Enter last name" value="<?php echo $thislName ?>">             
                                            </div>
                                            <div class="form-group">

                                                <?php if ($thisgender == 'Male') { ?>
                                                    <p>Please select gender:</p>
                                                    <input type="radio" id="male" name="gender" checked value="Male">
                                                    <label for="male">Male</label><br>
                                                    <input type="radio" id="female" name="gender" value="Female">
                                                    <label for="female">Female</label><br>
                                                <?php } else if ($thisgender == 'Female') { ?>
                                                    <p>Please select gender:</p>
                                                    <input type="radio" id="male" name="gender" checked value="Male">
                                                    <label for="male">Male</label><br>
                                                    <input type="radio" id="female" name="gender" value="Female" checked>
                                                    <label for="female">Female</label><br>
                                                <?php } ?>



                                            </div>

                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="email">Email:</label>            
                                                <input class="form-control" type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"                  
                                                       required placeholder="Enter email" value="<?php echo $thisemail ?>">            
                                            </div>
                                            <div class="form-group">
                                                <label for="contact">Contact:</label>            
                                                <input class="form-control" type="tel" id="contact" name="contact" pattern="[0-9]{8}" title="8 number characters only!"                  
                                                       required placeholder="Enter contact" value="<?php echo $thiscontact ?>">            
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Address:</label>            
                                                <input class="form-control" type="text" id="address" name="address"                   
                                                       required placeholder="Enter address" value="<?php echo $thisaddress ?>">            
                                            </div>
                                            <div class="form-check">

                                                <?php if ($thisrole == 'Admin') { ?>
                                                    <p>Revert Admin Rights?:</p>
                                                    <label>
                                                    <input type="radio" id="Member" name="role" value="Member"> Yes</label>
                                                    <label>
                                                    <input type="radio" id="Admin" name="role" checked value="Admin"> No</label>
                                                <?php } else { ?>
                                                    <p>Make this user an Admin?:</p>
                                                    <label>
                                                    <input type="radio" id="Admin" name="role" value="Admin"> Yes</label>
                                                    <label>
                                                    <input type="radio" id="Member" name="role" checked value="Member"> No</label>
                                                <?php } ?>

                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                    </div>
                                    <br>
                                    <div>
                                        <strong>Warning: Changing the user's email WILL reset their verification status.</strong>
                                        <br>
                                        <br>
                                        <button class="btn btn-info button_forms" type="submit">Save Changes</button>   
                                    </div>
                                </form>    
                            </div>

                        <?php } else {
                            ?>
                            <h1 class='section_heading' style='text-align:center'>There is no such user!</h1>

                        <?php }
                        ?>

                    </div>
                </div>
            </main>    
        </div>
        <?php
        include 'footer.php';
        ?>
    </body>

</html>
