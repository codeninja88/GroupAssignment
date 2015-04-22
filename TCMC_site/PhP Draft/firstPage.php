<?php
include('databaseConnect.php');
include_once('functions.php');
/*This gives us our database object*/

if ($_POST['submit'] === "Add New Artist") {
    echo "Submitted: <br />";
    echo "<br> Image added" . $_POST['fileToUpload'] . "<<<< FILE <br />";
    addArtist();
    echo "<br>Adding attempted.";
} elseif ($_POST['delete']) {
    $sentVariable = $_POST['delete'];
    echo "Delete selected: $sentVariable sent";
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
        <script>
            var imageArray = document.getElementsByClassName("thumbNailImage");
            function imageCorrection() {
                for (var i = 0; i < imageArray.length; i++) {
                    imageArray[i].onerror = (function () {
                        console.log("An error has been caught");
                        imageArray[i].style.display = 'none';



                    }());
                }
            }

        </script>
    </head>
    <body>
    <?php


    foreach ($dbh->query($sql) as $row) {
        echo $row['artistGroup'] . "</br>";

    }

    if (!$_POST['moreInfoButton']) {
        displayArtists();
    }


    echo "Following the calling of display artist";

    ?>



    <form action="firstPage.php" enctype="multipart/form-data" method="post">
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
    </form>

    <hr>
    <br/>


    </body>
    </html>

<?php $dbh = null; ?>