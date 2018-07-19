<?php
    include "database-connect.php";

    $tableName = $_POST['tableName'];
    $prevVal = $_POST['prevVal'];
    $newVal = $_POST['newVal'];

    pg_query($conn, "ALTER TABLE \"$tableName\" RENAME COLUMN \"$prevVal\" TO \"$newVal\"");
    // pg_close($db); 
?>