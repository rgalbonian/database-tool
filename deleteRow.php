<?php
    include "database-connect.php";
    include "database-connect-super.php";

    $tableName = $_POST['tableName'];
    $database = $_POST['database'];
    $rowID = $_POST['rowID'];

    if ($database == "timealloc") {
    	$query = "DELETE FROM \"$tableName\" WHERE sprint = '$rowID'";
    	$database_conn = $super_conn; 
    } else {
    	$query = "DELETE FROM \"$tableName\" WHERE id = $rowID";
    	$database_conn = $conn; 
    }
    pg_query($database_conn, $query);
    // pg_close($db); 
?>