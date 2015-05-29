<?php try {
    $dbh = new PDO("sqlite:TCMC_DB.sqlite");
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>