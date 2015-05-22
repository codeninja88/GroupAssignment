

    <?php
        include "includes/headerALL.php";
        require "includes/databaseConnect.php";
        include "includes/phpFunctions.php";
    ?>



        <div class="Content">
            <?php
                $noticeID = $_GET['noticeID'];
                $getType = $_GET['submitBttn'];
                $postType = $_POST['submitBttn'];



                if ($getType != "showByID") {

                    // page called from navigation bar (shows all notices)

                    echo "<h2>Notices</h2>";
                    echo "<hr>";


                    $getAllNoticesSQL = 'SELECT noticeID, noticeTitle, noticeSummary, noticeDesc, noticeLink, noticeImg, strftime( "%d-%m-%Y", date("noticeDate")) AS "theDate" FROM NOTICE WHERE noticeExpire > date("now") ORDER BY date("noticeDate") DESC;';


                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Date Posted</th>";
                    echo "<th>Notice Title</th>";
                    echo "</tr>";
                    foreach($dbh->query($getAllNoticesSQL) as $notice) {

                        echo "<tr >";

                        echo "<td style='width:100px; padding:10px'>";
                        echo $notice['theDate'];
                        echo "</td>";

                        echo "<td>";
                        echo "<a href='notices.php?noticeID=";
                        echo $notice['noticeID'];
                        echo "&&submitBttn=showByID";
                        echo "'>";
                        echo $notice['noticeTitle'];
                        echo "</a>";
                        echo "</td>";

                        echo "<td>";

                        echo "</td>";

                        echo "<tr>";
                    }

                    echo "</table>";







                } else {

                    // individual notice selected for viewing


                    $getNoticeInfoSQL = 'SELECT noticeID, noticeTitle, noticeSummary, noticeDesc, noticeLink, noticeImg, strftime( "%d-%m-%Y", date("noticeDate")) AS "theDate" FROM NOTICE WHERE noticeID="' . $noticeID . '";';
                    foreach($dbh->query($getNoticeInfoSQL) as $row) {
                        echo "<h2>";
                        echo $row['noticeTitle'];
                        echo "</h2>";
                        echo "<p id='noticeInfoDate'>Posted ";
                        echo $row['theDate'];
                        echo "</p>";
                        echo "<a href='notices.php'><button>&nwarhk; All Notices</button></a>";

                        echo "<hr>";

                        if ($_SESSION['loginState'] == 'Logged in'
                        && ($_SESSION['userEmail'] == $row['userEmail'])
                        || ($_SESSION['userType'] == 'admin')) {

                            // user is logged in and either the creater or admin

                            echo "<form id='editDeleteNotice' action='noticesEdit.php' method='POST' enctype='multipart/form-data'>";
                            echo "<input type='hidden' name='noticeID' value='";
                            echo $row['noticeID'];
                            echo "' />";
                            echo "<input type='hidden' name='userEmail' value='";
                            echo $row['userEmail'];
                            echo "' />";
                            echo "<input type='submit' name='submit' value='Edit' />";
                            echo "<input type='submit' name='submit' value='Delete' />";

                            echo "</form>";

                            echo "<br />";
                        }


                        if ($row['noticeImg'] != null && $row['noticeImg'] != "") {
                            echo "<div id='noticeInfoLeft' style=' float:left; width:50%;'>";
                            echo "<img class='imgBorder' src='images/noticeThumbnail/";
                            echo $row['noticeImg'];
                            echo "' id='noticeImg'/>";
                            echo "</div>";
                        }
                        echo $row['noticeDesc'];

                        if ($row['noticeLink'] != "") {
                            echo "<br />";
                            echo "<br />";
                            echo "<a href='";
                            echo $row['noticeLink'];
                            echo "'>";
                            echo "Find Out More!";
                            echo "</a>";
                        }


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






            ?>







        </div>
    </div>
</body>
</html>
