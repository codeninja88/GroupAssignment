<?php
    session_start();
    if($_SESSION['loginState'] !== "Logged in"){
        echo "<div id='signUp'>";
        echo "<a style='display:block' href='members.php'>";
        echo "Sign-Up";
        echo "</a>";
        echo "</div>";
    } else {
        echo "<div id='signUp'>";
        echo "<a style='display:block' href='members.php'>";
        echo "My Account";
        echo "</a>";
        echo "</div>";
    }
?>
