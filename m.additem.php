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
        <script defer src="js/itemadd.js"></script>
    </head>
    <main>
        <body>
            <?php
            include 'navbar.php';
            ?>
            <title>Floured - Add New Items</title>
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Add New Items</h1>
                    <p class="lead">Creating new item for shop's catalogue</p>
                    <form action="process_additem.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="iname">Item Name:</label>
                            <input class="form-control" type="text" id="iname" required
                                   minlength="1" maxlength="50" name="iname" placeholder="e.g. Red Round Cake">
                            <br>
                            <label for="itype">Type of Cake:</label>
                            <select class="form-control col-md" id="itype" name="itype">
                                <option selected='selected'>Cake</option>
                                <option>Wedding Cake</option>
                                <option>Ice-cream Cake</option>
                            </select>
                            <br>
                            <label for="iprice">Price:</label>
                            <input class="form-control" type="number" id="iprice" required
                                   minlength="1" maxlength=7 name="iprice" placeholder="e.g. 10.5" step="0.01">
                            <br>
                            <label for="idimension">Item Size:</label>
                            <label for="sizeunit" visible="none">Unit:</label>
                            <div class='row'>
                                <input class="form-control col-md" type="text" id="idimension" required
                                       minlength="1" maxlength="100" name="idimension" placeholder="e.g. 10 (diameter) x 5 (height)">
                                <select class="form-control col-md" id="sizeunit" name="sizeunit">
                                    <option selected='selected'>inch</option>
                                    <option>cm</option>
                                </select>
                            </div>
                            <br>
                            <label for="iwarning">Item Warnings:</label>
                            <input class="form-control" type="text" id="iwarning"
                                   maxlength="100" name="iwarning" placeholder="e.g. nuts, milk, gluten">
                            <br>
                            <label for="idescription">Item Description(max 255 character):</label>
                            <textarea class="form-control" rows="5" id="idescription" minlength='1' required
                                      maxlength='255' placeholder='description here...' name="idescription"></textarea>
                            <br>
                            <label for="file">Select image of item</label>
                            <br>
                            <input type='file' name="file" id='file' accept="image/*" required/>
                            <div class="image-preview" id="imagePreview">
                                <img src='' alt='Image Preview' class='image-preview__image'>
                                <span class="image-preview__default-text"> Image preview.</span>
                            </div> 

                            <br>
                            <div class="row">
                                <div class="col-md">Make Available:    
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="iavailability" id="inlineRadio1" value="Yes" checked>
                                        <label class="form-check-label" for="inlineRadio1" >now</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="iavailability" id="inlineRadio2" value="No">
                                        <label class="form-check-label" for="inlineRadio2">delayed</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <input type="submit" class="float-right btn button_forms btn-info" name="create" value="Create">
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
