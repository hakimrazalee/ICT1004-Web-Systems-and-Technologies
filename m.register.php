<?php
include 'sessiontest.php';
include 'adminTraverseSecurity.php';
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <?php
        include 'header.php';
        ?>
        <title>Floured - Manager Register</title>
    </head>
    <body>
        <?php
        include 'navbar.php';
        ?>
        <br>
        <main class="container">
            <h1 class="section_heading">Member Registration</h1>
            <form action="registerprocess.php" method="post">
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input class="form-control" type="text" id="fname" 
                           minlength="1" maxlength="45" pattern="[A-Za-z]{2,45}" title="2-45 Alphabetical Characters Only." name="fname" placeholder="Enter first name">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input class="form-control" type="text" id="lname" required
                           minlength="1" maxlength="45" pattern="[A-Za-z]{2,45}" title="2-45 Alphabetical Characters Only." name="lname" placeholder="Enter last name">
                </div>
                <div class="form-group">
                    <p>Please select your gender:</p>
                    <input type="radio" id="male" name="gender" value="Male">
                    <label for="male">Male</label><br>
                    <input type="radio" id="female" name="gender" value="Female">
                    <label for="female">Female</label><br>

                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" id="email" required
                           name="email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="contact">Contact:</label>            
                    <input class="form-control" type="tel" id="contact" name="contact" pattern="[0-9]{8}" title="8 number characters only!"                 
                           required placeholder="Enter contact">            
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>            
                    <input class="form-control" type="text" id="address" name="address"                   
                           required placeholder="Enter address">            
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input class="form-control" type="password" id="pwd" required
                           name="pwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                           title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label for="pwd_confirm">Confirm Password:</label>
                    <input class="form-control" type="password" id="pwd_confirm" required
                           name="pwd_confirm" placeholder="Confirm password">
                </div>
                <div class="form-check">
                    <label>
                        <input type="checkbox" name="role" value="Admin">
                        Make this user an admin
                    </label>
                    <br>
                    <label>
                        <input type="checkbox" required name="agree">
                        By registering this user, you permit access to his/her information under the PDPA act.  
                    </label>
                </div>
                <br>
                <div class="form-group">
                    <button class="btn btn-info button_forms " type="submit">Submit</button>
                </div>
            </form>

            <script>

            </script>
        </main>
        <?php
    include 'footer.php';
    ?>
    </body>
    
</html>
