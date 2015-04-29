<?php
include_once("functions.php");
require("databaseConnect.php");


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sort by Category</title>
</head>

<body>
<?php
//Generating the heading of the page: tells the user they're sorting by category
// and the category/ies they have selected
if (count($_POST) > 1) {
    $categoryWord = "Sort by categories:";
} else if (count($_POST) === 0) {
    $categoryWord = "Whoops! Nothing selected";
} else {
    $categoryWord = "Sort by category:";
}

//If the user has come directly to the page without selecting categories
//This message is displayed.
echo "<h1>$categoryWord</h1>";
if (count($_POST) === 0) {
    echo "<h2>None selected!</h2>";
    echo "<a href='index.php'>Return Home</a>";
} else {


    global $dbh;
//firstEntry is going to be used in a loop when displaying the relevant artists
    $counter = 1;
    $arrayLength = count($_POST);
    foreach ($_POST as $i) {
        if ($arrayLength === 1 && $counter === 1) {
            echo "<h2>$i.</h2>";
            $arrayLength--;
            $counter++;
            break;
        } elseif ($arrayLength > 1) {
            echo "<h2 style='display: inline'>$i, </h2>";
            $arrayLength--;
            $counter++;
        } else {
            echo "<h2 style='display: inline'>and $i. <br /></h2>";
        }
    }
}
echo "<a href='index.php'>Return Home</a>";
$arrayLength = count($_POST) - 1;
echo "<pre>";

//Leaving this here in case we need to print out our input again.
//print_r($_POST);
echo "</pre>";
$sql = "SELECT * FROM ARTIST, ARTIST_CATEGORY, CATEGORY
                    WHERE ARTIST.artistID = ARTIST_CATEGORY.artistID AND
                    ARTIST_CATEGORY.categoryName = CATEGORY.categoryName AND (";

//Generates our SQL based on the POST request
foreach ($_POST as $key => $value) {

    $sql = $sql . "CATEGORY.categoryName = " . "'" . $value . "'";
    if ($arrayLength !== 0) {
        $sql = $sql . " OR ";
        $arrayLength--;
    }
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


//Final GROUP BY statement for the SQL
$sql = $sql . ") /*GROUP BY CATEGORY.categoryName*/ ORDER BY CATEGORY.categoryName, ARTIST.artistGroup;";

/*-------------------------------------PROCESSING THE SQL RESULT----------------------------------------------*/
$divState = "closed";
echo "<br />";
foreach ($dbh->query($sql) as $row) {
    if ($category === "" || $row['categoryName'] !== $category) {
        if ($divState === 'open') {
            echo "</div>";
            $divState = "closed";
        }
        echo "<h3>$row[categoryName]</h3>";

        $category = $row['categoryName'];
        if ($divState === "closed") {
            echo "<div id='$row[categoryName]' style='border: solid; margin: 15px'>";
            $divState = "open";
        }


    }
    echo "<form action='index.php' method='post' id='$row[artistGroup]Form'>
                <input type='submit' value='More Info'> <input type='hidden' name='moreInfo' value='$row[artistID]'>$row[artistGroup] </form><br />
                </form>";

}


?>
</body>

</html>