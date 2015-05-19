<?php
    include("databaseConnect.php");






// ARTISTS

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
    $tempFile = $_FILES[$fileObject]['tmp_name'];
    $targetFile = basename($_FILES[$fileObject]['name']);
    $uploadDirectory = "images";
    if (move_uploaded_file($tempFile, $uploadDirectory . "/" . $targetFile)) {

        //The file was moved successfully
//         echo "The file was moved successfully";
    } else {
        echo "There was a problem moving the file.";
        $error = $_FILES['fileToUpload']['error'];
        echo "<pre>$error</pre>";
    }

    createThumbnail($targetFile);
}


function createThumbnail($imageName)
{

    $pathToImages = "images/";

    $pathToThumbnails = $pathToImages . "musosThumbnail/";
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

    $newWidth = 250;
    $newHeight = floor($height / $width * $newWidth);

    $newTempImage = imagecreatetruecolor($newWidth, $newHeight);

    imagecopyresized($newTempImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagejpeg($newTempImage, "{$pathToThumbnails}{$imageName}");
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








// NOTICES

function uploadImage2($fileObject)
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
    $uploadDirectory = "images";
    if (move_uploaded_file($tempFile, $uploadDirectory . "/" . $targetFile)) {

        //The file was moved successfully
//         echo "The file was moved successfully";
    } else {
        echo "There was a problem moving the file.";
        $error = $_FILES['fileToUpload']['error'];
        echo "<pre>$error</pre>";
    }

    createThumbnail2($targetFile);
}


function createThumbnail2($imageName)
{

    $pathToImages = "images/";

    $pathToThumbnails = $pathToImages . "noticeThumbnail/";
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

    $newWidth = 250;
    $newHeight = floor($height / $width * $newWidth);

    $newTempImage = imagecreatetruecolor($newWidth, $newHeight);

    imagecopyresized($newTempImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagejpeg($newTempImage, "{$pathToThumbnails}{$imageName}");
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

?>