<?php
session_start();
    //This page will receive a post request with at least 4 records
    require_once("includes/databaseConnect.php");
    include_once('includes/functions.php');

    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, ENT_NOQUOTES);
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, ENT_NOQUOTES);
    $userFName = htmlspecialchars($_POST['userFName'], ENT_QUOTES, ENT_NOQUOTES);
    $userLName = htmlspecialchars($_POST['userLName'], ENT_QUOTES, ENT_NOQUOTES);
    $userType = htmlspecialchars($_POST['userType'], ENT_QUOTES, ENT_NOQUOTES);
    $userPrimPhone = htmlspecialchars($_POST['userPrimPhone'], ENT_QUOTES, ENT_NOQUOTES);
    $userSecPhone = htmlspecialchars($_POST['userSecPhone'], ENT_QUOTES, ENT_NOQUOTES);
    $userMobile = htmlspecialchars($_POST['userMobile'], ENT_QUOTES, ENT_NOQUOTES);
    $userAddress = htmlspecialchars($_POST['userAddress'], ENT_QUOTES, ENT_NOQUOTES);
    $userMobile = htmlspecialchars($_POST['userMobile'], ENT_QUOTES, ENT_NOQUOTES);


    $userSUDate = date("Y-m-d");

    echo "$username, $password, $userFName, $userLName Has been submitted to sign up";
    echo "<br><br> $userSUDate";

/*$sql = "INSERT INTO USER(userEmail, userFName, userLName, userType, userAddress, userPrimPhone, userSecPhone, userMobile, userSUDate, userPW)
VALUES('admin@me.com', 'Main', 'Admin', 'admin', '', '', '', '', '', 'admin')";
$dbh->exec($sql);*/

    $sql = "INSERT INTO USER(userEmail, userFName, userLName, userType, userAddress, userPrimPhone, userSecPhone, userMobile, userSUDate, userPW)
VALUES('$username', '$userFName', '$userLName', '$userType', '$userAddress', '$userPrimPhone', '$userSecPhone', '$userMobile', '$userSUDate', '$password')";

    echo "$sql";
    if($dbh->exec($sql)){
        echo "Update successful";
        $_SESSION['userType'] = $userType;
        $_SESSION['loginState'] = "Logged in";
        $_SESSION['userEmail'] = $username;
        $_SESSION['userFName'] = $userFName;
        $_SESSION['userLName'] = $userLName;
        $_SESSION['message'] = "Logged in successfully";
        redirectBackToPreviousPage();
    }else{
        echo "The update has failed.";
    };

    echo "<a href='members.php'>Back to members page.</a>"

?>