

    <?php
        include "includes/headerALL.php";
        require "includes/databaseConnect.php";
        include "includes/phpFunctions.php";
    ?>



<div class="Content">



<?php
	// perform query
	$artistID = $_GET['artistID'];
    $sql = "SELECT * FROM ARTIST WHERE artistID='";
    $sql .= $artistID;
    $sql .= "';";
    $userEmail = "";
    $getType = $_GET['submitBttn'];
    $postType = $_POST['submitBttn'];
    $categorySql = "SELECT CATEGORY.categoryName FROM CATEGORY, ARTIST, ARTIST_CATEGORY WHERE CATEGORY.categoryName = ARTIST_CATEGORY.categoryName AND ARTIST_CATEGORY.artistID = ARTIST.artistID AND ARTIST.artistID = '". $artistID . "' GROUP BY CATEGORY.categoryName;";



    //CHECK for viewing mode
    if (($postType != 'Edit') && ($postType != 'Save') && ($postType != 'Add') && ($postType != 'Delete')) {

        //NORMAL VIEWING MODE

        foreach ($dbh->query($sql) as $row) {



            //Header
            echo "<div id='artistInfoHeader'>";
            echo '<h2>' . $row['artistGroup'] . '</h2>';
            echo "<a href='artists.php'><button>&nwarhk; All Artists</button></a>";
            echo '<hr>';
            echo "</div>";





            echo "<div id='artistInfoMiddleLeft' style=' float:left; width:50%;'>";
            if ($row['artistImg'] != null) {
                echo "<label for='artistImg'><a href='images/" . $row['artistImg'] . "'>Enlarge</a></label>";
                echo "<br/>";

                echo "<img class='imgBorder' src='images/musosThumbnail/";
                echo $row['artistImg'];
                echo "' id='artistImg'/>";


            }
            else {
                echo "<img class='imgBorder' src='images/musosThumbnail/defaultThumbnail.png'/>";
            }

            echo "</div>";



            //description
                echo $row['artistDesc'];

            echo "<table style='padding:10px; border:solid 1px;'>";

            if ($row['artistPhone'] != null) {
                echo "<tr>";
                echo "<td><strong>Phone:</strong></td>";
                echo "<td>";
                echo $row['artistPhone'];
                echo "</td>";
                echo "</tr>";
            }

            if ($row['artistEmail'] != null) {

                echo "<tr>";
                echo "<td><strong>Email:</strong></td>";
                echo "<td>";
                echo "<a href='mailto:" . $row['artistEmail'] . "?Subject=General%20Enquiry'>" . $row['artistEmail'] . "</a>";
                echo "</td>";
                echo "</tr>";

            }

            if ($row['artistWeb'] != null) {
                echo "<tr>";
                echo "<td><strong>Web:</strong></td>";
                echo "<td>";
                echo "<a href='";
                echo $row['artistWeb'];
                echo "'>";
                echo $row['artistWeb'];
                echo "</a>";
                echo "</td>";
                echo "</tr>";
            }

            // show categories for selected artist
                echo "<tr>";
                echo "<td><strong>Categories:</strong></td>";
                echo "<td>";

                //get all categories associated with artist
                $categorySql = "SELECT CATEGORY.categoryName FROM CATEGORY, ARTIST, ARTIST_CATEGORY WHERE CATEGORY.categoryName = ARTIST_CATEGORY.categoryName AND ARTIST_CATEGORY.artistID = ARTIST.artistID AND ARTIST.artistID = '". $artistID . "' GROUP BY CATEGORY.categoryName;";

                $count = 0;
                foreach($dbh->query($categorySql) as $category) {
                    $count = $count + 1;
                }

                foreach($dbh->query($categorySql) as $category) {
                    echo $category['categoryName'];
                    $count = $count-1;
                    if ($count != 0) {
                        echo ", ";
                    }
                }

                echo "</td>";
                echo "</tr>";
            echo "</table>";

            echo "<form method='POST' action='' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='artistID' value='" . $artistID . "'>";


            //get userEmail value from USER_ARTIST where artistID matches
            $getUserEmailSQL = "SELECT * FROM USER_ARTIST WHERE artistID=";
            $getUserEmailSQL .= $artistID;
            $getUserEmailSQL .= ";";
            foreach($dbh->query($getUserEmailSQL) as $row) {
                $userEmail = $row['userEmail'];
            }

            if (($_SESSION['loginState'] == 'Logged in')
                && ((($_SESSION['userEmail'] == $userEmail)
                && ($_SESSION['userType'] == 'paid'))
                || ($_SESSION['userType'] == 'admin'))) {
                echo "<input type='submit' name='submitBttn' value='Edit'/>";
                echo "<input type='submit' name='submitBttn' value='Delete'/>";
            }



            echo "</form>";

            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";

        }


    }
    else if (($postType == 'Edit') || ($postType == 'Add')) {

        if ($postType == 'Add') {
            if ($_POST['newCategory'] != '') {
                //add category before loading fields
                $addCategorySQL = "INSERT INTO CATEGORY (categoryName) VALUES ('";
                $addCategorySQL .= ucwords($_POST['newCategory']);
                $addCategorySQL .= "');";
                $dbh->exec($addCategorySQL);
            }
        }

        //EDIT MODE
        foreach ($dbh->query($sql) as $row) {
	        //Header
            echo "<div id='artistInfoHeader'>";
            echo '<h2>' . $row['artistGroup'] . '</h2>';
            echo "<h4 style='text-align:center;'><i>[EDIT MODE]</i></h2>";
            echo '<hr>';
            echo "</div>";

            echo "<form id='artistEditForm' method='POST' action='' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='artistID' value='" . $artistID . "'>";
            echo "<table>";

            //Summary
            echo "<tr>";
            echo "<td>Summary</td>";
            echo "<td>";
            echo "<textarea form='artistEditForm' style='width:400px;' name='artistSummary' id='summaryField'>" . $row['artistSummary'] . "</textarea>";
            echo "</td>";
            echo "</tr>";

            //Description
            echo "<tr>";
            echo "<td>Description</td>";
            echo "<td>";
            echo "<textarea form='artistEditForm' style='width:400px;' name='artistDesc' id='descField'>" . $row['artistDesc'] . "</textarea>";
            echo "</td>";
            echo "</tr>";

            //Description
            echo "<tr>";
            echo "<td>Phone</td>";
            echo "<td>";
            echo "<input type='text' size='50' id='phoneField' name='artistPhone' value='" . $row['artistPhone'] . "'>";
            echo "</td>";
            echo "</tr>";

            //Email
            echo "<tr>";
            echo "<td>Email</td>";
            echo "<td>";
            echo "<input type='text' size='50' id='emailField' name='artistEmail' value='" . $row['artistEmail'] . "'>";
            echo "</td>";
            echo "</tr>";

            //Web
            echo "<tr>";
            echo "<td>Web</td>";
            echo "<td>";
            echo "<input type='text' size='50' id='webField' name='artistWeb' value='" . $row['artistWeb'] . "'>";
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
               $isChecked = false;

                   foreach ($dbh->query($categorySql) as $selected) {
                       if ($selected == $category) {
                           //tick box during creation
                           $isChecked = true;
                           break;
                       }
                   }

                   echo "<td style='padding:2px; padding-right:10px;'>";
                   echo "<input value='";
                   echo $category['categoryName']; //value
                   echo "' type='checkbox' class='catClass' name='";
                   echo $category['categoryName']; //name
                   echo "'";
                   if ($isChecked) {
                       echo " checked";
                   }
                   echo "/>";
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
            echo "<img class='imgBorder' src='images/musosThumbnail/";
            echo $row['artistImg'];
            echo "' id='artistImg'/>";
            echo "<input type='file' name='fileToUpload' id='fileToUpload' style='cursor: pointer'>";



            echo "<hr>";


            echo "<input type='submit' name='submitBttn' value='Save'>";

            echo "</form>";
        }

        $dbh = null;

    }
    else if ($postType == 'Save') {

        $updateSqlSTART = "UPDATE ARTIST SET ";
        $updateSqlEND = " WHERE artistID='" . $artistID . "';";

        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === 0) {
            uploadImage("fileToUpload");
            $artistImg = basename($_FILES['fileToUpload']['name']);
            $artistImg = htmlspecialchars($artistImg, ENT_QUOTES, ENT_NOQUOTES);
            $updateSql = $updateSqlSTART . "artistImg='" . $artistImg . "'" . $updateSqlEND;
            $dbh->exec($updateSql);

        } else {
        echo "Error Code: " . $_FILES['fileToUpload']['error'];
            $artistImg = 'defaultImage.jpg';
            $artistImg = htmlspecialchars($artistImg, ENT_QUOTES, ENT_NOQUOTES);

        }

        echo "<a href='artists.php'><button>&nwarhk; All Artists</button></a>";
        echo "<a href='artistInfo.php?artistID=";
        echo $artistID;
        echo "'><button>&nwarhk; Back to Artist</button></a>";





       $updateSql = $updateSqlSTART . "artistSummary='" . $_POST['artistSummary'] . "'" . $updateSqlEND;
       $dbh->exec($updateSql);


       $updateSql = $updateSqlSTART . "artistDesc='" . $_POST['artistDesc'] . "'" . $updateSqlEND;
       $dbh->exec($updateSql);

       $updateSql = $updateSqlSTART . "artistEmail='" . $_POST['artistEmail'] . "'" . $updateSqlEND;
       $dbh->exec($updateSql);

       $updateSql = $updateSqlSTART . "artistPhone='" . $_POST['artistPhone'] . "'" . $updateSqlEND;
       $dbh->exec($updateSql);

       $updateSql = $updateSqlSTART . "artistWeb='" . $_POST['artistWeb'] . "'" . $updateSqlEND;
       $dbh->exec($updateSql);

        // remove all links between categoryName and artistID
        $removeCategorySQL = "DELETE FROM ARTIST_CATEGORY WHERE artistID='";
        $removeCategorySQL .= $artistID;
        $removeCategorySQL .= "';";
        $dbh->exec($removeCategorySQL);

        //check each category in db to see if it is in the get request (ie. ticked)
        $sqlGetCategories = 'SELECT * FROM CATEGORY ORDER BY categoryName ASC;';

        foreach ($dbh->query($sqlGetCategories) as $categoryName) {
            //create string version of category name that $_POST will recognise
            $currCategory = str_replace(' ','_',$categoryName['categoryName']);

            if (array_key_exists($currCategory, $_POST)) {
                //category was ticked in edit page
                $insertCategorySQL = "INSERT INTO ARTIST_CATEGORY (artistID, categoryName) VALUES (";
                $insertCategorySQL .= "'" . $artistID . "', ";
                $insertCategorySQL .= "'" . $categoryName['categoryName'] . "');";
                $dbh->exec($insertCategorySQL);
            }
        }

        echo "<br />";
        echo "Changes Saved Successfully!";
        echo "<br />";


    } else if ($postType == 'Delete') {

    // add artist to USER_ARTIST bridging table
        $deleteUserArtistEntrySQL = "DELETE FROM USER_ARTIST WHERE artistID=";
        $deleteUserArtistEntrySQL .= $artistID;
        $deleteUserArtistEntrySQL .= ";";




        $delete1SQL = "DELETE FROM ARTIST_CATEGORY WHERE artistID='";
        $delete1SQL .= $artistID;
        $delete1SQL .= "';";

        $delete2SQL = "DELETE FROM ARTIST WHERE artistID='";
        $delete2SQL .= $artistID;
        $delete2SQL .= "';";

        $dbh->exec($delete1SQL);
        $dbh->exec($delete2SQL);
        $dbh->exec($deleteUserArtistEntrySQL);


        echo "<h3>Artist deleted Successfully</h3>";
        echo "<hr>";
        echo "<a href='artists.php'><button>&nwarhk; All Artists</button></a>";

    } else {
        echo "Uh-Oh!<br />There was an error...";
    }
   $dbh = null;


?>




</div>
</body>
</html>
