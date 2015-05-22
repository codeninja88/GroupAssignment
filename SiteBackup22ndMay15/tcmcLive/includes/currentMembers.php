<?php
session_start();
include_once("databaseConnect.php");


if ($_SESSION['loginState'] !== "Logged in") {
    echo "<div id='currentMembers'>";
    echo "Current Members " . $_SESSION['loginState'];
    echo "</div>";

    echo "<form id='loginform' action='../tcmcLive/loginStateHandler.php', method='post'>";
    echo "<label class='username' for='username'>User Name:</label>";
    echo "<input type='text' name='username' id='username' size='19' placeholder='someone@somewhere.com' />";
    echo "<br>";
    echo "<br>";
    echo "<label class='password' for='password'>Password:</label>";
    echo "<input type='password' name='password' size='19' />";
    echo "<br>";
    echo "<br>";
    echo "<input type='submit' value='Login'>";
    echo "</form>";
} else {
    echo "<div id='currentMembers'>";
    echo "Welcome, " . $_SESSION['userFName'] . "!";
    echo "</div>";

    echo "<!-- Originally loginForm -->";
    echo "<form id='loginform' action='../tcmcLive/loginStateHandler.php' method='post'>";
//    echo "<label class='username' for='username'>User Name:</label>";
//    echo "<input type='text' name='username' id='username' size='19' placeholder='Email' />";
    echo "<br />";
    echo "<br />";
    echo "Member type:" . $_SESSION['userType'];
    echo "<br>";
//    echo "<label class='password' for='password'>Password:</label>";
//    echo "<input type='password' name='password' size='19' />";
    echo "<br>";
    echo "<br>";
    echo "<input type='submit' name='Logout' value='Logout'>";
    echo "</form>";
}

?>