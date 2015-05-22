

    <?php
        include "includes/headerALL.php";
        require "includes/databaseConnect.php";
        include "includes/phpFunctions.php";
    ?>



        <div class="Content">
            <?php
                $noticeID = $_POST['noticeID'];
                $postType = $_POST['submit'];




                if ($postType == 'Edit') {

                    // user (or admin) chose to edit own notice
                    if ($_SESSION['loginState'] == 'Logged in'
                        && ($_SESSION['userEmail'] == $_POST['userEmail'])
                        || ($_SESSION['userType'] == 'admin')) {

                        $getNoticeInfoSQL = 'SELECT noticeID, noticeTitle, noticeSummary, noticeDesc, noticeLink, noticeImg, userEmail, strftime( "%d-%m-%Y", date("noticeDate")) AS "theDate" FROM NOTICE WHERE noticeID="' . $noticeID . '";';

                        foreach($dbh->query($getNoticeInfoSQL) as $notice) {
                            echo "<h2>";
                            echo "Edit Notice";
                            echo "</h2>";

                            echo "<a href='notices.php'><button>&nwarhk; All Notices</button></a>";
                            echo "<hr>";

                            echo "<form id='editNoticeForm' method='POST' action='' enctype='multipart/form-data'>";

                            echo "<label for='noticeTitle'>Title: </label>";
                            echo "<input type='text' maxlength='45' name='noticeTitle' size='45' value='";
                            echo $notice['noticeTitle'];
                            echo "' />";
                            echo "<br />";
                            echo "<br />";


                            echo "<label for='noticeSummary'>Summary: </label>";
                            echo "<br>";
                            echo "<textarea form='editNoticeForm' rows=2 cols=100 maxlength='200' name='noticeSummary' size='45'>";
                            echo $notice['noticeSummary'];
                            echo "</textarea>";
                            echo "<br />";
                            echo "<br />";




                            echo "<label for='noticeDesc'>Notice Content: </label>";
                            echo "<br>";
                            echo "<textarea form='editNoticeForm' rows=10 cols=100 maxlength='1000' name='noticeDesc' size='45'>";
                            echo $notice['noticeDesc'];
                            echo "</textarea>";


                            echo "<br>";
                            echo "<br>";


                            echo "<label for='noticeLink'>Link: </label>";
                            echo "<input type='text' id='noticeLink' name='noticeLink' size='45' value='";
                            echo $notice['noticeLink'];
                            echo "' />";

                            echo "<br />";
                            echo "<br />";

                            //Image
                            echo "<img class='imgBorder' src='images/noticeThumbnail/";
                            echo $notice['noticeImg'];
                            echo "' id='noticeImg'/>";
                            echo "<input type='file' name='fileToUpload' id='fileToUpload' style='cursor: pointer'>";




                            echo "<input type='hidden' name='userEmail' value='";
                            echo $notice['userEmail'];
                            echo "' />";

                            echo "<input type='hidden' name='noticeID' value='";
                            echo $noticeID;
                            echo "' />";

                            echo "<hr>";
                            echo "<input type='submit' name='submit' value='Save Changes' />";


                            echo "</form>";
                        }

                    } else {
                        // user landed on page without permission
                        echo "<h3>";
                        echo "Uh-oh!";
                        echo "</h3>";
                        echo "<hr>";
                        echo "<p>You do not have permission to edit that notice</p>";
                    }

                } else if ($postType == 'Save Changes') {

                    $editNoticeSQL = "UPDATE NOTICE SET ";
                    $editNoticeEndSQL = "WHERE noticeID='" . $noticeID . "';";



                    // user hit 'Save Changes' button from edit form
                    if ($_SESSION['loginState'] == 'Logged in'
                        && ($_SESSION['userEmail'] == $_POST['userEmail'])
                        || ($_SESSION['userType'] == 'admin')) {


                        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === 0) {
                            uploadImage2("fileToUpload");
                            $noticeImg = basename($_FILES['fileToUpload']['name']);
                            $noticeImg = htmlspecialchars($noticeImg, ENT_QUOTES, ENT_NOQUOTES);
                        } else {
                            echo "Error Code: " . $_FILES['fileToUpload']['error'];
                            $noticeImg = 'defaultImage.jpg';
                            $noticeImg = htmlspecialchars($noticeImg, ENT_QUOTES, ENT_NOQUOTES);

                        }



                        $editNoticeSQL .= "noticeTitle='" . $_POST['noticeTitle'] . "', ";
                        $editNoticeSQL .= "noticeSummary='" . $_POST['noticeSummary'] . "', ";
                        $editNoticeSQL .= "noticeDesc='" . $_POST['noticeDesc'] . "', ";
                        $editNoticeSQL .= "noticeLink='" . $_POST['noticeLink'] . "', ";
                        $editNoticeSQL .= "noticeImg='" . $noticeImg . "' ";
                        $editNoticeSQL .= $editNoticeEndSQL;

                        $dbh->exec($editNoticeSQL);

                        echo "<h3>";
                        echo "Notice edited successfully!";
                        echo "</h3>";
                    } else {

                        // user landed on page without permission
                        echo "<h3>";
                        echo "Uh-oh!";
                        echo "</h3>";
                        echo "<hr>";
                        echo "<p>You do not have permission to edit that notice</p>";

                    }

                    echo "<a href='notices.php'><button>&nwarhk; All Notices</button></a>";



                } else if ($postType == 'Delete') {

                    // user (or admin) chose to delete own notice

                    $deleteNoticeSQL = 'DELETE FROM NOTICE WHERE noticeID="';
                    $deleteNoticeSQL .= $noticeID;
                    $deleteNoticeSQL .= '";';


                    if ($_SESSION['loginState'] == 'Logged in'
                        && ($_SESSION['userEmail'] == $_POST['userEmail'])
                        || ($_SESSION['userType'] == 'admin')) {

                        $dbh->exec($deleteNoticeSQL);
                        echo "<h3>";
                        echo "Notice deleted successfully!";
                        echo "</h3>";
                    } else {
                        // user landed on page without permission
                        echo "<h3>";
                        echo "Uh-oh!";
                        echo "</h3>";
                        echo "<hr>";
                        echo "<p>You do not have permission to delete that notice</p>";
                    }

                    echo "<a href='notices.php'><button>&nwarhk; All Notices</button></a>";






                }






            ?>







        </div>
    </div>
</body>
</html>
