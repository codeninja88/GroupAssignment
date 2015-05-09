<?php
require "databaseConnect.php";
require "functions.php";
session_start();

//This page is to handle any log in/log out post requests.
//Log in requests will be redirected back to the page they came from
//  --If the user has logged in from the index - they go back to index etc.


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
    echo "The username or password is apparently blank <br />";
    $_SESSION['message'] = "Invalid username or password.";
    $_SESSION['loginState'] = "Not logged in";
    redirectBackToPreviousPage();
} else{
    //!!!!! ---> VARIABLES ARE BASED ON OLD VERSIONS OF THE SITE AND MAY BEEN TO BE CHANGED TO RETURN ANYTHING
    $userName = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM USER WHERE userEmail = '$userName' AND userPW = '$password'";
    foreach ($dbh->query($sql) as $row){
        echo "Inside the foreach <br>";
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


/*//This page will have the post request containing the user's username and password submitted to it.
$userName = $_POST['username'];
$password = $_POST['password'];

//$_SESSION
//$_POST['username']
if (!isset($userName) || !isset($password)) {
    $_SESSION['message'] = "Incorrect username and/or password";
    $_SESSION['loginState'] = "invalidDetails";
    displayLoginForm();
    } elseif (isset($_POST['username']) && isset($_POST['password'])) {
     {
        if ($row['userEmail'] == $userName && $row['userPW'] == $password) {
            if($row['userType'] == "admin"){
                $_SESSION['loginState'] = 'admin';
                $_SESSION['userFName'] = $row['userFName'];
            } elseif ($row['userType'] == "paid"){
                $_SESSION['loginState'] = 'paid';
            } else {
                $_SESSION['loginState'] = 'free';
            }

            echo "Welcome " . $row['userFName'] ;
        }
    }
    //check if there is a username in the database that goes by that name.
} else {
    $_SESSION['message'] = "Incorrect username and/or password";
    $_SESSION['loginState'] = "failed";
    displayLoginForm();
    echo $_SESSION['message'];
}


if ($_SESSION['logout'] == 'logout') {
    $_SESSION = array();
    session_destroy();
    displayLoginForm();
}
function displayLoginForm(){
    echo "<label class='username' for='username'>User Name:</label>";
    echo '<input type="text" name="username" id="username" size="15"/><br>
        <br>
        <label class="password" for="password">Password:</label>
        <input type="password" size="15"/><br>
        <br>
        <input type="submit" value="Login">
        <a href="members.html">Or sign-up</a>';
}


redirectBackToPreviousPage();*/

?>