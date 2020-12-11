<?php
include 'sessiontest.php';
include 'memberTraverseSecurity.php';
?>
<!DOCTYPE html>
<html lang = "en">
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
            <title>Floured - Profile</title>

        </head>

        <body>    
            <?php
            include "navbar.php";
            ?>    
            <br/>
            <br/>



            <div class="row">

                <main class="container">   
                    <h1 class='section_heading' style="text-align: center">Update Password:</h1>
                    <br>
                    <div class ="card mb-3" >

                        <div class="row no-gutters">
                            <?php if ($_SESSION['gender'] == 'Male') { ?>
                                <img src="images/img_avatar.png" style="width: 500px" class="card-img-top" alt="profileimg"/>
                            <?php } else if ($_SESSION['gender'] == 'Female') { ?>
                                <img src="images/img_avatar2.png" style="width: 500px" class="card-img-top" alt="profileimg"/>
                            <?php } ?>
                            <div class="card-body">
                                <form action="passwordprocess.php" method="post">  
                                <div class="row">

                                    <div class="col">
                                                  
                                            <div class="form-group">
                                                <label for="pwd_old">Enter Old Password:</label>            
                                                <input class="form-control" type="password" id="pwd_old"                   
                                                       required name="pwd_old" placeholder="Enter Old Password">            
                                            </div>

                                            <table>
                                                <tr>
                                                    <td>
                                                        <label for="pwd">Enter New Password: </label>
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
                                            <input class="form-control" type="password" id="pwd" onkeyup="return checkPwdStrength();" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                   title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters"                
                                                   required name="pwd" placeholder="Enter new password">             
                                            <br>
                                            <div class="form-group">
                                                <label for="pwd_confirm">Confirm Password:</label>            
                                                <input class="form-control" type="password" id="pwd_confirm"                   
                                                       required name="pwd_confirm" placeholder="Confirm new password">            
                                            </div>

                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div>
                                    <button class="btn btn-info button_forms" type="submit">Change Password</button>   
                                </div>
                                </form>    
                            </div>
                        </div>
                    </div>
                </main>    
            </div>
            <?php
            include "footer.php";
            ?>
        </body>
    </html>