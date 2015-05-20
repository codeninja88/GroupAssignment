<?php

    echo "<div id='currentMembers'>";
    echo "Current Members";
    echo "</div>";

    echo "<form id='loginform'>";
    echo "<label class='username' for='username'>User Name:</label>";
    echo "<input type='text' name='username' id='username' size='19' placeholder='Email' />";
    echo "<br>";
    echo "<br>";
    echo "<label class='password' for='password'>Password:</label>";
    echo "<input type='password' name='password' size='19' />";
    echo "<br>";
    echo "$_SESSION[message]";
    echo "<br>";
    echo "<input type='submit' value='Login'>";
    echo "</form>";

?>