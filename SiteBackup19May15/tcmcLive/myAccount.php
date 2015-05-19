<?php
session_start();
include_once "includes/headerALL.php";
include_once "includes/database.php";

echo "<div class=\"Content\">";
if ($_SESSION['loginState'] !== "Logged in") {
    echo "<h2>Oops! You're not signed in.</h2>Please <strong>log in</strong> or <a href=\"members.php\"><strong>sign up</strong>.</a></h2>";


} else {
    //$_SESSION['userEmail']
    $sql = "SELECT * FROM USER WHERE userEmail = $_SESSION[userEmail]";
    echo "$sql";
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
    echo "<h2>My Account:</h2>";
    foreach ($dbh->query($sql) as $row) {

        //Style me
        if ($_SESSION['userType'] === "casual") {
            echo "<button>Become a paid member</button>";
        }
        echo "<div>";
        echo "<span>";
        echo "Username: " . $row['userEmail'];
        echo "</span>";
        echo "<br />";
        echo "<span>";
        echo "First name: " . $row['userFName'];
        echo "</span>";
        echo "<br />";
        echo "<span>";
        echo "Last name: " . $row['userLName'];
        echo "</span>";
        echo "<br />";
        echo "<form>";
        echo "Primary Phone:";
        echo "<input type='text' value=\" $row[userPrimPhone] \">";
        echo "</form>";


        echo "</div>";

    }
}



?>