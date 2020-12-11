<?php
require 'dbconfig.php';
include 'sessiontest.php';
include 'adminTraverseSecurity.php';
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <?php
        include 'header.php';
        ?>
        <title>Floured - Manage User</title>
    </head>
    <body>
        <main>
            <?php
            include 'navbar.php';
            ?>

            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Manage Users</h1>
                    <p class="lead">Navigate using the buttons below.</p>

                    <button type="button" onclick="window.location.href = 'm.register.php'" class="btn button_forms btn-info btn-lg btn-block">Register A User</button>

                    <button type="button" onclick="window.location.href = 'm.update.php'" class="btn button_forms btn-info btn-lg btn-block">Update User Info</button>

                    <button type="button" onclick="window.location.href = 'm.delete.php'" class="btn button_forms btn-info btn-lg btn-block">Delete A User</button>
                    <br>
                    <div class="card border-dark mb-3">
                        <div class="card-header">Registered Users</div>
                        <div class="card-body text-primary">



                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>MemberID:</th>
                                            <th>First Name:</th>
                                            <th>Last Name:</th>
                                            <th>E-mail:</th>
                                            <th>Address:</th>
                                            <th>Contact:</th>
                                            <th>Gender:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $conn = OpenCon();
                                        if ($conn->connect_error) {
                                            $errorMsg = "Connection failed: " . $conn->connect_error;
                                        } else {
                                            $stmt = $conn->prepare("SELECT * FROM fmembers WHERE role = 'Member'");
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>

                                                <tr>
                                                    <td><?php echo $row['memberID'] ?></td>
                                                    <td><?php echo $row['fname'] ?></td>
                                                    <td><?php echo $row['lname'] ?></td>
                                                    <td><?php echo $row['email'] ?></td>
                                                    <td><?php echo $row['address'] ?></td>
                                                    <td><?php echo $row['contact'] ?></td>
                                                    <td><?php echo $row['gender'] ?></td>
                                                </tr>



                                                <?php
                                            }
                                        }
                                        ?>



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="card border-dark mb-3">
                        <div class="card-header"> Admin Users</div>
                        <div class="card-body text-primary">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>MemberID:</th>
                                            <th>First Name:</th>
                                            <th>Last Name:</th>
                                            <th>E-mail:</th>
                                            <th>Address:</th>
                                            <th>Contact:</th>
                                            <th>Gender:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $conn = OpenCon();
                                        if ($conn->connect_error) {
                                            $errorMsg = "Connection failed: " . $conn->connect_error;
                                        } else {
                                            $stmt = $conn->prepare("SELECT * FROM fmembers WHERE role = 'Admin'");
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>

                                                <tr>
                                                    <td><?php echo $row['memberID'] ?></td>
                                                    <td><?php echo $row['fname'] ?></td>
                                                    <td><?php echo $row['lname'] ?></td>
                                                    <td><?php echo $row['email'] ?></td>
                                                    <td><?php echo $row['address'] ?></td>
                                                    <td><?php echo $row['contact'] ?></td>
                                                    <td><?php echo $row['gender'] ?></td>
                                                </tr>



                                                <?php
                                            }
                                        }
                                        ?>



                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php
        include 'footer.php';
        ?>
    </body>

</html>
