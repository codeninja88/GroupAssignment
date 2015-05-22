<?php
require("databaseConnect.php");
require("functions.php");
session_start();
//Going to take a POST form with information of a user, check that information and
//if correct it is going to add the information and log the user in.
//Required fields in the form
$username = $_POST['username'];
$usernameConfirmation = $_POST['confirmationEmail'];
$password = $_POST['password'];
$userFName = $_POST['userFName'];
$userLName = $_POST['userLName'];
$userType = "casual";
$userSignupDateArray = getdate();
$userSignupDate = $userSignupDateArray['mday'] . "/" . $userSignupDateArray['mon'] . "/" . $userSignupDateArray['year'];
// THIS NEEDS TO BE CHANGED when we have fields that accept them.
$userAddress = "";
$userMobile = "";
//_________________________

//not required fields
$userPrimaryPhone = $_POST['userPrimaryPhone'];
$userSecondaryPhone = $_POST['userSecondaryPhone'];

$usernameValid = false;

$compareTo = "someone";

if($username !== $usernameConfirmation){
    //set the session error message.
    $usernameValid = false;

}

//read from the database and check that the username doesn't exist

echo "<h1>Adding user account page:</h1>";
$sql = "SELECT userEmail FROM USER";
foreach ($dbh->query($sql) as $row) {
    if ($row['userEmail'] === $compareTo) {
        echo "<strong>$row[userEmail]</strong> email found in DB.<br />";
        $usernameValid = true;
        redirectBackToPreviousPage();
    } else {
        echo "$row[userEmail] <br />";
    }
}

if(!$usernameValid){
    //The email is not in the database.
    echo "Sign up date: $userSignupDate";
    echo "Add the account to the database <br />";
    echo "<br>Congratulations $compareTo is unique<br>";
    $sql = "INSERT INTO USER(userEmail, userFName, userLName, userType, userAddress, userPrimPhone, userSecPhone, userMobile, userSUDate, userPW)
            VALUES('$username', '$userFName', '$userLName', '$userType', '$userAddress', '$userPrimaryPhone', '$userSecondaryPhone', '$userMobile', '$userSignupDate', '$artistImg')";
    //$dbh->exec($sql);
    redirectBackToPreviousPage();
} else {
    //The email exists in the database.
    echo "<span style='color: red'><strong>ERROR. that username exists in the database.</strong></span>";
}

echo "<a href='loginTrial.php'>Back to the login trial</a>";
echo "This is where you'd redirect back to the previous page.";
//redirectBackToPreviousPage();
?>