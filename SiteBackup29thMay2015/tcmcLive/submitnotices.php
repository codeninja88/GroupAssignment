

    <?php
        include "includes/headerALL.php";
        require "includes/databaseConnect.php";
        include "includes/phpFunctions.php";
    ?>




        <div class="Content">


            <?php
                if ($_POST['submit'] != 'Add Notice') {

                // Show form with fields to add new notice

                    if ($_SESSION['loginState'] == 'Logged in') {

                        // user logged in successfully with permission to add notices

                        echo "<h2>Add Notice</h2>";
                        echo "<hr>";

                        echo "<p style='text-align:center'><i>NOTE: notices will expire after 3 months</i></p>";

                        echo "<form id='addNotice' action='' method='POST' enctype='multipart/form-data'>";
                            echo "<br>";


                            echo "<label for='noticeTitleArea'>Title:</label>";
                            echo "<br>";
                            echo "<input id='noticeTitleArea' type='text' name='noticeTitle' size='45' maxlength='45' placeholder=' Eg. Music Festival'>";
                            echo "<br>";
                            echo "<br>";


                            echo "<label for='noticeSummaryArea'>Summary:</label>";
                            echo "<br>";
                            echo "<textarea id='noticeSummaryArea' form='addNotice' name='noticeSummary' rows=2 cols=100 maxlength='200' placeholder=' Eg. Come one come all to the Music festival...'></textarea>";
                            echo "<br>";
                            echo "<br>";


                            echo "<label for='noticeContentArea'>Notice Content:</label>";
                            echo "<br>";
                            echo "<textarea id='noticeContentArea' form='addNotice' name='noticeDesc' rows=10 cols=100 maxlength='1000' placeholder=' Eg. Come one come all to the Music festival...'></textarea>";
                            echo "<br>";
                            echo "<br>";


                            echo "<label for='noticeLink'>Link: </label>";
                            echo "<input type='text' id='noticeLink' name='noticeLink' size='45' placeholder=' http://www.example.com'>";

                            echo "<br />";
                            echo "<br />";

                            //Image
                            echo "<img alt='Notice Image' class='imgBorder' src='images/musosThumbnail/defaultThumbnail.png' id='noticeImg'/>";
                            echo "<input type='file' name='fileToUpload' id='fileToUpload' style='cursor: pointer'>";



                            echo "<hr>";

                            echo "<br>";
                            echo "<input type='submit' name='submit' value='Add Notice'>";


                        echo "</form>";

                    } else {

                        // user is not logged in and cannot add notices

                        echo "<h3>Uh oh!</h3>";
                        echo "<hr>";

                        echo "<p>You need to be a registered member to add a notice.</p>";

                        echo "<p>If you are not registered you can ";
                        echo "<a href='members.php' >Sign Up</a>";
                        echo " for free!</p>";

                    }


                } else if ($_POST['submit'] == 'Add Notice') {

                    // user filled out form and hit the submit button add to DB

                    if ($_SESSION['loginState'] == 'Logged in') {



                        $addNoticeSQL = "INSERT INTO NOTICE (noticeTitle, noticeSummary, noticeDesc, noticeLink, noticeImg, userEmail, noticeDate, noticeExpire) VALUES (";
                        $addNoticeEndSQL = ");";
                        //
                        //     echo "<pre>";
                        //     print_r($_POST);
                        //     print_r($_FILES);
                        //     echo "</pre>";
                        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === 0) {
                            uploadImage2("fileToUpload");
                            $noticeImg = basename($_FILES['fileToUpload']['name']);
                            $noticeImg = htmlspecialchars($noticeImg, ENT_QUOTES, ENT_NOQUOTES);
                        } else {
//                             echo "Error Code: " . $_FILES['fileToUpload']['error'];
                            $noticeImg = 'defaultThumbnail.png';
                            $noticeImg = htmlspecialchars($noticeImg, ENT_QUOTES, ENT_NOQUOTES);

                        }


                        $addNoticeSQL .= "'" . $_POST['noticeTitle'] . "', ";
                        $addNoticeSQL .= "'" . $_POST['noticeSummary'] . "', ";
                        $addNoticeSQL .= "'" . $_POST['noticeDesc'] . "', ";
                        $addNoticeSQL .= "'" . $_POST['noticeLink'] . "', ";
                        $addNoticeSQL .= "'" . $noticeImg . "', ";
                        $addNoticeSQL .= "'" . $_SESSION['userEmail'] . "', ";
                        $addNoticeSQL .= 'strftime("%Y-%m-%d", "now"), ';
                        $addNoticeSQL .= 'strftime("%Y-%m-%d","now", "+3 month") ';

                        $addNoticeSQL .= $addNoticeEndSQL;

                        $dbh->exec($addNoticeSQL);



                        echo "<h3>Notice Added Successfully</h3>";
                        echo "<hr>";
                        echo "<a href='notices.php'><button>&nwarhk; All Notices</button></a>";

                    } else {

                        // user is not logged in and cannot add notices

                        echo "<h3>Uh oh!</h3>";
                        echo "<hr>";

                        echo "<p>You need to be a registered member to add a notice.</p>";

                        echo "<p>If you are not registered you can ";
                        echo "<a href='members.php' >Sign Up</a>";
                        echo " for free!</p>";



                    }


                }
            ?>
        </div>
</body>
</html>
