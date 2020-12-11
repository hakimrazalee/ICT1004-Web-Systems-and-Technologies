<?php
include 'sessiontest.php';
include 'adminTraverseSecurity.php';
require 'dbconfig.php';
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <?php
        include 'header.php';
        ?>
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
        <title>Floured - Add New Items</title>
    </head>
    <body>
        <?php
        include 'navbar.php';
        ?>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">Editing Item Details</h1>
                <?php
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                $safeData = filter_input_array(INPUT_POST);
                $name = "";
                $price = "";
                $dimension = "";
                $description = "";
                $warning = "";
                $discount = "";
                $availability = $safeData["iavailability"];
                $cakeid = 0;
                $type = $safeData["itype"];
                $success = true;
                $errorMsg = "";

                if (empty($safeData["cakeid"])) {
                    $errorMsg .= "Item not found.<br>";
                    $success = false;
                } else {
                    $cakeid = (int) sanitize_input($safeData["cakeid"]);
                }

                if (empty($safeData["iname"])) {
                    $errorMsg .= "Item Name is required.<br>";
                    $success = false;
                } else {
                    $name = sanitize_input($safeData["iname"]);
                }

                if (empty($safeData["iprice"])) {
                    $errorMsg .= "Price is required.<br>";
                    $success = false;
                } else {
                    $price = sanitize_input($safeData["iprice"]);
                }
                if (!empty($safeData["idiscount"])) {
                    $discount = sanitize_input($safeData["idiscount"]);
                }

                if (empty($safeData["idimension"])) {
                    $errorMsg .= "Item Size is required.<br>";
                    $success = false;
                } else {
                    $dimension = sanitize_input($safeData["idimension"]) . " " . $safeData["sizeunit"];
                }

                if (empty($safeData["idescription"])) {
                    $errorMsg .= "Description is required.<br>";
                    $success = false;
                } else {
                    $description = sanitize_input($safeData["idescription"]);
                }

                if (!empty($safeData["iwarning"])) {
                    $warning = sanitize_input($safeData["iwarning"]);
                }

                if ($success) {
                    updateDB();
                    echo "<h1>Item $name successfully updated.<h1>";
                    echo "<a href='m.itemupdate.php' class ='btn button_forms btn-info mr-1' style='padding: 5x 10px;'>Return to Manage Items</a>";
                    echo "<a href = 'management.php' class='btn button_forms btn-info mr-1' style='padding: 5x 10px;'>Return to Management</a></p>";
                } else {
                    echo "<h1>Item was not successfully added.<h1>";
                    echo "<p> Error Detected: " . $errorMsg . "</p>";
                }

                function sanitize_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                function updateDB() {
                    global $name, $type, $price, $dimension, $description, $availability, $discount, $warning, $cakeid;
                    $conn = OpenCon();
                    if ($conn->connect_error) {
                        $errorMsg = "Connection failed: " . $conn->connect_error;
                        $success = false;
                    } else {        // Prepare the statement:       
                        $stmt = $conn->prepare("UPDATE catalogue SET name=?,type=?,price=?,description=?,discount=?,dimension=?,warning=?,availability=? WHERE cakeid=?");
                        if (false === $stmt) {
                            die('prepare() failed: ' . htmlspecialchars($conn->error));
                        }

                        $rc = $stmt->bind_param("ssssssssi", $name, $type, $price, $description, $discount, $dimension, $warning, $availability, $cakeid);

                        if (false === $rc) {
                            die('bind_param() failed: ' . htmlspecialchars($stmt->error));
                        }

                        $rc = $stmt->execute();

                        if (false === $rc) {
                            die('execute() failed: ' . htmlspecialchars($stmt->error));
                        }
                        $stmt->close();
                        $sql = "SELECT * FROM catalogue";
                        $sqlexecute = mysqli_query($conn, $sql);
                        $json = array();
                        $records = mysqli_num_rows($sqlexecute);

                        if ($records > 0) {
                            $i = 0;
                            while ($row = mysqli_fetch_array($sqlexecute)) {
                                $cakeid = sprintf('%05d', $row['cakeid']);
                                $info_array = array();
                                $info_array['name'] = $row['name'];
                                $info_array['type'] = $row['type'];
                                $info_array['price'] = $row['price'];
                                $info_array['description'] = $row['description'];
                                $info_array['discount'] = $row['discount'];
                                $info_array['imgurl'] = $row['imgurl'];
                                $info_array['dimension'] = $row['dimension'];
                                $info_array['warning'] = $row['warning'];
                                $info_array['availability'] = $row['availability'];
                                $json[$cakeid] = $info_array;
                            }
                            file_put_contents('json/Items.json', json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                        }
                    }
                    $conn->close();
                    //refresh json string
                }
                ?>
            </div>
        </div>
    </body>
    <?php
    include 'footer.php';
    ?>
</html>