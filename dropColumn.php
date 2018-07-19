<?php
    include "database-connect.php";

    $tableName = $_POST['tableName'];
    $columnNames = $_POST['columnNames'];

    foreach ($columnNames as $columnName) {
    	pg_query($conn, "ALTER TABLE \"$tableName\" DROP COLUMN \"$columnName\"");
    }
    // pg_close($db); 
?>