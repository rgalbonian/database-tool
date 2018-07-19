<?php
    include "database-connect.php";

    $tableName = $_REQUEST['tableName'];
    $deleteTable = pg_query($conn, "DROP TABLE \"$tableName\"");

?>