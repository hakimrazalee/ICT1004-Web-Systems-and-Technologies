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
        <script defer src="js/edititem.js"></script>
        <title>Floured - Add New Items</title>
    </head>
    <main>
        <body>
            <?php
            include 'navbar.php';
            ?>
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Editing Item Details</h1>
                    <p class="lead">Change item information</p>
                    <p id="test"></p>
                    <form action="process_edititem.php" method="POST" enctype="multipart/form-data">
                        <div id="hidden_form_container" style="display:none;">
                            <input type='text' class='form-control' id='cakeid' name='cakeid'>
                        </div>
                        <div class="image-preview" class="image-preview">
                            <img src='' alt='Image Preview' id="cakeimg" class="cake_preview">
                        </div> 
                        <br>
                        <div class="form-group">
                            <label for="iname">Item Name:</label>
                            <input class="form-control" type="text" id="iname" required
                                   minlength="1" maxlength="50" name="iname" placeholder="e.g. Red Round Cake">
                            <br>
                            <label for="itype">Type of Cake:</label>
                            <select class="form-control col-md" id="itype" name="itype">
                                <option>Cake</option>
                                <option>Wedding Cake</option>
                                <option>Ice-cream Cake</option>
                            </select>
                            <br>
                            <div class ='row'>
                                <label class='col-md' for="iprice">Price:</label>
                                <label class='col-md' for="idiscount">Discount:</label>
                            </div>
                            <div class='row'>
                                <input class="form-control col-md" type="number" id="iprice" required
                                       minlength="1" maxlength=7 name="iprice" placeholder="e.g. 10.5" step="0.01">
                                <input class="form-control col-md" type="text" id="idiscount" value='0'
                                       minlength="1" maxlength=7 name="idiscount" placeholder="e.g. $40 or 50%">
                            </div>

                            <br>
                            <label for="idimension">Item Size:</label>
                            <label for="sizeunit" visible="none">Size Unit:</label>
                            <div class='row'>
                                <input class="form-control col-md" type="text" id="idimension" required
                                       minlength="1" maxlength="100" name="idimension" placeholder="e.g. 10 (diameter) x 5 (height)">
                                <select class="form-control col-md" id="sizeunit" name="sizeunit">
                                    <option>inch</option>
                                    <option>cm</option>
                                </select>
                            </div>
                            <br>
                            <label for="iwarning">Item Warnings:</label>
                            <input class="form-control" type="text" id="iwarning"
                                   maxlength="100" name="iwarning" placeholder="e.g. nuts, milk, gluten">
                            <br>
                            <label for="idescription">Item Description(max 255 character):</label>
                            <textarea class="form-control" rows="5" minlength='1' id="idescription" required 
                                      maxlength='255' placeholder='description here:' name="idescription"></textarea>
                            <br>
                            <div class="row">
                                <div class="col-md">Make Available:    
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="iavailability" id="inlineRadio1" value="Yes" checked>
                                        <label class="form-check-label" for="inlineRadio1" >now</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="iavailability2" id="inlineRadio2" value="no">
                                        <label class="form-check-label" for="inlineRadio2">delayed</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <input type="submit" class="float-right btn button_forms btn-info" name="create" value="Complete">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </body>
    </main>
    <?php
    include 'footer.php';
    ?>
</html>
