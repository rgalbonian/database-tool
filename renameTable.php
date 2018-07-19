<?php
    include "database-connect.php";

    $newTableName = $_POST['newTableName'];
    $oldTableName = $_POST['oldTableName'];

    pg_query($conn, "ALTER TABLE \"$oldTableName\" RENAME TO \"$newTableName\"");
    // pg_close($db); 
?>