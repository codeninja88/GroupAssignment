<?php
session_start();
require_once("databaseConnect.php");
include_once "functions.php";
echo "<div class='Content'>";
echo "<h2>Events</h2>";

if(isset($_SESSION['eventMessage'])){
    echo "<span id='eventMessage' style='color: red'>$_SESSION[eventMessage]</span>";
    $_SESSION['eventMessage'] = null;
}
$sql = "SELECT * FROM EVENT WHERE eventDate > DATE() ORDER BY eventDate;";

//if($_SESSION['userType'] === "admin"){


    echo "<form id='addEventForm' action='../tcmcLive/eventChangeProcessing.php' method='post' enctype='multipart/form-data'>";
    echo "<fieldset>";
//Change the spacing
//Make the text area larger and fixed.
//Fix image resizing? Dont resize if they're below the threshold
    echo "<legend>Add an event</legend>";
    echo "<table>";
        echo "<span id='requiredFieldsSpan'>* Required fields.</span>";
        echo "<tr><td>Event Name*: </td><td><input type='text' name='eventName' class='eventInputField' placeholder='Event name...' required></td> <td></td> </tr>";
        echo "<tr><td>Event Time*: </td><td><input type='text' name='eventTime' class='eventInputField' placeholder='HH:MM' required></td><td></td> </tr>";
        echo "<tr><td>Event Date*: </td><td><input type='date' name='eventDate' class='eventInputField' placeholder='Event name...' required></td><td></td> </tr>";
        echo "<tr><td>Event Location*: </td><td><input type='text' name='eventLocation' class='eventInputField' placeholder='Event location...' required></td><td></td> </tr>";
        echo "<tr><td>Event Contact Name: </td><td><input type='text' name='eventContactName' class='eventInputField' placeholder='Event contact name...' /></td> <td></td></tr>";
        echo "<tr><td>Event Contact Phone: </td><td><input type='text' name='eventPhone' class='eventInputField' placeholder='Phone number...' /></td><td></td> </tr>";

        echo "<tr><td>Featuring: </td>";
        echo "<td><select name='eventFeaturedArtist'>";
        echo "<option value=''>-----</option>";
        $featuringList = "SELECT artistID, artistGroup FROM ARTIST";
        foreach ($dbh->query($featuringList) as $row){
        echo "<option value='$row[artistID]'>$row[artistGroup]</option>";
        }
        echo "";

        echo "</select></td></tr>";

        echo "<tr>";
        echo "<td><input type='file' name='eventImage'> </td>";
        echo "<td></td></tr>";
        echo "<tr><td>Event Description: </td></tr>";
    echo "</table>";
echo "<tr><td colspan='3'><textarea form='addEventForm' name='eventDesc' class='eventInputTextArea' rows='10' cols='100' placeholder='About the event...'> </textarea> </td></tr>";
echo "<input type='submit' name='addEventSubmit'>";
    echo "</fieldset>";
    echo "</form>";
//}


foreach ($dbh->query($sql) as $row) {
    //If editing.
    if ($_POST['edit'] === $row['eventID']) {
        echo "<a name='$row[eventID]'></a>";
        echo "<div style='background-color: #ff5a3d'><h3>**Editing**</h3></div>";
        echo "<div>";

        echo "<form id='editEventForm' action='../tcmcLive/eventChangeProcessing.php' method='post'>";
        echo "<h3><input class='editEventTitle' type='text' name='eventName' value='$row[eventName]' /> </h3>";
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
            echo "<div class='eventImage'><img src='../tcmcLive/images/eventImages/$row[eventImg]'></div><br>";
        }
        echo "<textarea name='eventDesc' form='editEventForm'>$row[eventDesc]</textarea></p>";
        echo "<input type='submit' name='Submit Changes' />";
        echo "</form>";

        echo "<div style='height: 5px; background-color: #ff5a3d'></div>";




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
        echo "<a name='$row[eventID]'></a>";
        echo "<div>";

        echo "<h2>$row[eventName]</h2>";
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
            echo "<div class='eventImage'><img src='../tcmcLive/images/eventImages/$row[eventImg]'></div><br>";
        }
        echo "<p>$row[eventDesc]</p>";

        //CHANGE THIS TO ONLY ADMIN
        if ($_SESSION['userType'] === "admin" || $_SESSION['userType'] === "paid") {
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