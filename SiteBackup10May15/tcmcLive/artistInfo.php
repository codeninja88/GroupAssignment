

    <?php
        include "includes/headerALL.php";
        require "includes/databaseConnect.php";
    ?>



<div class="Content">



<?php
    //Connect to database

	// perform query
	$artistID = $_GET['artistID'];
    $sql = "SELECT * FROM ARTIST WHERE artistID='";
    $sql .= $artistID;
    $sql .= "';";
    $getType = $_GET['submitBttn'];
    $categorySql = "SELECT CATEGORY.categoryName FROM CATEGORY, ARTIST, ARTIST_CATEGORY WHERE CATEGORY.categoryName = ARTIST_CATEGORY.categoryName AND ARTIST_CATEGORY.artistID = ARTIST.artistID AND ARTIST.artistID = '". $artistID . "' GROUP BY CATEGORY.categoryName;";



    //CHECK for viewing mode
    if (($getType != 'Edit') && ($getType != 'Save')) {

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
//                 $categorySql = "SELECT CATEGORY.categoryName FROM CATEGORY, ARTIST, ARTIST_CATEGORY WHERE CATEGORY.categoryName = ARTIST_CATEGORY.categoryName AND ARTIST_CATEGORY.artistID = ARTIST.artistID AND ARTIST.artistID = '". $artistID . "' GROUP BY CATEGORY.categoryName;";

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

            echo "<form method='GET' action=''>";
            echo "<input type='hidden' name='artistID' value='" . $_GET['artistID'] . "'>";
            echo "<input type='submit' name='submitBttn' value='Edit'/>";
            echo "</form>";
        }


    }
    else if ($getType == 'Edit') {

        //EDIT MODE
        foreach ($dbh->query($sql) as $row) {
	        //Header
            echo "<div id='artistInfoHeader'>";
            echo '<h2>' . $row['artistGroup'] . '</h2>';
            echo "<h4 style='text-align:center;'><i>[EDIT MODE]</i></h2>";
            echo '<hr>';
            echo "</div>";

            echo "<form id='artistEditForm' method='GET' action=''>";
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


           // $sqlGetCategories = 'SELECT * FROM CATEGORY ORDER BY categoryName ASC;';
//            $rowCounter = 0;
//            echo "<table>";
//            foreach($dbh->query($sqlGetCategories) as $category) {
//                if ($rowCounter == 0) {
//                    echo "<tr>";
//                }
//                if ($rowCounter < 5) {
//                $isChecked = false;
//
//                    foreach ($dbh->query($categorySql) as $selected) {
//                        if ($selected == $category) {
//                            //tick box during creation
//                            $isChecked = true;
//                            break;
//                        }
//                    }
//
//                    echo "<td style='padding:2px; padding-right:10px;'>";
//                    echo "<input value='";
//                    echo $category['categoryName']; //value
//                    echo "' type='checkbox' class='catClass' name='";
//                    echo $category['categoryName']; //name
//                    echo "'";
//                    if ($isChecked) {
//                        echo " checked";
//                    }
//                    echo "/>";
//                    echo $category['categoryName']; //text displayed
//                    echo "</td>";
//                    $rowCounter = $rowCounter + 1;
//                }
//                 if ($rowCounter == 4) {
//                    echo "</tr>";
//                    $rowCounter = 0;
//                }
//            }

//            echo "</table>";


            echo "</td>";
            echo "</tr>";
            echo "</table>";

            //Image
            echo "<img class='imgBorder' src='images/musosThumbnail/";
            echo $row['artistImg'];
            echo "' id='artistImg'/>";


            echo "<hr>";


            echo "<input type='submit' name='submitBttn' value='Save'>";

            echo "</form>";
        }

        $dbh = null;

    }
    else if ($getType == 'Save') {

        echo "<a href='artists.php'><button>&nwarhk; All Artists</button></a>";


       $updateSqlSTART = "UPDATE ARTIST SET ";
       $updateSqlEND = " WHERE artistID='" . $artistID . "';";

       $updateSql = $updateSqlSTART . "artistSummary='" . $_GET['artistSummary'] . "'" . $updateSqlEND;
       $dbh->exec($updateSql);
//
       $updateSql = $updateSqlSTART . "artistDesc='" . $_GET['artistDesc'] . "'" . $updateSqlEND;
       $dbh->exec($updateSql);
//
       $updateSql = $updateSqlSTART . "artistEmail='" . $_GET['artistEmail'] . "'" . $updateSqlEND;
       $dbh->exec($updateSql);
//
       $updateSql = $updateSqlSTART . "artistPhone='" . $_GET['artistPhone'] . "'" . $updateSqlEND;
       $dbh->exec($updateSql);
//
       $updateSql = $updateSqlSTART . "artistWeb='" . $_GET['artistWeb'] . "'" . $updateSqlEND;
       $dbh->exec($updateSql);

       $dbh = null;


        // update categories (consider bridging table)



        echo "<br />";
        echo "Changes Saved Successfully!";
        echo "<br />";


    }
    else {
        echo "Uh-Oh!<br />There was an error...";
    }





?>




</div>
</body>
</html>
