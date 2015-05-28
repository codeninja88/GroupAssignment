
    <?php
        require "includes/databaseConnect.php";


        $postType = $_POST['submitBttn'];






        if (($_SESSION['loginState'] == 'Logged in')
            && ($_SESSION['userType'] == 'admin')) {

            if ($postType != 'Change Artist') {
                echo "<form action='' method='POST'>";
                echo "<input type='submit' name='submitBttn' value='Change Artist'/>";
                echo "</form>";
            }




            if ($postType == 'Change Artist') {
                $getArtistListSQL = "SELECT artistGroup, artistID, artistIsFeatured FROM ARTIST ORDER BY artistGroup ASC;";

                echo "<form action='' method='POST'>";

                foreach($dbh->query($getArtistListSQL) as $artist) {
                    echo "<input type='radio' name='artistID' value='";
                    echo $artist['artistID'];
                    echo "' ";
                    if ($artist['artistIsFeatured'] == 'y') {
                        echo "checked";
                    }
                    echo ">";
                    echo $artist['artistGroup'];
                    echo "<br />";
                }
                echo "<input type='submit' name='submitBttn' value='Set Artist' />";
                echo "</form>";
                echo "<br />";
                echo "<br />";


            } else if ($postType == 'Set Artist') {

                $removeFeaturedArtistSQL = 'UPDATE ARTIST SET artistIsFeatured="n" WHERE artistIsFeatured="y";';

                $setFeaturedArtistSQL = 'UPDATE ARTIST SET artistIsFeatured="y" WHERE artistID=';
                $setFeaturedArtistSQL .= $_POST['artistID'];
                $setFeaturedArtistSQL .= ';';

                $dbh->exec($removeFeaturedArtistSQL);
                $dbh->exec($setFeaturedArtistSQL);

            }

        }

        $featuredArtistSQL = "SELECT * FROM ARTIST WHERE artistIsFeatured='y';";




        foreach($dbh->query($featuredArtistSQL) as $row) {

            echo "<img alt='Featured Artist Image' class='imgBorder' src='images/musosThumbnail/";
            echo $row['artistImg'];
            echo "' alt='";
            echo $row['artistGroup'];
            echo "' style='width: 70%; height: auto;'>";
            echo "<br>";
            echo "<br>";
            echo "<strong>";
            echo $row['artistGroup'];
            echo "</strong>";
            echo "<br>";
            echo "<br>";
            echo $row['artistSummary'];
            echo "<br>";
            echo "<br>";
            echo "<a href='artistInfo.php?artistID=";
            echo $row['artistID'];
            echo "'>Read More</a>";

        }

        echo "</div>";
        echo "</div>";





   ?>
