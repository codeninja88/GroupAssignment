<?php
session_start();
    //This page will receive a post request with at least 4 records
    require_once("includes/databaseConnect.php");
    include_once('includes/functions.php');

    $username = $_POST['username'];
    $password = $_POST['password'];
    $userFName = $_POST['userFName'];
    $userLName = $_POST['userLName'];
    $userType = $_POST['userType'];
    $userPrimPhone = $_POST['userPrimPhone'];
    $userMob = $_POST['userMob'];
    $userAddress = $_POST['userAddress'];
    $userSUDate = date("Y-m-d");

    echo "$username, $password, $userFName, $userLName Has been submitted to sign up";
    echo "<br><br> $userSUDate";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $sql = "INSERT INTO USER(userEmail, userFName, userLName, userType, userAddress, userPrimPhone, userSecPhone, userMobile, userSUDate, userPW) VALUES('$username', '$userFName', '$userLName', '$userType', '$userAddress', '$userPrimPhone', '', '', '$userSUDate', '$password')";
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

/*$sql = "SELECT * FROM USER";
    foreach($dbh->query($sql) as $row){
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }*/







    echo "<a href='members.php'>Back to members page.</a>"

?>