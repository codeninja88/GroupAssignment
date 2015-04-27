<?php
include('databaseConnect.php');
include_once('functions.php');
/*This gives us our database object*/

if ($_POST['submit'] === "Add New Artist") {
    if (isset($_FILES['fileToUpload']['name'])) {
        echo "<br /><strong>A file has been sent</strong> <br />";
        $imageFiles = scandir('Images/musos/');
        //List of files in the image file.
        //Check that the file name doesnt exist in the file an if it does do I modify the name or requect the file.
        echo "<pre>";
        print_r($imageFiles);
        echo "</pre>";

    }
    addArtist();
} elseif ($_POST['delete']) {
    $sentVariable = $_POST['delete'];
    deleteArtist($_POST['delete']);
} elseif ($_POST['edit']) {
    echo "Edit was selected for: " . $_POST['edit'];
} elseif ($_POST['confirm']) {
    confirmUpdate();
} else if ($_POST['moreInfo']) {
    displayIndividualArtistInfo();
    echo "More info was pressed";

} else {
    echo "This hasn't come from form submission <br/ >";
}


?>

    <!DOCTYPE html>
    <html>
    <head lang="en">
        <meta charset="UTF-8">
        <title></title>

    </head>
    <body>
    <div style="float: left; padding: 20px 20px 10px 20px; border-radius: 20px; background-color: blue">
        <form action="index.php" enctype="multipart/form-data" method="post"
              style="padding: 20px; background-color: #a2ffe9; border-radius: 20px;">
            <fieldset>
                <legend>Swoon-worthy Blue Form</legend>
                <table>
                    <tr>
                        <td>Group Name:</td>
                        <td><input type="text" name="artistGroup" value="" placeholder="Group name" required></td>
                    </tr>
                    <tr>
                        <td>Summary:</td>
                        <td><input type="text" name="artistSummary" value="" placeholder="Group summary" required></td>
                    </tr>
                    <tr>
                        <td> Description:</td>
                        <td><input type="text" name="artistDesc" value="" placeholder="Group description" required></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><input type="tel" name="artistPhone" value="" placeholder="Phone number"></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="artistEmail" value="" placeholder="someone@somewhere.com"></td>
                    </tr>
                    <tr>
                        <td>Website:</td>
                        <td><input type="url" name="artistWeb" value="" placeholder="www.mySite.com"></td>
                    </tr>
                    <tr>
                        <!-- Uploading Image. -->
                        <!-- $_FILES is a new super global that will contain uploaded files. -->
                        <!-- $_FILES['fileToUpload'] will give an associative array containing: -->
                        <!-- name: original file name, type: mime type ("image/gif") -->
                        <!-- size: size in bytes tmp_name: temp file name on the server -->
                        <!-- error code -->
                        <td>Image:</td>
                        <td>
                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                            <input type="file" name="fileToUpload" id="fileToUpload">

                        </td>

                    </tr>
                    <tr>

                        <td><input type="submit" name="submit" value="Add New Artist"></td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>


    <!-- CHECK BOXES FOR USER TO SELECT THE CATEGORY TO SORT BY -->
    <div style="float: left; background-color: chartreuse; clear: left; border-radius: 20px; padding: 20px;">
        <form method="post" action="secondPage.php"
              style="padding: 20px 20px 10px 20px; background-color: #daff90; border-radius: 20px;">
            <fieldset>
                <legend>"WOW"</legend>
                <?php
                $sql = "SELECT * FROM CATEGORY;";
                foreach ($dbh->query($sql) as $row) {
                    echo "<input type='checkbox' name='$row[categoryName] . CheckBox' value='$row[categoryName]'>  $row[categoryName] <br />";
                }


                ?>

                <input type="submit" title="SUBMIT">
            </fieldset>

        </form>
    </div>

    <!-- ________________________________________________________________________________________________________________ -->
    <?php


    /*    foreach ($dbh->query($sql) as $row) {
            echo $row['artistGroup'] . "</br>";

        }*/

    if (!$_POST['moreInfoButton']) {
        displayArtists();
    }
    ?>

    <hr>
    <br/>


    </body>
    </html>

<?php $dbh = null; ?>