

    <?php
        include "includes/headerALL.php";
        require "includes/databaseConnect.php";
        include "includes/phpFunctions.php";
    ?>



<div class="Content">



<?php

if (($_SERVER['REQUEST_METHOD'] === 'GET') || ($_POST['submitBttn'] === 'Add')) {
    //page loaded from artist.php


    //update categories before loading rest of page
    if ($_POST['submitBttn'] === 'Add') {
        if ($_POST['newCategory'] != '') {
            //add category before loading fields
            $addCategorySQL = "INSERT INTO CATEGORY (categoryName) VALUES ('";
            $addCategorySQL .= ucwords($_POST['newCategory']);
            $addCategorySQL .= "');";
            $dbh->exec($addCategorySQL);
        }
    }


    echo "<div id='artistInfoHeader'>";
    echo '<h2>Add New Artist</h2>';
    echo "<a href='artists.php'><button>&nwarhk; All Artists</button></a>";
    echo '<hr>';
    echo "</div>";

    if ($_SESSION['loginState'] == 'Logged in') {
        if ($postType == 'Add') {
            if ($_POST['newCategory'] != '') {
                //add category before loading fields
                $addCategorySQL = "INSERT INTO CATEGORY (categoryName) VALUES ('";
                $addCategorySQL .= ucwords($_POST['newCategory']);
                $addCategorySQL .= "');";
                $dbh->exec($addCategorySQL);
            }
        }

        echo "<form id='artistAddForm' method='POST' action='' enctype='multipart/form-data'>";

        echo "<table>";

        //GroupName
        echo "<tr>";
        echo "<td>Artist Name</td>";
        echo "<td>";
        echo "<input type='text' size='50' id='artistGroup' name='artistGroup'>";
        echo "</td>";
        echo "</tr>";


        //Summary
        echo "<tr>";
        echo "<td>Summary</td>";
        echo "<td>";
        echo "<textarea form='artistAddForm' style='width:400px;' name='artistSummary' id='summaryField'></textarea>";
        echo "</td>";
        echo "</tr>";

        //Description
        echo "<tr>";
        echo "<td>Description</td>";
        echo "<td>";
        echo "<textarea form='artistAddForm' style='width:400px;' name='artistDesc' id='descField'></textarea>";
        echo "</td>";
        echo "</tr>";

        //Phone
        echo "<tr>";
        echo "<td>Phone</td>";
        echo "<td>";
        echo "<input type='text' size='50' id='phoneField' name='artistPhone'>";
        echo "</td>";
        echo "</tr>";

        //Email
        echo "<tr>";
        echo "<td>Email</td>";
        echo "<td>";
        echo "<input type='text' size='50' id='emailField' name='artistEmail'>";
        echo "</td>";
        echo "</tr>";

        //Web
        echo "<tr>";
        echo "<td>Web</td>";
        echo "<td>";
        echo "<input type='text' size='50' id='webField' name='artistWeb'>";
        echo "</td>";
        echo "</tr>";





        //Categories
        echo "<tr>";
        echo "<td>Categories</td>";
        echo "<td id='categoryField'>";


        $sqlGetCategories = 'SELECT * FROM CATEGORY ORDER BY categoryName ASC;';
        $rowCounter = 0;
        echo "<table>";
        foreach($dbh->query($sqlGetCategories) as $category) {
            if ($rowCounter == 0) {
               echo "<tr>";
            }
            if ($rowCounter < 4) {
               echo "<td style='padding:2px; padding-right:10px;'>";
               echo "<input value='";
               echo $category['categoryName']; //value
               echo "' type='checkbox' class='catClass' name='";
               echo $category['categoryName']; //name
               echo "'/>";
               echo $category['categoryName']; //text displayed
               echo "</td>";
               $rowCounter = $rowCounter + 1;
            }
            if ($rowCounter == 3) {
               echo "</tr>";
               $rowCounter = 0;
            }
        }

        echo "</table>";


        echo "</td>";
        echo "<td>";

        echo "<input type='text' name='newCategory'>";
        echo "<br />";
        echo "<input type='submit' name='submitBttn' value='Add'>";

        echo "</td>";
        echo "</tr>";
        echo "</table>";





        //Image
        echo "<img class='imgBorder' src='images/musosThumbnail/defaultThumbnail.png' id='artistImg'/>";
        echo "<input type='file' name='fileToUpload' id='fileToUpload' style='cursor: pointer'>";



        echo "<hr>";


        echo "<input type='submit' name='submitBttn' value='Save'>";

        echo "</form>";

    } else {
        // user came to page without permission
        echo "<h3>Uh oh!</h3>";

        echo "<p>You need to be a registered member to add an artist.</p>";
        echo "<p>If you are not registered you can ";
        echo "<a href='members.php' >Sign Up</a>";
        echo " for free!</p>";
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //page loaded from submit button on same page

    $newArtistSQL = "INSERT INTO ARTIST (artistGroup, artistSummary, artistDesc, artistEmail, artistPhone, artistWeb, artistImg) VALUES (";
    $newArtistEndSQL = ");";

    if ($_SESSION['loginState'] == 'Logged in') {
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === 0) {
            uploadImage("fileToUpload");
            $artistImg = basename($_FILES['fileToUpload']['name']);
            $artistImg = htmlspecialchars($artistImg, ENT_QUOTES, ENT_NOQUOTES);
        } else {
        echo "Error Code: " . $_FILES['fileToUpload']['error'];
            $artistImg = 'defaultImage.jpg';
            $artistImg = htmlspecialchars($artistImg, ENT_QUOTES, ENT_NOQUOTES);

        }

        echo "<a href='artists.php'><button>&nwarhk; All Artists</button></a>";

        $newArtistSQL .= "'" . $_POST['artistGroup'] . "', ";
        $newArtistSQL .= "'" . $_POST['artistSummary'] . "', ";
        $newArtistSQL .= "'" . $_POST['artistDesc'] . "', ";
        $newArtistSQL .= "'" . $_POST['artistEmail'] . "', ";
        $newArtistSQL .= "'" . $_POST['artistPhone'] . "', ";
        $newArtistSQL .= "'" . $_POST['artistWeb'] . "', ";
        $newArtistSQL .= "'" . $artistImg . "'";
        $newArtistSQL .= $newArtistEndSQL;



        $dbh->exec($newArtistSQL);


        $getArtistID = "SELECT artistID FROM ARTIST WHERE artistGROUP='";
        $getArtistID .= $_POST['artistGroup'];
        $getArtistID .= "'";
        $artistID = '';
        foreach($dbh->query($getArtistID) as $row) {
            $artistID = $row['artistID'];
        }



        //check each category in db to see if it is in the get request (ie. ticked)
        $sqlGetCategories = 'SELECT * FROM CATEGORY ORDER BY categoryName ASC;';

        foreach ($dbh->query($sqlGetCategories) as $categoryName) {
            //create string version of category name that $_POST will recognise
            $currCategory = str_replace(' ','_',$categoryName['categoryName']);

            if (array_key_exists($currCategory, $_POST)) {
                //category was ticked
                $insertCategorySQL = "INSERT INTO ARTIST_CATEGORY (artistID, categoryName) VALUES (";
                $insertCategorySQL .= "'" . $artistID . "', ";
                $insertCategorySQL .= "'" . $categoryName['categoryName'] . "');";
                $dbh->exec($insertCategorySQL);
            }
        }


        // add artist to USER_ARTIST bridging table
        $addToUserArtistSQL = "INSERT INTO USER_ARTIST (userEmail, artistID) VALUES ('";
        $addToUserArtistSQL  .= $_SESSION['userEmail'];
        $addToUserArtistSQL  .= "',";
        $addToUserArtistSQL  .= $artistID;
        $addToUserArtistSQL  .= " );";
        $dbh->exec($addToUserArtistSQL);


        echo "<br />";
        echo "Changes Saved Successfully!";
        echo "<br />";
    } else {
       // user came to page without permission
        echo "<h3>Uh oh!</h3>";

        echo "<p>You need to be a registered member to add an artist.</p>";
        echo "<p>If you are not registered you can ";
        echo "<a href='members.php' >Sign Up</a>";
        echo " for free!</p>";
    }

} else {
    echo "ERROR: request method unknown";
}


   $dbh = null;


?>




</div>
</body>
</html>
