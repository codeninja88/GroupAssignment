<?php

    echo "<div id='notice'>";
    echo "Recent Notices";
    echo "</div>";

    echo "<div id='notices'>";

    echo "<a id='submit' href='submitnotices.php'>Add Notice</a><br>";
    echo "<p>";

//     get all notices in descending order
    $getAllNoticesSQL = 'SELECT noticeID, noticeTitle, noticeSummary, strftime( "%d-%m-%Y", date("noticeDate")) AS "theDate" FROM NOTICE ORDER BY date("noticeDate") DESC;';
    $noticeCount = 0;
    foreach($dbh->query($getAllNoticesSQL) as $notice) {
        if ($noticeCount < 3) {
            // show title
            echo "<div class='noticeDates'>";
            echo "<p>Posted ";
            echo $notice['theDate'];
            echo "</p>";
            echo "</div>";

            echo "<strong>";
            echo $notice['noticeTitle'];
            echo "</strong>";
            echo "<br><br>";

            echo $notice['noticeSummary'];
            echo "<br />";

            echo "<div class='noticeLink'>";


            echo "<a href='notices.php?noticeID=";
            echo $notice['noticeID'];
            echo "&&submitBttn=showByID";
            echo "'>Read more...</a>";
            echo "</div>";


            echo "<hr>";
            echo "<br />";


            $noticeCount = $noticeCount + 1;
        }
    }

    echo "</p>";
    echo "</div>";
?>