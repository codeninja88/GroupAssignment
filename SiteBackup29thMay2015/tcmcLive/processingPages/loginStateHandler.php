<?php

session_start();
require('../includes/databaseConnect.php');
require('../includes/functions.php');

//This page is to handle any log in/log out post requests.
//Log in requests will be redirected back to the page they came from
//  --If the user has logged in from the index - they go back to index etc.
$sql = "INSERT INTO USER(userEmail, userFName, userLName, userPW) VALUES('someone@somewhere.com', 'Someone', 'Somewhere', 'password')";
//LOGOUT
if(isset($_POST['Logout'])){
    $_SESSION = array();
    session_destroy();
    redirectBackToPreviousPage();
} elseif($_SESSION['loginState'] === "Logged in"){
    redirectBackToPreviousPage();
}

//LOGIN
//This shouldnt ever be the case with "require" but has been included as a safeguard
if($_POST['username'] == "" || $_POST['password'] == ""){
    $_SESSION['message'] = "Invalid username or password.";
    $_SESSION['loginState'] = "Not logged in";
    redirectBackToPreviousPage();
} else{
    //!!!!! ---> VARIABLES ARE BASED ON OLD VERSIONS OF THE SITE AND MAY BEEN TO BE CHANGED TO RETURN ANYTHING
    $userName = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM USER WHERE userEmail = '$userName' AND userPW = '$password'";
    foreach ($dbh->query($sql) as $row){
        if($row['userEmail'] === $userName && $row['userPW'] === $password){
            /*The login has been successful - username and password match.
                    User types handled =    "admin"
                                            "paid"
                                            "casual"
            */

            $_SESSION['loginState'] = "Logged in";
            $_SESSION['userType'] = $row['userType'];
            $_SESSION['userFName'] = $row['userFName'];
            $_SESSION['userLName'] = $row['userLName'];
            redirectBackToPreviousPage();

        } else {
            $_SESSION['loginState'] = "Unsuccessful";
            $_SESSION['message'] = "Incorrect username or password";
            redirectBackToPreviousPage();
        }
    }
}
$_SESSION['loginState'] = "Unsuccessful";
$_SESSION['message'] = "Incorrect username or password";
redirectBackToPreviousPage();

?>