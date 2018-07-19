<?php
    include "database-connect.php";
   	pg_query($conn, $_REQUEST['query']);

?>