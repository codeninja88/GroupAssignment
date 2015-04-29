<?php
include('databaseConnect.php');
include_once('functions.php');
/*This gives us our database object*/

if ($_POST['submit'] === "Add New Artist") {
    if (isset($_FILES['fileToUpload']['name'])) {
        //$imageFiles = scandir('Images/musos/');
        //List of files in the image file.
        //Check that the file name doesnt exist in the file an if it does do I modify the name or requect the file.
        //This can be used to check the contents of the Image/musos file in future.
        /*        echo "<pre>";
                print_r($imageFiles);
                echo "</pre>";*/
    }
    addArtist();
} elseif ($_POST['delete']) {
    deleteArtist($_POST['delete']);
} elseif ($_POST['edit']) {
    //echo "Editing Artist: " . $_POST['edit'];
} elseif ($_POST['confirm']) {
    confirmUpdate();
} else if ($_POST['moreInfo']) {
    displayIndividualArtistInfo();
} else {
    //URL has been entered and not come from form submission.
}


?>

    <!DOCTYPE html>
    <html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>Group 7 || Index</title>

        <style>
            .submitButton {
                background-color: sandybrown;
                transition: background-color 0.5s ease, color 0.5s ease;
            }

            .submitButton:hover {
                background-color: #ffc975;
                color: #535353;
            }

            .categoryCheckbox {
                width: 20px;
                height: 20px;
            }

        </style>
    </head>
    <body>
    <div
        style="float: left; padding: 20px 20px 10px 20px; border-radius: 20px; background-color: #ffb679; border: outset">
        <form action="index.php" enctype="multipart/form-data" method="post"
              style="padding: 20px; background-color: #ffebc1; border-radius: 20px; border: inset;">
            <fieldset>
                <legend>Enter a new artist:</legend>
                <table>
                    <tr>
                        <td>Group Name*:</td>
                        <td><input type="text" name="artistGroup" value="" placeholder="Group name"
                                   style="padding:5px; margin: 10px; border:ridge; border-radius: 10px" required></td>
                    </tr>
                    <tr>
                        <td>Summary*:</td>
                        <td><input type="text" name="artistSummary" value="" placeholder="Group summary"
                                   style="padding:5px; margin: 10px; border:ridge; border-radius: 10px" required></td>
                    </tr>
                    <tr>
                        <td> Description*:</td>
                        <td><input type="text" name="artistDesc" value="" placeholder="Group description"
                                   style="padding:5px; margin: 10px; border:ridge; border-radius: 10px" required></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><input type="tel" name="artistPhone" value="" placeholder="Phone number"
                                   style="padding:5px; margin: 10px; border:ridge; border-radius: 10px"></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="text" name="artistEmail" value="" placeholder="someone@somewhere.com"
                                   style="padding:5px; margin: 10px; border:ridge; border-radius: 10px;"></td>
                    </tr>
                    <tr>
                        <td>Website:</td>

                        <td><input type="text" name="artistWeb" value="" placeholder="www.mySite.com"
                                   style="padding:5px; margin: 10px; border:ridge; border-radius: 10px;"></td>

                    </tr>
                    <tr>
                        <td>Artist Categories:</td>
                        <!-- plus button, minus button, area to enter category -->
                        <td>
                            <input type="text" name="cat1" value="" placeholder="Music Category" style="padding:5px; margin: 2px; border:ridge; border-radius: 10px;"><br />
                            <input type="text" name="cat2" value="" placeholder="Music Category" style="padding:5px; margin: 2px; border:ridge; border-radius: 10px;"><br />
                            <input type="text" name="cat3" value="" placeholder="Music Category" style="padding:5px; margin: 2px; border:ridge; border-radius: 10px;"><br />
                            <input type="text" name="cat4" value="" placeholder="Music Category" style="padding:5px; margin: 2px; border:ridge; border-radius: 10px;"><br />
                            <input type="text" name="cat5" value="" placeholder="Music Category" style="padding:5px; margin: 2px; border:ridge; border-radius: 10px;"><br />
                        </td>
                    </tr>
                    <tr>
                        <!-- Uploading Image. -->
                        <!-- $_FILES is a new super global that will contain uploaded files. -->
                        <!-- $_FILES['fileToUpload'] will give an associative array containing: -->
                        <!-- name: original file name, type: mime type ("image/gif") -->
                        <!-- size: size in bytes tmp_name: temp file name on the server -->
                        <!-- error code: anything other than 0 is bad. 4 means no file has been uploaded -->
                        <td>Image:</td>
                        <td>
                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                            <input type="file" name="fileToUpload" id="fileToUpload" style="cursor: pointer">

                        </td>

                    </tr>
                    <tr>

                        <td><input type="submit" name="submit" value="Add New Artist" class="submitButton"
                                   style='padding: 20px; border-radius: 20px; border: groove; cursor: pointer; margin-top: 7px'>
                        </td>
                    </tr>
                    *Required fields
                </table>

                <!-- Category -->
            </fieldset>
        </form>
    </div>


    <!-- ____________________________CHECK BOXES FOR USER TO SELECT THE CATEGORY TO SORT BY_____________________________ -->
    <div
        style="float: left; background-color: #ff6649; clear: left; border-radius: 20px; padding: 20px; margin-top: 15px; border: outset;">
        <form method="post" action="sortingPage.php"
              style="padding: 20px 20px 10px 20px; background-color: #fff6c0; border-radius: 20px; border: inset">
            <fieldset>
                <legend>Sort by category:</legend>
                <?php
                $sql = "SELECT * FROM CATEGORY;";
                foreach ($dbh->query($sql) as $row) {
                    echo "<input type='checkbox' name='$row[categoryName] CheckBox' value='$row[categoryName]' title='$row[categoryName]' class='categoryCheckbox' style='margin-top: 4px; cursor: pointer'><span style='margin-bottom: 2px'> $row[categoryName] </span><br />";
                    $index += 2;
                }


                ?>

                <input type="submit" title="SUBMIT" value="Sort" class="submitButton"
                       style='margin-left: 15%;  border-radius: 20px; border: groove; cursor: pointer; margin-top: 10px; padding: 10px 30px'>
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