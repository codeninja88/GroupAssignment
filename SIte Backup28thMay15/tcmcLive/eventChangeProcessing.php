<?php
require_once "includes/functions.php";
require_once "includes/databaseConnect.php";
session_start();

echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";

if (isset($_POST['Submit_Changes'])) {
    $eventName = htmlspecialchars($_POST['eventName'], ENT_QUOTES, ENT_NOQUOTES);
    $eventTime = htmlspecialchars($_POST['eventTime'], ENT_QUOTES, ENT_NOQUOTES);
    $eventDate = htmlspecialchars($_POST['eventDate'], ENT_QUOTES, ENT_NOQUOTES);
    $eventName = htmlspecialchars($_POST['eventName'], ENT_QUOTES, ENT_NOQUOTES);
    $eventLocation = htmlspecialchars($_POST['eventLocation'], ENT_QUOTES, ENT_NOQUOTES);
    $eventDesc = htmlspecialchars($_POST['eventDesc'], ENT_QUOTES, ENT_NOQUOTES);
    $eventPhone = htmlspecialchars($_POST['eventPhone'], ENT_QUOTES, ENT_NOQUOTES);

    $sql = "UPDATE EVENT SET eventName = '$eventName', eventDate = '$eventDate', eventName = '$eventName', eventLocation = '$eventLocation', eventDesc = '$eventDesc',
            eventPhone = '$eventPhone' WHERE eventID = $_POST[eventID]  ;";

    echo "$sql <br />";
    if ($dbh->exec($sql)) {
        $_SESSION['eventMessage'] = "The update has been successful";
        //redirectBackToPreviousPage();
    } else {
        $_SESSION['eventMessage'] = "The update has failed.";
    }

} else if (isset($_POST['delete'])) {
    echo "Delete has been selected for event no.: " . $_POST['delete'];
    $sql = "DELETE FROM EVENT WHERE eventID = '$_POST[delete]'";
    echo "<br /> $sql";
    if ($dbh->exec($sql)) {
        $_SESSION['eventMessage'] = "Event deleted successfully";
    } else {
        $_SESSION['eventMessage'] = "Failed to delete event.";
    }

} else if (isset($_POST['addEventSubmit'])) {

    $eventName = htmlspecialchars($_POST['eventName'], ENT_QUOTES, ENT_NOQUOTES);
    $eventTime = htmlspecialchars($_POST['eventTime'], ENT_QUOTES, ENT_NOQUOTES);
    $eventDate = htmlspecialchars($_POST['eventDate'], ENT_QUOTES, ENT_NOQUOTES);
    $eventName = htmlspecialchars($_POST['eventName'], ENT_QUOTES, ENT_NOQUOTES);
    $eventLocation = htmlspecialchars($_POST['eventLocation'], ENT_QUOTES, ENT_NOQUOTES);
    $eventDesc = htmlspecialchars($_POST['eventDesc'], ENT_QUOTES, ENT_NOQUOTES);
    $eventPhone = htmlspecialchars($_POST['eventPhone'], ENT_QUOTES, ENT_NOQUOTES);
    $eventContactName = htmlspecialchars($_POST['eventContactName'], ENT_QUOTES, ENT_NOQUOTES);
    if (isset($_FILES['eventImage'])) {
        $eventImage = basename($_FILES['eventImage']['name']);
        $eventImage = htmlspecialchars($eventImage, ENT_QUOTES, ENT_NOQUOTES);
    } else {
        $eventImage = "";
    }
    if (isset($_POST['eventFeaturedArtist'])){
        $eventFeaturedArtist = $_POST['eventFeaturedArtist'];
    } else {
        $eventFeaturedArtist = null;
    }


    $sql = "INSERT INTO EVENT(eventName, eventTime, eventDate, eventLocation, eventContactName, eventPhone, eventDesc, eventImg, artistID)
VALUES('$eventName', '$eventTime', '$eventDate', '$eventLocation', '$eventContactName', '$eventPhone', '$eventDesc', '$eventImage', '$eventFeaturedArtist')";
    if ($dbh->exec($sql)) {
        if (isset($_FILES['eventImage']) && $_FILES['eventImage']['error'] === 0) {
            uploadEventImage("eventImage");
        }
        $_SESSION['eventMessage'] = "Event created successfully.";
    } else {
        $_SESSION['eventMessage'] = "Event creation failed.";
    }


}

function uploadEventImage($fileObject)
{
    if (!preg_match('/(\w)*\.(jpg|png|gif|jpeg)$/', $_FILES[$fileObject]['name'])) {
        echo("<br /><strong>Error: Invalid file type please select a .png, .jpg or .gif</strong><br />");
        return;
    }
    if ($_FILES[$fileObject]['error'] !== 0) {
        echo "ERROR.";
        return;
    }


    $tempFile = $_FILES[$fileObject]['tmp_name'];
    $targetFile = basename($_FILES[$fileObject]['name']);
    if(imagesx($tempFile < 550)){
        $uploadDirectory = "images/eventImages/";
        move_uploaded_file($tempFile, $uploadDirectory . "/" . $targetFile);
    } else{
    $uploadDirectory = "images/eventImages/tempEventImages";
    //This is where the original is uploaded
    if (move_uploaded_file($tempFile, $uploadDirectory . "/" . $targetFile)) {
        $pathToImage = $uploadDirectory . "/";
        $imageName = $_FILES[$fileObject]['name'];
        $relcationDirectory = "images/eventImages/";
        $imageType = exif_imagetype($pathToImage . $imageName);
        $directory = opendir($pathToImage);

        if ($imageType === 1) { //gif
            $image = imagecreatefromgif($pathToImage . "/" . $imageName);
        } elseif ($imageType === 2) { //jpg
            $image = imagecreatefromjpeg($pathToImage . "/" . $imageName);
        } elseif ($imageType === 3) { //png
            $image = imagecreatefrompng($pathToImage . "/" . $imageName);
        } else {
            //This should never be reached.
            echo "Invalid file";
            return;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        $newWidth = 550;
        $newHeight = floor($height / $width * $newWidth);

        $newTempImage = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresized($newTempImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        //This is here everything is tuned into a gid I believe...


        //imagejpeg($newTempImage, "{$relcationDirectory}{$imageName}");

        if ($imageType === 1) {
            imagegif($newTempImage, "{$relcationDirectory}{$imageName}");
        } elseif ($imageType === 2) {
            imagejpeg($newTempImage, "{$relcationDirectory}{$imageName}");
        } elseif ($imageType === 3) {
            imagealphablending($newTempImage, false);
            imagesavealpha($newTempImage, true);
            imagepng($newTempImage, "{$relcationDirectory}{$imageName}");
        } else {
            echo "<br><strong>Something has gone horribly wrong.</strong><br>";
        }

        //This should remove the image from the temp file.
        unlink($uploadDirectory."/".$targetFile);
        closedir($directory);
    }
    }
}

redirectBackToPreviousPage();


echo "<a href='events.php'>Back</a>";

?>