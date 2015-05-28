<?php
session_start();
require_once "includes/headerALL.php";
require_once "includes/databaseConnect.php";
require_once "includes/functions.php";


$userEmail = $_SESSION['userEmail'];
$sql = "SELECT * FROM USER WHERE userEmail = '$userEmail'";


echo "<div class='Content'>";
echo "<h2>My Account:</h2>";
echo "<hr />";
if (isset($_SESSION['myAccountMessage'])) {
    echo "<br />";
    echo "$_SESSION[myAccountMessage]";
    echo "<br />";
    $_SESSION['myAccountMessage'] = null;
}

if ($_SESSION['loginState'] !== "Logged in") {
    echo "<h2>Oops! You're not signed in.</h2>Please <strong>log in</strong> or <a href=\"members.php\"><strong>sign up</strong>.</a></h2></div>";


} elseif ($_POST['submit'] === "Edit My Account") {
    echo "<h3 style='color: red;'>Editing...</h3>";

    foreach ($dbh->query($sql) as $row) {
        //Style me
        echo "<div class='leftMyAccountDiv'>";
        echo "<b>Username: </b> <br />";
        echo "<b>Account Type: </b> <br />";
        echo "<b>Signup Date: </b> <br />";
        echo "<b>First Name: </b> <br />";
        echo "<b>Surname: </b> <br />";
        echo "<b>Primary Phone: </b><br />";
        echo "<b>Secondary Phone: </b> <br />";
        echo "<b>Mobile Phone: </b> <br />";
        echo "<b>Postal Address: </b> <br />";
        echo "</div>";

        echo "<div class='rightMyAccountDiv'>";
        echo "$row[userEmail] <br />";
        echo ucwords($row['userType']) . "<br />";
        $userDate = explode("-", $row[userSUDate]);
        echo "$userDate[2]-$userDate[1]-$userDate[0] <br />";
        //echo "$row[userFName] <br />";
        //echo "$row[userLName] <br />";
        echo "<form action='#' method='post'>";
        echo "<input type='text' name = userFName value='$row[userFName]' required /><br />";
        echo "<input type='text' name = userLName value='$row[userLName]' required /><br />";
        echo "<input type='text' name='userPrimPhone' value='$row[userPrimPhone]'/> <br />";
        echo "<input type='text' name='userSecPhone' value='$row[userSecPhone]' /><br />";
        echo "<input type='text' name='userMobile' value='$row[userMobile]' /><br />";
        echo "<textarea class='turnOffResizing' name='userAddress' value=''>$row[userAddress]</textarea>";


        echo "</div>";

        echo "<hr />";


        echo "<input type='submit' id='editMyAccountButton' name='submit' value='Save Changes' class='myAccountButton'> ";
        if($_SESSION['userType'] !== "admin"){
            echo "<input type='submit' id='deleteMyAccountButton' name='submit' value='Delete My Account' class='myAccountButton' >";
        }

        echo "</form>";

    }

} elseif ($_POST['submit'] === "Save Changes") {

    $userPrimPhone = htmlspecialchars($_POST['userPrimPhone'], ENT_QUOTES, ENT_NOQUOTES);
    $userSecPhone = htmlspecialchars($_POST['userSecPhone'], ENT_QUOTES, ENT_NOQUOTES);
    $userMobile = htmlspecialchars($_POST['userMobile'], ENT_QUOTES, ENT_NOQUOTES);
    $userAddress = htmlspecialchars($_POST['userAddress'], ENT_QUOTES, ENT_NOQUOTES);
    $userFName = htmlspecialchars($_POST['userFName'], ENT_QUOTES, ENT_NOQUOTES);
    $userLName = htmlspecialchars($_POST['userLName'], ENT_QUOTES, ENT_NOQUOTES);

    $sql = "UPDATE USER SET userPrimPhone = '$userPrimPhone', userSecPhone = '$userSecPhone', userMobile = '$userMobile', userAddress = '$userAddress', userFName = '$userFName', userLName = '$userLName'  WHERE userEmail = '$userEmail'";

    if ($dbh->exec($sql)) {
        $_SESSION['myAccountMessage'] = "Update successful.";
    } else {
        $_SESSION['myAccountMessage'] = "Update failed.";
    }

    redirectTo('myAccount.php');

} elseif ($_POST['submit'] === "Become a Member") {
    $sql = "UPDATE USER SET userType = 'paid' WHERE userEmail = '$userEmail'";
    if ($dbh->exec($sql)) {
        $_SESSION['userType'] = "paid";
        $_SESSION['myAccountMessage'] = "Congratulations! You're a paid member! We appreciate your on-going support.";
    } else {
        $_SESSION['myAccountMessage'] = "Making you a paid member failed. We're keeping your money. Thank you!";
    }

    redirectTo('myAccount.php');


} elseif ($_POST['submit'] === "Delete My Account") {

    echo "Are you sure you want to <strong>delete your account</strong>:";

    echo "<form method='post' action='#'>";
    echo "<input type='submit' name='submit' value='Yes' />";
    echo "<input type='submit' name='submit'  value='No' />";
    echo "</form>";

} elseif ($_POST['submit'] === "Yes") {
    $sql = "DELETE FROM USER WHERE userEmail = '$_SESSION[userEmail]'";
    $dbh->exec($sql);
    $_SESSION = array();
    session_destroy();
    redirectTo("index.php");

} else {
    //$_SESSION['userEmail']
    /*    echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/

    foreach ($dbh->query($sql) as $row) {
        //Style me
        echo "<div class='leftMyAccountDiv'>";
        echo "<b>Username: </b> <br />";
        echo "<b>Account Type: </b> <br />";
        echo "<b>Signup Date: </b> <br />";
        echo "<b>First Name: </b> <br />";
        echo "<b>Surname: </b> <br />";
        echo "<b>Primary Phone: </b><br />";
        echo "<b>Secondary Phone: </b> <br />";
        echo "<b>Mobile Phone: </b> <br />";
        echo "<b>Postal Address: </b> <br />";
        echo "</div>";

        echo "<div class='rightMyAccountDiv'>";
        echo "$row[userEmail] <br />";
        echo ucwords($row['userType']) . "<br />";
        $userDate = explode("-", $row[userSUDate]);
        echo "$userDate[2]-$userDate[1]-$userDate[0] <br />";
        echo "$row[userFName] <br />";
        echo "$row[userLName] <br />";
        echo "$row[userPrimPhone] <br />";
        echo "$row[userSecPhone] <br />";
        echo "$row[userMobile] <br />";
        echo "$row[userAddress] <br />";
        echo "</div>";

        echo "<hr />";

        echo "<form action='#' method='post'>";
        echo "<input type='submit' name='submit' id='editMyAccountButton' value='Edit My Account' class='myAccountButton' '> ";
        if ($_SESSION['userType'] === "casual") {
            echo "<input type='submit' name='submit' value='Become a Member' id='becomeAPaidMemberButton' class='myAccountButton'> ";
        }
        echo "<input type='submit' name='submit' id='deleteMyAccountButton' value='Delete My Account' class='myAccountButton'>";
        echo "</form>";

    }
}



?>