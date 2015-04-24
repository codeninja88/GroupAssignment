<?php
include_once("functions.php");
require("databaseConnect.php");


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Page 2 - Processing Page</title>
</head>

<body>
<h1>This is the processing page</h1>

<?php
global $dbh;
//we've received a post request that has check boxes.
//some are checked others not
$counter = "FIRST";
echo "Raw array length: " . count($_POST) . " <br />";
$arrayLength = count($_POST)-1;
echo $arrayLength . " our array length reduced by 1 <br />";
echo "<pre>";

print_r($_POST);
echo "</pre>";
$sql = "SELECT * FROM ARTIST, ARTIST_CATEGORY, CATEGORY
                    WHERE ARTIST.artistID = ARTIST_CATEGORY.artistID AND
                    ARTIST_CATEGORY.categoryName = CATEGORY.categoryName AND (";

foreach ($_POST as $key => $value) {

    $sql = $sql . "CATEGORY.categoryName = " . "'" .  $value . "'";
    if($arrayLength !== 0){
        $sql = $sql . " OR ";
        $arrayLength--;
    }

/*
    if ($counter === "FIRST") {
        $sql = $sql . $value;
        $counter = "NOT FIRST";
    } else {
        $sql = $sql . ', ' . $value ;
    }

    echo "<pre>";
    print_r(explode(', ', $sql));
    echo "</pre>";*/
}

$sql = $sql . ") GROUP BY ARTIST.artistID;";

$fieldArray = explode(', ', $sql);
echo "$sql";

$rowCounter = 0;

echo "<br />";
foreach($dbh->query($sql) as $row){
    echo "<pre>";
    print_r($row);
    echo "</pre>";

}


?>
</body>

</html>