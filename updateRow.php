<?php
	include "database-connect.php";
	include "database-connect-super.php";
	
	$tableName = $_POST['tableName'];
	$rowID = $_POST['rowID'];
	$rowContents = $_POST['rowContents'];
	$database = $_POST['database'];

	$database_conn = ($database == "timealloc" ? $super_conn : $conn);

	$query = "SELECT * FROM \"$tableName\"";
	$rows = pg_query($database_conn, $query);
	$column_count = pg_num_fields($rows);
		
	$query = "UPDATE \"$tableName\" SET ";
	$start = ($database == "timealloc" ? 0 : 1);
	for ($i=$start; $i < $column_count; $i++) { 
		$query .= "\"". pg_field_name($rows, $i) . "\" = '" . $rowContents[$i-$start] . "'";
		if ($i != $column_count-1) {
			$query .= ', ';
		}
	}

	$query .= ($database == "timealloc" ? " WHERE sprint = '$rowID'" : " WHERE id = $rowID");
	pg_query($database_conn, $query);
	echo $query;
?>