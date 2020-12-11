<nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: #0B505B;" id="navbar">
    <a class="navbar-brand" href="index.php">

        <?php
        if (isset($_SESSION['fname'])) {
            if ($_SESSION['role'] == 'Admin') {
                echo "<img src='images/favicon.ico' width='30' height='30' class='d-inline-block align-top' alt='' loading='lazy'>";
                echo " Floured! Admin";
            } else {
                echo "<img src='images/favicon.ico' width='30' height='30' class='d-inline-block align-top' alt='' loading='lazy'>";
                echo " Floured!";
            }
        } else {
            echo "<img src='images/favicon.ico' width='30' height='30' class='d-inline-block align-top' alt='' loading='lazy'>";
            echo " Floured!";
        }
        ?>

    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#expand" aria-controls="expand" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="expand">  
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0" >
            <?php
            if (isset($_SESSION['fname'])) {
                if ($_SESSION['role'] != 'Admin') {
                    ?>
                    <li class = "nav-item active" >
                        <a class = "nav-link" href = "index.php">Home<span class = "sr-only"></span></a>
                    </li>
                    <?php
                }
            } else {
                ?>
                <li class = "nav-item active">
                    <a class = "nav-link" href = "index.php">Home<span class = "sr-only"></span></a>
                </li>

                <?php
            }
            if (isset($_SESSION['fname'])) {
                if ($_SESSION['role'] == 'Member') {
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="viewdelivery.php">Delivery<span class="sr-only"></span></a>
                    </li>
                    <?php
                }
            }
            ?>
            <li class="nav-item active">
                <a class="nav-link" href="catalogue.php">Catalogue</a>
            </li> 

            <li class="nav-item active">
                <a class="nav-link" href="EmbeddedMaps.php">Store Information</a>
            </li>    



        </ul>
        <ul class="navbar-nav ">

            <?php
            if (isset($_SESSION['fname'])) {
                if ($_SESSION['role'] == 'Member') {
                    ?>
                    <li class="nav-item active" >
                        <a class="nav-link" href="cart.php"><i style="font-size:20px;" class="fas fa-shopping-cart"></i> Cart</a>
                    </li> 
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i style="font-size:20px;" class="fa fa-user"></i> <?php echo $_SESSION['fname'] ?></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="profile.php">My Profile</a>
                            <a class="dropdown-item" href="passwordchange.php">Change my Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="settings.php">Settings</a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="logout.php"><i style="font-size:20px;" class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>

                    <?php
                }
                if ($_SESSION['role'] == 'Admin') {
                    ?>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i style="font-size:20px;" class="fas fa-sliders-h"></i> Management Settings</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="manageuser.php">User Management</a>
                            <a class="dropdown-item" href="managecatalogue.php">Product Management</a>
                            <a class="dropdown-item" href="managedelivery.php">Delivery Management</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="settings.php">Settings</a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="logout.php"><i style="font-size:20px;" class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                    <?php
                }
            } else {
                ?>
                <li class="nav-item active" >
                    <a class="nav-link" href="cart.php"><i style="font-size:20px;" class="fas fa-shopping-cart"></i> Cart</a>
                </li> 
                <li class="nav-item active">
                    <a class="nav-link" href="register.php"><i style="font-size:20px;" class="fa fa-user"></i> Register</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="login.php"><i style="font-size:20px;" class="fa fa-sign-in-alt"></i> Login</a>
                </li>
            <?php }
            ?> 


        </ul>
    </div>
</nav>
<br>
<br>
