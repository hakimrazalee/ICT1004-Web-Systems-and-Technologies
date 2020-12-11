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
            <div class="container" id="container_placeholder">
                <h1 class="display-4">Editing Item Details</h1>
                <?php
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                $safeData = filter_input_array(INPUT_POST);
                $price = "";
                $discount = "";
                $availability = "";
                $success = true;
                $errorMsg = "";
                $type = "";
                $in = array();

                if (empty($safeData["idarray"])) {
                    $errorMsg .= "No item selected.<br>";
                    $success = false;
                } else {
                    $cakeid = implode(",", array_map('intval', explode(',', $safeData["idarray"])));
                }

                if ($_POST['submit'] == 'Price') {
                    $type = 'price';
                } else if ($_POST['submit'] == 'Discount') {
                    $type = 'discount';
                } else if ($_POST['submit'] == 'Availability') {
                    $type = 'availability';
                } else if ($_POST['submit'] == 'Delete') {
                    $type = 'delete';
                }
                switch ($type) {
                    case 'price': {
                            if (empty($safeData['iprice'])) {
                                $errorMsg .= "Price is required and price cannot be 0.<br>";
                                $success = false;
                            } else {
                                $price = sanitize_input($safeData["iprice"]);
                            }
                        }
                        break;
                    case 'discount': {
                            $discount = sanitize_input($safeData["idiscount"]);
                        }
                        break;
                    case 'availability': {
                            $availability = sanitize_input($safeData['iavailability']);
                            if ($availability == "Available") {
                                $availability = "Yes";
                            } else {
                                $availability = "No";
                            }
                            break;
                        }
                }

                if ($success) {
                    processDB($type);
                    echo "<h1>Item successfully updated.<h1>";
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

                function processDB($type) {
                    global $type, $price, $discount, $cakeid, $availability;
                    $conn = OpenCon();
                    if ($conn->connect_error) {
                        $errorMsg = "Connection failed: " . $conn->connect_error;
                        $success = false;
                    } else {        // Prepare the statement:
                        switch ($type) {
                            case 'price':
                                $stmt = $conn->prepare("UPDATE catalogue SET price=? WHERE cakeid IN (" . $cakeid . ")");
                                $rc = $stmt->bind_param("s", $price);
                                break;
                            case 'discount':
                                $stmt = $conn->prepare("UPDATE catalogue SET discount=? WHERE cakeid IN (" . $cakeid . ")");
                                $rc = $stmt->bind_param("s", $discount);
                                break;
                            case 'availability':
                                $stmt = $conn->prepare("UPDATE catalogue SET availability=? WHERE cakeid IN (" . $cakeid . ")");
                                $rc = $stmt->bind_param("s", $availability);
                                break;
                            case 'delete';
                                $stmt = $conn->prepare("DELETE FROM catalogue WHERE cakeid IN (" . $cakeid . ")");
                                $rc = true;
                                break;
                        }
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