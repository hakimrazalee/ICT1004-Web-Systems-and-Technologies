<?php
include 'sessiontest.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head> 
        <?php
        include "header.php";
        ?>
        <script>

            var m_strUpperCase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            var m_strLowerCase = "abcdefghijklmnopqrstuvwxyz";
            var m_strNumber = "0123456789";
            var m_strCharacters = "!@#$%^&*?_~";

            function checkPwdStrength() {
                var pwd = document.getElementById("pwd").value;
                len = pwd.length;

                //var scorebar = document.getElementById('scorebar');
                var comp = "";

                if (len == 0) {
                    //scorebar.style.backgroundPosition = '0px 0px';
                    comp = "";
                } else {
                    scr = parseInt(getPwdScore(pwd));

                    if (scr >= 90) {
                        //scorebar.style.backgroundPosition = '0px -30px';
                        comp = "Very Strong";
                    } else if (scr >= 70) {
                        //scorebar.style.backgroundPosition = '0px -24px';
                        comp = "Strong";
                    } else if (scr >= 50) {
                        //scorebar.style.backgroundPosition = '0px -18px';
                        comp = "Good";
                    } else if (scr >= 30) {
                        //scorebar.style.backgroundPosition = '0px -12px';
                        comp = "Weak";
                    } else if (scr >= 0) {
                        //scorebar.style.backgroundPosition = '0px -6px';
                        comp = "Very Weak";
                    }
                }

                document.getElementById('complexity').innerHTML = comp;
                return false;
            }

            function getPwdScore(strPassword) {
                // Reset combination count
                var nScore = 0;

                // Password length
                // -- Less than 4 characters
                if (strPassword.length < 5) {
                    nScore += 5;
                }
                // -- 5 to 7 characters
                else if (strPassword.length > 4 && strPassword.length < 8) {
                    nScore += 10;
                }
                // -- 8 or more
                else if (strPassword.length > 7) {
                    nScore += 25;
                }

                // Letters
                var nUpperCount = countContain(strPassword, m_strUpperCase);
                var nLowerCount = countContain(strPassword, m_strLowerCase);
                var nLowerUpperCount = nUpperCount + nLowerCount;
                // -- Letters are all lower case
                if (nUpperCount == 0 && nLowerCount != 0) {
                    nScore += 10;
                }
                // -- Letters are upper case and lower case
                else if (nUpperCount != 0 && nLowerCount != 0) {
                    nScore += 20;
                }

                // Numbers
                var nNumberCount = countContain(strPassword, m_strNumber);
                // -- 1 number
                if (nNumberCount == 1) {
                    nScore += 10;
                }
                // -- 3 or more numbers
                if (nNumberCount >= 3) {
                    nScore += 20;
                }

                // Characters
                var nCharacterCount = countContain(strPassword, m_strCharacters);
                // -- 1 character
                if (nCharacterCount == 1) {
                    nScore += 10;
                }
                // -- More than 1 character
                if (nCharacterCount > 1) {
                    nScore += 25;
                }

                // Bonus
                // -- Letters and numbers
                if (nNumberCount != 0 && nLowerUpperCount != 0) {
                    nScore += 2;
                }
                // -- Letters, numbers, and characters
                if (nNumberCount != 0 && nLowerUpperCount != 0 && nCharacterCount != 0) {
                    nScore += 3;
                }
                // -- Mixed case letters, numbers, and characters
                if (nNumberCount != 0 && nUpperCount != 0 && nLowerCount != 0
                        && nCharacterCount != 0) {
                    nScore += 5;
                }

                return nScore;
            }

            // Checks a string for a list of characters
            function countContain(strPassword, strCheck) {
                // Declare variables
                var nCount = 0;

                for (i = 0; i < strPassword.length; i++) {
                    if (strCheck.indexOf(strPassword.charAt(i)) > -1) {
                        nCount++;
                    }
                }

                return nCount;
            }

        </script>
        <style>
            #pmId {

            }
            /*
           #scorebarBorder {
                      border: 1px solid #666666;
                      height: 5px;
                      position: relative;
                      width: 122px;
              }

              #scorebar {
                      background-image: url("pm.png");
              }

              #scorebar {
                      background-position: 0 0;
                      background-repeat: no-repeat;
                      height: 5px;
                      width: 122px;
                      z-index: 0;
              }
            */
            #complexity {
                padding: 0;
                text-align: center;
                top: 0;
                width: 122px;
                z-index: 10;
            }

            #complexity_side {
                padding: 0; 
                vertical-align: top;
            }
        </style>
        <title>Floured - Register</title>

    </head>

    <body>    
        <?php include 'navbar.php'; ?>
        <br/>
        <main class="container">        
            <h1 class="section_heading" style="margin-bottom:0px;">Member Registration</h1>        
            <p class="subtext" style="color:black"> For existing members, please go to the            
                <a style="color: black" href="login.php"><strong>Sign In</strong></a> page.        
            </p>        
            <form action="registerprocess.php" method="post">            
                <div class="form-group">
                    <label for="fname">First Name:</label>            
                    <input class="form-control" type="text" id="fname" required name="fname" pattern="[A-Za-z]{2,45}" title="2-45 Alphabetical Characters Only."                  
                           placeholder="Enter first name">            
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>             
                    <input class="form-control" type="text" id="lname"                 
                           required name="lname" pattern="[A-Za-z]{2,45}" title="2-45 Alphabetical Characters Only." placeholder="Enter last name">             
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
                    <input class="form-control" type="email" id="email"                  
                           pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title='Use Proper E-mail Format!' required name="email" placeholder="Enter email">            
                </div>
                <div class="form-group">
                    <label for="contact">Contact:</label>            
                    <input class="form-control" type="tel" id="contact" name="contact"                   
                           required pattern="[0-9]{8}" title="8 number characters only!" placeholder="Enter contact">            
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>            
                    <input class="form-control" type="text" id="address"             
                           required name="address" placeholder="Enter address">            
                </div>
                <div class="form-group">

                    <table>
                        <tr>
                            <td>
                                <label for="pwd">Password: </label>
                            </td>
                            <td id="complexity_side">
                                <div id="pmId">
                                    <!--<div id="scorebarBorder">
                                        <div id="scorebar" style="background-position: 0px 0px;"></div>
                                    </div> -->
                                    <div id="complexity">

                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <input class="form-control" type="password" id="pwd" onkeyup="return checkPwdStrength();"                 
                           required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                           title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="pwd" placeholder="Enter password">             
                </div>
                <div class="form-group">
                    <label for="pwd_confirm">Confirm Password:</label>            
                    <input class="form-control" type="password" id="pwd_confirm"                   
                           required name="pwd_confirm" placeholder="Confirm password">            
                </div>

                <div class="form-check" style="padding-left:0px!important;">
                    <label>                
                        <input type="checkbox" required name="agree">                
                        By Signing up, you permit access to your information under the PDPA act.   
                    </label>            
                </div>

                <br>
                <div>
                    <button class="btn button_forms btn-info" type="submit">Submit</button>   
                </div>
                <br>
            </form>    
        </main>    
        <?php
        include "footer.php";
        ?>
    </body>
</html>