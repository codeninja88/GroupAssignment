<?php
include("databaseConnect.php");

function redirectTo($pageAddress)
{
    header("Location: " . $pageAddress);
    exit;
}

function deleteArtist($artistName)
{
    global $dbh;
    $sql = "DELETE FROM ARTIST WHERE artistGroup = '$artistName'";
    $dbh->exec($sql);
}

function addArtist()
{
    global $dbh;
    $artistGroup = $_POST['artistGroup'];
    $artistSummary = $_POST['artistSummary']; //Field not yet in DB
    $artistDesc = $_POST['artistDesc'];
    $artistPhone = $_POST['artistPhone'];
    $artistEmail = $_POST['artistEmail'];
    $artistWeb = $_POST['artistWeb'];
    $artistImg = 'defaultThumbnail.png';
    $sql = "INSERT INTO ARTIST(artistGroup, artistDesc, artistImg) VALUES('$artistGroup', '$artistDesc', '$artistImg')";
    $dbh->exec($sql);
    echo "Function has added an artist";

}

function displayArtists()
{
    global $dbh;
    $sql = "SELECT * FROM ARTIST";
    echo "<table style='border:solid; width: 50%; margin-right: 25%; margin-left:25%; border-collapse: collapse;'><tr><th style='font-size:30px'>Group Name</th><th style='font-size:30px'>Group Description</th><th style='font-size:30px'>Image</th><th>Delete</th></th></tr>";
    if (!$_POST['edit']) {
        foreach ($dbh->query($sql) as $row) {
            echo "<tr id='$row[artistID]'>";
            echo "<td> $row[artistGroup] $row[artistID]</td>";
            echo "<td style='width:50%; padding:5px;border:thin'> $row[artistDesc] </td>";
            echo "<td> <img src='Images/musosThumbnail/$row[artistImg]' alt='$row[artistGroup] image' title='$row[artistGroup] image'' /> </td>";
            echo "<td><form action='firstPage.php' method='post'><input type='submit' name='editSubmissionButton' value='Edit this artist'><input type='hidden' name='edit' value='$row[artistGroup]'> </form>
<form action='firstPage.php' method='post'><input type='submit' name='XButton' value='X' title='Delete this entry.'><input type='hidden' name='delete' value='$row[artistGroup]'> </form></td>";

            echo "</tr>";

        }
        echo "</table>";
    } elseif ($_POST['edit']) {
        foreach ($dbh->query($sql) as $row) {
            if ($_POST['edit'] == $row['artistGroup']) {
                echo "<form action='firstPage.php' method='post' id='editArtistForm'>";
                echo "<tr style='border: solid' id='$row[artistID]'>";

                echo "<td>Group name: <input type='text' name='artistGroup' value='$row[artistGroup]'></td>";
                echo "<td style='width:50%; padding:5px'><textarea value='$row[artistDesc]' form='editArtistForm' name='artistDesc' rows='16' cols='55' style='resize:none'>$row[artistDesc]</textarea>  </td>";
                echo "<td> <img src='Images/musosThumbnail/$row[artistImg]' alt='$row[artistGroup] image' title='$row[artistGroup] image'' /> </td>";
                echo "<td><input type='hidden' name='artistID' value='$row[artistID]'>
                <input type='submit' name='editSubmissionButton' value='Confirm Changes'><input type='hidden' name='confirm' value='$row[artistGroup]'></form><form action='firstPage.php' method='post'><input type='submit' name='XButton' value='X' title='Delete this entry.'><input type='hidden' name='delete' value='$row[artistGroup]'></form> </td>";
                echo "</tr>";
            } else {
                echo "<tr id='$row[artistID]'>";
                echo "<td> $row[artistGroup] $row[artistID]</td>";
                echo "<td style='width:50%; padding:5px;border:thin'> $row[artistDesc] </td>";
                echo "<td> <img src='Images/musosThumbnail/$row[artistImg]' alt='$row[artistGroup] image' title='$row[artistGroup] image'' /> </td>";
                echo "<td><form action='firstPage.php' method='post'><input type='submit' name='editSubmissionButton' value='Edit this artist'><input type='hidden' name='edit' value='$row[artistGroup]'> </form>
<form action='firstPage.php' method='post'><input type='submit' name='XButton' value='X' title='Delete this entry.'><input type='hidden' name='delete' value='$row[artistGroup]'> </form></td>";
                echo "</tr>";
            }

        }
    }
}

/*Not used*/
function displayArtistImages()
{
    global $dbh;
    $sql = "SELECT * FROM ARTIST";
    foreach ($dbh->query($sql) as $row) {
        $imageName = $row['artistImg'];
        echo "<img src='Images/musos/$imageName'/>";
    }
}

function confirmUpdate()
{
    echo "UPDATE CONFIRMED<br /><br />";
    global $dbh;
    echo "" . $_POST['artistGroup'];
    $artistGroup = $_POST['artistGroup'];
    $artistDesc = $_POST['artistDesc'];
    $artistID = $_POST['artistID'];
    $sql = "UPDATE ARTIST SET artistGroup = '$artistGroup', artistDesc = '$artistDesc' WHERE artistID = $artistID";
    $dbh->exec($sql);
    echo "SQL: " . $sql;

    echo "Data confirmed:<br />Group name: $artistGroup <br /> Description: $artistDesc";


}

?>