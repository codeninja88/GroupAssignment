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
    echo "Error code on Image upload: " . $_FILES['fileToUpload']['error'] . "<br />";
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === 0) {
        echo "An Image is uploading";
        uploadImage();
        $artistImg = basename($_FILES['fileToUpload']['name']);
    } else {
        echo "The file was apparently not set.";
        $artistImg = 'defaultImage.jpg';
    }
    $sql = "INSERT INTO ARTIST(artistGroup, artistSummary, artistDesc, artistWeb, artistEmail, artistPhone, artistImg) VALUES('$artistGroup', '$artistSummary', '$artistDesc', '$artistWeb', '$artistEmail', '$artistPhone', '$artistImg')";
    $dbh->exec($sql);
    echo "<br /> <strong>Function has added an artist</strong>";

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
            echo "<td><a name='$row[artistID]'></a> <strong>$row[artistGroup]</strong> <br><form action='index.php' method='post'> <input type='submit' name='moreInfoButton' value='More Info' title='More info on this artist.'>
<input type='hidden' name='moreInfo' value='$row[artistGroup]'></form></td>";
            echo "<td>$row[artistSummary]</td>";
            echo "<td> <img src='Images/musosThumbnail/$image' alt='$row[artistGroup] image' title='$row[artistGroup] image' class='thumbNailImage' /> </td>";
            echo "<td><form action='index.php#$row[artistID]' method='post'><input type='submit' name='editSubmissionButton' value='Edit this artist'><input type='hidden' name='edit' value='$row[artistGroup]'> </form>
<form action='index.php' method='post'><input type='submit' name='XButton' value='X' title='Delete this entry.'><input type='hidden' name='delete' value='$row[artistGroup]'> </form></td>";

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
            if ($_POST['edit'] == $row['artistGroup']) {
                echo "<br/><pre>";
                print_r($_POST);
                echo "</pre><br/>";

                //Displayed if this is the "artist" being edited

                echo "<tr style='background-color: orange'>
                        <td><strong>Edit artist:</strong></td><td><a name='$row[artistID]'></a></td><td></td><td></td></tr>";
                echo "<form action='index.php' method='post' id='editArtistForm'>";
                echo "<tr border: solid; background-color: lightgreen'>";
                echo "<td>Group name: <input type='text' name='artistGroup' value='$row[artistGroup]'></td>";
                echo "<td style='width:50%; padding:5px'><strong>Artist Summary:<br /></strong></string>
                      <textarea value='$row[artistSummary]' form='editArtistForm' name='artistSummary' rows='6' cols='55' style='resize:none'>$row[artistSummary]</textarea>  ";
                echo "<strong>Artist Description:<br /></strong><textarea value='$row[artistDesc]' form='editArtistForm' name='artistDesc' rows='10' cols='55' style='resize:none'>$row[artistDesc]</textarea>
                        <br />Phone: <input type='tel' name='artistPhone' value='$row[artistPhone]'><br>Email: <input type='email' name='artistEmail' value='$row[artistEmail]'>
                        <br>Website: <input type='url' name='artistWeb' value='$row[artistWeb]'></td>";
                echo "<td> <img src='Images/musosThumbnail/$image' alt='$row[artistGroup] image' title='$row[artistGroup] image'' /> </td>";
                echo "";
                echo "<td><input type='hidden' name='artistID' value='$row[artistID]'>
                <input type='submit' name='editSubmissionButton' value='Confirm Changes'><input type='hidden' name='confirm' value='$row[artistGroup]'> </form>
                <a href='index.php'><button>Discard Changes</button></a>
                <form action='index.php' method='post'>
                <input type='submit' name='XButton' value='X' title='Delete this entry.' style='color: red' title='Delete this artist'><input type='hidden' name='delete' value='$row[artistGroup]'></form> </td>";
                echo "</tr>";
                echo "<tr style='background-color: orange; height: 10px;'><td><strong></strong></td><td></td><td></td><td></td></tr>";

                //Every other artists that is not being edited
            } else {

                echo "<td><a name='$row[artistID]'></a> $row[artistGroup]</td>";
                echo "<td style='width:50%; padding:5px;border:thin'> $row[artistSummary] </td>";
                echo "<td> <img src='Images/musosThumbnail/$image' alt='$row[artistGroup] image' title='$row[artistGroup] image'' /> </td>";
                echo "<td><form action='index.php#$row[artistID]' method='post'><input type='submit' name='editSubmissionButton' value='Edit this artist'><input type='hidden' name='edit' value='$row[artistGroup]'> </form>
                        <form action='index.php' method='post'><input type='submit' name='XButton' value='X' title='Delete this entry.'><input type='hidden' name='delete' value='$row[artistGroup]'> </form></td>";
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
    global $dbh;
    echo "" . $_POST['artistGroup'];
    $artistGroup = $_POST['artistGroup'];
    $artistSummary = $_POST['artistSummary'];
    $artistDesc = $_POST['artistDesc'];
    $artistID = $_POST['artistID'];
    $artistEmail = $_POST['artistEmail'];
    $artistPhone = $_POST['artistPhone'];
    $artistWeb = $_POST['artistWeb'];
    $sql = "UPDATE ARTIST SET artistGroup = '$artistGroup', artistSummary = '$artistSummary', artistDesc = '$artistDesc', artistPhone = '$artistPhone', artistEmail = '$artistEmail',
            artistWeb = '$artistWeb' WHERE artistID = $artistID";
    $dbh->exec($sql);
    echo "SQL: " . $sql;

    echo "Data confirmed:<br />Group name: $artistGroup <br /> Summary: $artistSummary";
}

/**
 *
 */
function displayIndividualArtistInfo()
{
    /*The 'moreInfo' is a hidden submission that comes with the form containing the "More Info" button*/
    $artistGroup = $_POST['moreInfo'];
    echo "The object $artistGroup has been accessed <br />";
    echo "contents: " . " <br />";
    global $dbh;
    $sql = "SELECT * FROM ARTIST WHERE '$artistGroup' = artistGroup";
    foreach ($dbh->query($sql) as $row) {
        if ($row['artistGroup'] == $artistGroup) {
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

    echo "<div style='border:solid; width: 70%; margin-right: 25%; margin-left:25%; border-collapse: collapse; padding:25px'>";
    echo "<h1>$artistGroup</h1>";
    echo "<img src='$artistPath' title='A pricture of $artistGroup' />
        <h2>About the band:</h2><p>$artistDesc</p>";
    echo "<p>Phone: $artistPhone</p><p>Email: $artistEmail</p> <p>Website: $artistWeb</p>";

    echo "<form action='index.php' method='post'>
        <input type='submit' name='individualArtistBackButton' value='Back to all artists'>
        </form>";


    echo "</div>";
}

function uploadImage()
{
    if (!preg_match('/(\w)*\.(jpg|png|gif)$/', $_FILES['fileToUpload']['name'])) {
        echo("<br /><strong>Error: Invalid file type please select a .png, .jpg or .gif</strong><br />");
        return;
    }
    if ($_FILES['fileToUpload']['error'] !== 0) {
        echo "ERROR.";
        return;
    }
    //Temporary name on the server
    $tempFile = $_FILES['fileToUpload']['tmp_name'];
    //This is where we rename the file. basename is going to help with security
    $targetFile = basename($_FILES['fileToUpload']['name']);
    $uploadDirectory = "Images";
    $uploadSubdirectory = "musos";
    //This only moves files that have been uploaded. It knows they have been uploaded because
    // they are in the temp file. This will return false if this fails
    if (move_uploaded_file($tempFile, $uploadDirectory . "/" . "/" . $uploadSubdirectory . "/" . $targetFile)) {
        echo "the file has been moves successfully to: " . $uploadDirectory . "/" . $targetFile;
    } else {
        echo "There was a problem moving the file.";
        $error = $_FILES['fileToUpload']['error'];
        echo "<pre>$error</pre>";
    }


    //uploadTrial();
    echo "<br / Image array: <br />";
    echo "<pre>";
    print_r($_FILES['fileToUpload']);
    echo "</pre>";
    echo "<br />";
    createThumbnail($targetFile);
    echo "<strong>File uploaded successfully.</strong> <br />";
}

/*function generateArtistSummary($description){
    $artistSummary = "";
    $descriptionArray = explode(" ", $description);
    echo "<pre>";
    print_r($descriptionArray);
    echo "</pre>";
    if (count($descriptionArray) >= 20){
        $summaryLength = 20;
    } else {
        $summaryLength = count($description);
    }

    for ($i = 0; $i < $summaryLength; $i++){
        echo "$i: " . $descriptionArray[$i];
        if($descriptionArray[$i] == " "){
            $artistSummary . "a SPACE HAS BEEN IGNORED";
            $artistSummary . " ";
        } else {
            $artistSummary .= trim($descriptionArray[$i]);
            $artistSummary . " ";
        }
    }
    $artistSummary . "...";
    echo $artistSummary;

    return $artistSummary;
}*/


function sortBy()
{
    // The user clicks on a link
    // "Blues" "Jazz" Or something
    // >>>>> Request with the category selected
    // dynamic SQL executes and we display the result


}

function createThumbnail($imageName)
{
    //This is called after the image has been uploaded and saved and will create the thumbnail based on the most
    //recently uploaded image.
    echo "Create thumbnail $imageName passed <br />";

    /*
     * IMAGE CODES WE ACCEPT
     *  1.  .gif
     *  2.  .jpg
     *  3.  .png
     *
     * For now transparency is not preserved
    */


    $pathToImages = "Images/musos/";
    $pathToThumbnails = "Images/musosThumbnail/";
    // This is a number.
    $imageType = exif_imagetype($pathToImages . $imageName);

    echo "<br>$imageType<br>";

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

    echo "The file type: " . $imageType;

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
        imagejpeg($newTempImage, "{$pathToThumbnails}{$imageName}");
    } elseif ($imageType === 3) {

        imagepng($newTempImage, "{$pathToThumbnails}{$imageName}");
    } else {
        echo "<br><strong>Something has gone horribly wrong.</strong><br>";
    }

    closedir($directory);
    echo "Thumbnail created successfully";
}


?>