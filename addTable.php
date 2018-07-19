<?php
    include "database-connect.php";
    
    $query = $_REQUEST['query'];
    $addtable = pg_query($conn, $query);
    
    $tableNames = pg_query($conn, "SELECT name FROM table_names WHERE isdeleted = 'f'");
                   
?>