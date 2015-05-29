<?php
session_start();
require_once("databaseConnect.php");
include_once "functions.php";
echo "<div class='Content'>";
echo "<h2>Events</h2>";
echo "<hr />";
if(isset($_SESSION['eventMessage'])){
    echo "<span id='eventMessage'>$_SESSION[eventMessage]</span>";
    $_SESSION['eventMessage'] = null;
}
$sql = "SELECT * FROM EVENT WHERE eventDate > DATE() ORDER BY eventDate;";

if($_SESSION['userType'] === 'admin'){
    echo "<form id='addEventForm' action='../tcmcLive/eventChangeProcessing.php' method='post' enctype='multipart/form-data'>";
    echo "<fieldset>";
    //Change the spacing
    //Make the text area larger and fixed.
    //Fix image resizing? Dont resize if they're below the threshold

    echo "<legend>Add an event</legend>";
    echo "<div class='leftMyAccountDiv'>";
    echo "Event Name*:<br />";
    echo "Event Date*:<br />";
    echo "Event Time*:<br />";
    echo "Event Location*:<br />";
    echo "Event Contact Name:<br />";
    echo "Event Contact Phone:<br />";
    echo "Event Desciption:<br />";
    echo "<div class='eventsPagePaddingDiv'></div>";
    echo "<br />Featuring:<br />";
    echo "Image:<br />";

    echo "</div>";

    echo "<div class='rightMyAccountDiv'>";
    echo "<input type='text' name='eventName' class='eventInputField' placeholder='Event Name' required><br />";
    echo "<input type='date' name='eventDate' class='eventInputField' required> <br />";
    echo "<input type='text' name='eventTime' class='eventInputField'placeholder='hh:mm' required> <br />";
    echo "<input type='text' name='eventLocation' class='eventInputField' placeholder='Event Location' required> <br />";
    echo "<input type='text' name='eventContactName' class='eventInputField' /> <br />";
    echo "<input type='text' name='eventPhone' class='eventInputField' /> <br />";
    echo "<textarea form='addEventForm' name='eventDesc' class='eventInputTextArea'> </textarea> <br />";
    echo "<select name='eventFeaturedArtist'>";
    echo "<option value=''>-----</option>";
    $featuringList = "SELECT artistID, artistGroup FROM ARTIST";
    foreach ($dbh->query($featuringList) as $row){
        echo "<option value='$row[artistID]'>$row[artistGroup]</option>";
    }

    echo "</select>";
    echo "<br />";

    echo "<input type='file' name='eventImage'> <br />";
    echo "<input type='submit' name='addEventSubmit'>";

    echo "</div>";
    echo "</fieldset>";
    echo "</form>";
}


foreach ($dbh->query($sql) as $row) {
    if ($_POST['edit'] === $row['eventID']) {
        echo "<a id='$row[eventID]'></a>";
        echo "<div class='editingDiv'><h3>**Editing**</h3></div>";
        echo "<div>";

        echo "<form id='editEventForm' action='../tcmcLive/eventChangeProcessing.php' method='post'>";
        echo "<input class='editEventTitle' type='text' name='eventName' value='$row[eventName]' /> ";
        echo "<input type='hidden' name='eventID' value='$row[eventID]' />";
        echo "<div class='eventInfoDiv'>";
        echo "<p><strong>Event Location: </strong> <input type='text' name='eventLocation' value='$row[eventLocation]'></p>";
        echo "<p><strong>Event Time: </strong> <input type='text' name='eventTime' value='$row[eventTime]' /></p>";
        echo "<p><strong>Event Date: </strong> <input type='date' name='eventDate' value='$row[eventDate]' /> </p> ";

        echo "<p><strong>Event Contact: </strong> <input type='text' name='eventPhone' value='$row[eventPhone]' /> </p>";

        if (isset($row['artistID']) && $row['artistID'] !== "") {
            echo "<p><strong>Featuring: </strong> <a href='../tcmcLive/artistInfo.php?artistID=$row[artistID]'>";
            $thisArtist = "SELECT artistGroup FROM ARTIST WHERE artistID =" . $row['artistID'];
            foreach ($dbh->query($thisArtist) as $artistName) {
                echo "$artistName[artistGroup]";
            }
            echo "</a></p></div>";

        }
        if (isset($row['eventImg']) && $row['eventImg'] !== "") {
            echo "<div class='eventImage'><img alt='Event image' src='../tcmcLive/images/eventImages/$row[eventImg]'></div><br>";
        }
        echo "<textarea name='eventDesc' class='eventEditingTextArea' form='editEventForm'>$row[eventDesc]</textarea></p>";
        echo "<input type='submit' name='Submit Changes' />";
        echo "</form>";

        echo "<div class='editingDiv'></div>";

    } else {
        $date = explode("-", $row[eventDate]);
        $time = explode(":", $row[eventTime]);
        if ($time[0] > 12) {
            if($time[1] == ""){
                $time[1] = "00";
            }
            $time = ($time[0] - 12) . ":" . $time[1] . " pm";
        } else {
            if($time[1] == ""){
                $time[1] = "00";
            }
            $time = $time[0] . ":" . $time[1] . " am";
        }
        echo "<a id='$row[eventID]'></a>";
        echo "<div>";

        echo "<h3>$row[eventName]</h3>";
        echo "<div class='eventInfoDiv'>";
        echo "<p><strong>Event Location: </strong> $row[eventLocation]</p>";
        echo "<p><strong>Event Time: </strong> $time</p>";
        echo "<p><strong>Event Date: </strong> $date[2] " . getMonth($date[1]) . " $date[0]</p> ";
        if (isset($row['eventPhone']) && $row['eventPhone'] !== "") {
            echo "<p><strong>Event Contact: </strong> $row[eventPhone]</p>";
        }
        if (isset($row['artistID']) && $row['artistID'] !== "") {
            echo "<p><strong>Featuring: </strong> <a href='../tcmcLive/artistInfo.php?artistID=$row[artistID]'>";
            $thisArtist = "SELECT artistGroup FROM ARTIST WHERE artistID =" . $row['artistID'];
            foreach ($dbh->query($thisArtist) as $artistName) {
                echo "$artistName[artistGroup]";
            }
            echo "</a></p></div>";

        }
        if (isset($row['eventImg']) && $row['eventImg'] !== "") {
            echo "<div class='eventImage'><img alt='Event image' src='../tcmcLive/images/eventImages/$row[eventImg]'></div><br>";
        }

        echo "<pre>";
        echo str_replace("\n","<br>",$row['eventDesc']);
        echo "</pre>";

        //CHANGE THIS TO ONLY ADMIN
        if ($_SESSION['userType'] === 'admin') {
            echo "<form action='events.php#$row[eventID]' method='post'>";
            echo "<input type='hidden' name='edit' value='$row[eventID]'>";


            echo "<input type='submit' value='Edit Event' />";
            echo "</form>";
            echo "<form action='../tcmcLive/eventChangeProcessing.php' method='post'>";
            echo "<input type='hidden' name='delete' value='$row[eventID]'>";


            echo "<input type='submit' value='Delete Event' />";
            echo "</form>";
        }
    }

    echo "";
    echo "<hr>";
    echo "</div>";
}


echo "</div>";



?>