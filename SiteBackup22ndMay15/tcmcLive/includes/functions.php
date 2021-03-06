<?php
include("databaseConnect.php");

function redirectTo($pageAddress)
{
    header("Location: " . $pageAddress);
    exit;
}

function redirectBackToPreviousPage(){
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

function deleteArtist($artistID)
{
    global $dbh;
    $sql = "DELETE FROM ARTIST WHERE artistID = '$artistID'";
    $dbh->exec($sql);
}
function printAWord(){
    echo "<h2>This is from functions</h2>";
}

function addArtist()
{
    global $dbh;
    $artistGroup = htmlspecialchars($_POST['artistGroup'], ENT_QUOTES, ENT_NOQUOTES);
    $artistSummary = htmlspecialchars($_POST['artistSummary'], ENT_QUOTES, ENT_NOQUOTES);
    $artistDesc = htmlspecialchars($_POST['artistDesc'], ENT_QUOTES, ENT_NOQUOTES);
    $artistEmail = htmlspecialchars($_POST['artistEmail'], ENT_QUOTES, ENT_NOQUOTES);
    $artistWeb = htmlspecialchars($_POST['artistWeb'], ENT_QUOTES, ENT_NOQUOTES);
    $artistPhone = htmlspecialchars($_POST['artistPhone'], ENT_QUOTES, ENT_NOQUOTES);
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === 0) {
        uploadImage("fileToUpload");
        $artistImg = basename($_FILES['fileToUpload']['name']);
    } else {
        $artistImg = 'defaultImage.jpg';
    }
    $artistImg = htmlspecialchars($artistImg, ENT_QUOTES, ENT_NOQUOTES);

    $sql = "INSERT INTO ARTIST(artistGroup, artistSummary, artistDesc, artistWeb, artistEmail, artistPhone, artistImg) VALUES('$artistGroup', '$artistSummary', '$artistDesc', '$artistWeb', '$artistEmail', '$artistPhone', '$artistImg')";
    $dbh->exec($sql);

    foreach ($dbh->query("SELECT * FROM ARTIST WHERE artistGroup = '$artistGroup' AND artistSummary = '$artistSummary' AND artistDesc = '$artistDesc' AND artistWeb = '$artistWeb' AND artistEmail = '$artistEmail' AND artistPhone = '$artistPhone' AND artistImg = '$artistImg'") as $row) {
        $iterationCounter = 1;
        for ($i = 1; $i <= 5; $i++) {
            echo "$iterationCounter";
            $iterationCounter++;
            $categoryString = "cat" . $i;
            if ($_POST[$categoryString] !== "") {
                addCategory($_POST[$categoryString]);
                $categoryName = $_POST[$categoryString];
                $capitalisedString = ucwords($_POST[$categoryString]);
                $sql = "INSERT INTO ARTIST_CATEGORY(artistID, categoryName) VALUES($row[artistID], '$capitalisedString')";
                $dbh->exec($sql);
                $sql = "";
            }
        }
    }
}

function displayArtists()
{
    global $dbh;
    $sql = "SELECT * FROM ARTIST";
    echo "<table style='border:solid; width: 50%; margin-right: 25%; margin-left:25%; border-collapse: collapse;'><tr><th style='font-size:30px'>Group Name</th><th style='font-size:30px'>Group Summary</th><th style='font-size:30px'>Image</th><th>Delete</th></th></tr>";
    if (!$_POST['edit']) {
        //Default display if 'edit' has not been submitted
        foreach ($dbh->query($sql) as $row) {
            if (!$row[artistImg]) {
                $image = 'defaultImage.jpg';
            } else {
                $image = $row['artistImg'];
            }
            echo "<td><a name='$row[artistID]'></a> <strong>$row[artistGroup]</strong> <br><form action='index.php' method='post' enctype='multipart/form-data'> <input type='submit' name='moreInfoButton' value='More Info' title='More info on this artist.'>
<input type='hidden' name='moreInfo' value='$row[artistID]'></form></td>";
            echo "<td>$row[artistSummary]</td>";
            echo "<td> <img src='Images/musosThumbnail/$image' alt='$row[artistGroup] image' title='$row[artistGroup] image' class='thumbNailImage' /> </td>";
            echo "<td><form action='index.php#$row[artistID]' method='post'><input type='submit' name='editSubmissionButton' value='Edit this artist'><input type='hidden' name='edit' value='$row[artistID]'> </form>
<form action='index.php' method='post'><input type='submit' name='XButton' value='X' title='Delete this entry.' style='color: red; background-color: darksalmon'><input type='hidden' name='delete' value='$row[artistID]'> </form></td>";

            echo "</tr>";
        }
        echo "</table>";
    } elseif ($_POST['edit']) {

        foreach ($dbh->query($sql) as $row) {

            if ($row['artistImg'] == "") {
                $image = "defaultImage.jpg";
            } else {
                $image = $row['artistImg'];
            }
            if ($_POST['edit'] == $row['artistID']) {
                //Displayed if this is the "artist" being edited

                echo "<tr style='background-color: orange'>
                        <td><strong>Edit artist:</strong></td><td><a name='$row[artistID]'></a></td><td></td><td></td></tr>";
                echo "<form action='index.php' method='post' id='editArtistForm' enctype='multipart/form-data'>";
                echo "<tr border: solid; background-color: lightgreen'>";
                echo "<td>Group name: <input type='text' name='artistGroup' value='$row[artistGroup]'></td>";
                echo "<td style='width:50%; padding:5px'><strong>Artist Summary:<br /></strong></string>
                      <textarea value='$row[artistSummary]' form='editArtistForm' name='artistSummary' rows='6' cols='55' style='resize:none'>$row[artistSummary]</textarea>  ";
                echo "<strong>Artist Description:<br /></strong><textarea value='$row[artistDesc]' form='editArtistForm' name='artistDesc' rows='10' cols='55' style='resize:none'>$row[artistDesc]</textarea>
                        <br />Phone: <input type='text' name='artistPhone' value='$row[artistPhone]'><br>Email: <input type='text' name='artistEmail' value='$row[artistEmail]'>
                        <br>Website: <input type='text' name='artistWeb' value='$row[artistWeb]'></td>";
                echo "<td> <img src='Images/musosThumbnail/$image' alt='$row[artistGroup] image' title='$row[artistGroup] image'' /><br />   <input type='hidden' name='oldImage' value='$row[artistImg]'>
                 <input type='hidden' name='MAX_FILE_SIZE' value='10500000'/>
                 <input name='newImage' type='file' id='newImage'></td>";

                echo "<td><input type='hidden' name='artistID' value='$row[artistID]'>
                <input type='submit' name='editSubmissionButton' value='Confirm Changes'><input type='hidden' name='confirm' value='$row[artistGroup]'> </form>
                <a href='index.php'><button>Discard Changes</button></a>
                <form action='index.php' method='post'>
                <input type='submit' name='XButton' value='X' title='Delete this entry.' style='color: red; background-color: darksalmon' title='Delete this artist'><input type='hidden' name='delete' value='$row[artistID]'></form> </td>";
                echo "</tr>";
                echo "<tr style='background-color: orange; height: 10px;'><td><strong></strong></td><td></td><td></td><td></td></tr>";

                //Every other artists that is not being edited
            } else {
                echo "<td><a name='$row[artistID]'></a> <strong>$row[artistGroup]</strong> <br><form action='index.php' method='post' enctype='multipart/form-data'> <input type='submit' name='moreInfoButton' value='More Info' title='More info on this artist.'>
<input type='hidden' name='moreInfo' value='$row[artistID]'></form></td>";
                echo "<td style='width:50%; padding:5px;border:thin'> $row[artistSummary] </td>";
                echo "<td> <img src='Images/musosThumbnail/$image' alt='$row[artistGroup] image' title='$row[artistGroup] image'' />  </td>";
                echo "<td><form action='index.php#$row[artistID]' method='post'><input type='submit' name='editSubmissionButton' value='Edit this artist'><input type='hidden' name='edit' value='$row[artistID]'> </form>
                        <form action='index.php' method='post'><input type='submit' name='XButton' value='X' title='Delete this entry.' style='color: red; background-color: darksalmon'><input type='hidden' name='delete' value='$row[artistID]'> </form></td>";
                echo "</tr>";
            }
        }
    }
}

/*Not used*/
function findArtistID($artistGroupName)
{
    global $dbh;
    $sql = "SELECT * FROM ARTIST";
    foreach ($dbh->query($sql) as $row) {

    }
}

function confirmUpdate()
{
    global $dbh;
    $artistGroup = htmlspecialchars($_POST['artistGroup'], ENT_QUOTES, ENT_NOQUOTES);
    $artistSummary = htmlspecialchars($_POST['artistSummary'], ENT_QUOTES, ENT_NOQUOTES);
    $artistDesc = htmlspecialchars($_POST['artistDesc'], ENT_QUOTES, ENT_NOQUOTES);
    $artistPhone = htmlspecialchars($_POST['artistPhone'], ENT_QUOTES, ENT_NOQUOTES);
    $artistEmail = htmlspecialchars($_POST['artistEmail'], ENT_QUOTES, ENT_NOQUOTES);
    $artistWeb = htmlspecialchars($_POST['artistWeb'], ENT_QUOTES, ENT_NOQUOTES);
    $artistID = $_POST['artistID'];

    //Little confused about best case error checking? Do I stop files of the same name being uploaded?
    // What if the band is re-branding and want to use/overwrite the same file name... etc.
    if ($_FILES['newImage']['name'] !== "" && $_FILES['newImage']['error'] !== 4) {
        uploadImage("newImage");
        $artistImg = htmlspecialchars($_FILES['newImage']['name'], ENT_QUOTES, ENT_NOQUOTES);
    } else {
        $artistImg = $_POST['oldImage'];
    }
    $sql = "UPDATE ARTIST SET artistGroup = '$artistGroup', artistSummary = '$artistSummary', artistDesc = '$artistDesc', artistPhone = '$artistPhone', artistEmail = '$artistEmail',
            artistWeb = '$artistWeb', artistImg = '$artistImg' WHERE artistID = $artistID";
    $dbh->exec($sql);

}

function displayIndividualArtistInfo()
{
    /*The 'moreInfo' is a hidden submission that comes with the form containing the "More Info" button*/
    $artistID = $_POST['moreInfo'];
    global $dbh;
    $sql = "SELECT * FROM ARTIST WHERE '$artistID' = artistID";
    foreach ($dbh->query($sql) as $row) {
        if ($row['artistID'] == $artistID) {
            $artistGroup = $row['artistGroup'];
            $artistDesc = $row['artistDesc'];
            $artistPhone = $row['artistPhone'];
            $artistEmail = $row['artistEmail'];
            $artistWeb = $row['artistWeb'];
            $artistFeatured = $row['artistFeatured'];
            $artistImg = $row['artistImg'];
        }
    }
    if ($artistImg == "defaultImage.jpg" or $artistImg == "") {
        /*Temp default image CHANGE THIS*/
        $artistPath = "Images/musos/defaultImage.jpg";
    } else {
        $artistPath = 'Images/musos/' . $artistImg;
    }
    echo "<div style='border:solid; width: 50%; margin:0 auto; padding:25px; border-radius: 20px; '>";
    echo "<h1>$artistGroup</h1>";
    echo "<img src='$artistPath' title='A picture of $artistGroup' style='display: block; margin: 0 auto' />
<hr>
        <h2>About the band:</h2><p>$artistDesc</p>";
    echo "<p>Phone: $artistPhone</p><p>Email: $artistEmail</p> <p>Website: $artistWeb</p>";

    echo "<form action='index.php' method='post'>
        <input type='submit' name='individualArtistBackButton' value='Back to all artists'>
        </form>";
    echo "</div>";
}

function uploadImage($fileObject)
{
    if (!preg_match('/(\w)*\.(jpg|png|gif|jpeg)$/', $_FILES[$fileObject]['name'])) {
        echo("<br /><strong>Error: Invalid file type please select a .png, .jpg or .gif</strong><br />");
        return;
    }
    if ($_FILES[$fileObject]['error'] !== 0) {
        echo "ERROR.";
        return;
    }
    //Temporary name on the server
    $tempFile = $_FILES[$fileObject]['tmp_name'];
    //This is where we rename the file. basename is going to help with security
    $targetFile = basename($_FILES[$fileObject]['name']);
    $uploadDirectory = "Images";
    $uploadSubdirectory = "musos";
    //This only moves files that have been uploaded. It knows they have been uploaded because
    // they are in the temp file. This will return false if this fails
    if (move_uploaded_file($tempFile, $uploadDirectory . "/" . $uploadSubdirectory . "/" . $targetFile)) {
        //The file was moved successfully
    } else {
        echo "There was a problem moving the file.";
        $error = $_FILES['fileToUpload']['error'];
        echo "<pre>$error</pre>";
    }

    createThumbnail($targetFile);
}


function addCategory($categoryName)
{
    global $dbh;
    $categoryName = ucwords($categoryName);
    $sql = "SELECT * FROM CATEGORY";
    $categoryExists = false;
    foreach ($dbh->query($sql) as $row) {
        if ($row['categoryName'] === $categoryName) {
            $categoryExists = true;
        }
    }
    if ($categoryExists === false) {
        $dbh->exec("INSERT INTO CATEGORY(categoryName) VALUES('$categoryName')");
    }
    // We have our Category entered if necessary.
}

function createThumbnail($imageName)
{
    //This is called after the image has been uploaded and saved and will create the thumbnail based on the most
    //recently uploaded image.
    /*
     * IMAGE CODES WE ACCEPT
     *  1.  .gif
     *  2.  .jpg
     *  3.  .png
     * For now transparency is not preserved, not sure if this is necessary as we will
     * be mostly accepting photos I assume, though if someone wants to use a logo
     * design it could realistically be a png with some transparency
    */

    $pathToImages = "Images/musos/";
    $pathToThumbnails = "Images/musosThumbnail/";
    // This is a number.
    $imageType = exif_imagetype($pathToImages . $imageName);

    $directory = opendir($pathToImages);

    if ($imageType === 1) { //gif
        $image = imagecreatefromgif($pathToImages . $imageName);
    } elseif ($imageType === 2) { //jpg
        $image = imagecreatefromjpeg($pathToImages . $imageName);
    } elseif ($imageType === 3) { //png
        $image = imagecreatefrompng($pathToImages . $imageName);
    } else {
        //This should never be reached.
        echo "Invalid file";
        return;
    }

    $width = imagesx($image);
    $height = imagesy($image);

    $newWidth = 300;
    $newHeight = floor($height / $width * $newWidth);

    $newTempImage = imagecreatetruecolor($newWidth, $newHeight);

    imagecopyresized($newTempImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagejpeg($newTempImage, "{$pathToThumbnails}{$imageName}");
    //imagejpeg($newTempImage, "{$pathToThumbnails}{$imageName}");
    if ($imageType === 1) {
        imagegif($newTempImage, "{$pathToThumbnails}{$imageName}");
    } elseif ($imageType === 2) {
        if (imagejpeg($newTempImage, "{$pathToThumbnails}{$imageName}")) {
        } else {
            echo "<strong>Creation of thumbnail has failed</strong>";
        }
    } elseif ($imageType === 3) {
        imagepng($newTempImage, "{$pathToThumbnails}{$imageName}");
    } else {
        echo "<br><strong>Something has gone horribly wrong.</strong><br>";
    }

    closedir($directory);
}

function getMonth($month){
    switch ($month){
        case "1" :
            return "January";
        case "2":
            return "February";
        case "3":
            return "March";
        case "4":
            return "April";
        case "5":
            return "May";
        case "6":
            return "June";
        case "7":
            return "July";
        case "8":
            return "August";
        case "9":
            return "September";
        case "10":
            return "October";
        case "11":
            return "November";
        case "12":
            return "December";
    }
}


?>