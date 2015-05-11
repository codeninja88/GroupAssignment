

    <?php
        include "includes/headerALL.php";
        require "includes/databaseConnect.php";
    ?>




        <div class="Content">
            <div id="artistContentHeader">
            <h2>Artists</h2>
        </div>

        <div id="artistMainContent">

            <div id="categoryDiv">

            <?php



                $sqlGetCategories = 'SELECT * FROM CATEGORY ORDER BY categoryName ASC;';

                echo "<form method='GET' action=''>";

                $rowCounter = 0;

                echo "<table>";





                foreach($dbh->query($sqlGetCategories) as $category) {
                    if ($rowCounter == 0) {
                        echo "<tr>";
                    }
                    if ($rowCounter < 5) {
                        echo "<td style='padding:2px; padding-right:10px;'>";
                        echo "<input value='";
                        echo $category['categoryName']; //value
                        echo "' type='checkbox' name='";
                        echo $category['categoryName'];
                        echo "'/>";
                        echo $category['categoryName']; //text displayed
                        echo "</td>";
                        $rowCounter = $rowCounter + 1;

                    }

                     if ($rowCounter == 4) {
                        echo "</tr>";
                        $rowCounter = 0;

                    }
                }

                echo "</table>";
                echo "<br />";
                echo "<input type='submit' value='Refine List'>";
                echo "</form>";
                echo "<br />";


            ?>

            </div>

            <div id="artistListDiv">
                <?php

                    $showing = '<b>Categories: </b>';

                    if (!empty($_GET)) {

                        //show selected categories
                        $arrayLength = count($_GET) - 1;

                            $sql = "SELECT * FROM ARTIST, ARTIST_CATEGORY, CATEGORY
                        WHERE ARTIST.artistID = ARTIST_CATEGORY.artistID AND
                        ARTIST_CATEGORY.categoryName = CATEGORY.categoryName AND (";

                            foreach ($_GET as $key => $value) {

                                $sql = $sql . "CATEGORY.categoryName = " . "'" . $value . "'";
                                $showing .= $value;

                                if ($arrayLength !== 0) {
                                    $sql .= " OR ";
                                    $showing .= ", ";
                                    $arrayLength--;
                                }
                            }
                            $sql .= ") GROUP BY ARTIST.artistID ORDER BY ARTIST.artistGroup ASC;";

                    } else {

                        // show all categories
                        $sql = ('SELECT * FROM ARTIST ORDER BY artistGroup ASC;');
                        $showing .= "All Categories";

                    }



                    echo "<i>" . $showing . "</i>";





                    echo '<table border="1">';

                    foreach ($dbh->query($sql) as $row) {
                        echo '<tr>';

                            //artistGroup
                            echo '<td>';
                            $anchor = "<a href='artistInfo.php?artistID=";
                            $anchor .= $row['artistID'];
                            $anchor .= "' class='artistList' id='";
                            $anchor .= $row['artistID'];
                            $anchor .= "'>";
                            $anchor .= $row['artistGroup'];
                            $anchor .= "</br></a>";
                            echo $anchor;
                            echo '</td>';

                            //artistSummary
                            echo '<td>';
                            echo $row['artistSummary'];
                            echo '</td>';

                            echo '<td>';
                            //artistImg
                            if ($row['artistImg'] != null) {
                                echo "<img src='images/musosThumbnail/";
                                echo $row['artistImg'];
                                echo "'/>";
                            } else {
                            echo "<img src='images/musosThumbnail/defaultThumbnail.png'/>";
                            }
                            echo '</td>';

                        echo '</tr>';

                    }
                    echo '</table>';



                ?>


            </div>
        </div>
    </div>
</body>
</html>
