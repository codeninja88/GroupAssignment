<?php
include('databaseConnect.php');
include_once('functions.php');
/*This gives us our database object*/

if ($_POST['submit'] === "Add New Artist") {
    echo "Submitted: <br />";
    echo "<br> ";
    addArtist();
    echo "<br>Adding attempted.";
} elseif ($_POST['delete']) {
    $sentVariable = $_POST['delete'];
    echo "Delete selected: $sentVariable sent";
    deleteArtist($_POST['delete']);
} elseif ($_POST['edit']) {

    echo "Edit was selected for: " . $_POST['edit'];
} elseif ($_POST['confirm']) {
    confirmUpdate();

} else {
    echo "This hasn't come from form submission <br/ >";
}


?>

    <!DOCTYPE html>
    <html>
    <head lang="en">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <?php


    foreach ($dbh->query($sql) as $row) {
        echo $row['artistGroup'] . "</br>";

    }

    displayArtists();
    echo "Following the calling of display artist";

    ?>



    <form action="firstPage.php" method="post">
        <table>
            <tr>
                <td>Group Name:</td>
                <td><input type="text" name="artistGroup" value="" placeholder="Group name" required></td>
            </tr>
            <tr>
                <td>Summary:</td>
                <td><input type="text" name="artistSummary" value="" placeholder="Group summary" required></td>
            </tr>
            <tr>
                <td> Description:</td>
                <td><input type="text" name="artistDesc" value="" placeholder="Group description" required></td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td><input type="tel" name="artistPhone" value="" placeholder="Phone number"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="artistEmail" value="" placeholder="someone@somewhere.com"></td>
            </tr>
            <tr>
                <td>Website:</td>
                <td><input type="url" name="artistWeb" value="" placeholder="www.mySite.com"></td>
            </tr>
            <tr>
                <td>Image:</td>
                <td><input type="image" name="artistImg" value=""></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Add New Artist"></td>
            </tr>
        </table>
    </form>


    </body>
    </html>

<?php $dbh = null; ?>