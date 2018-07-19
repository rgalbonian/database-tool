<?php
	include "database-connect.php";
	include "database-connect-super.php";

  	$tableName = $_POST['tableName'];
	$rowContents = $_POST['rowContents'];
	$database = $_POST['database'];
	$database_conn = ($database == "timealloc" ? $super_conn : $conn);

	$query = "SELECT * FROM \"$tableName\"";
	$rows = pg_query($database_conn, $query);
	$column_count = pg_num_fields($rows);
		
	$query = "INSERT INTO \"$tableName\"(";
	$start = ($database == "timealloc" ? 0 : 1);
	for ($i=$start; $i < $column_count; $i++) { 
		$query .= '"'.pg_field_name($rows, $i).'"';
		if ($i != $column_count-1) {
			$query .= ', ';
		}
	}
	$query .= ") VALUES(";
	for ($i=$start; $i < $column_count; $i++) { 
		$query .= "'".$rowContents[$i-$start]."'";
		if ($i != $column_count-1) {
			$query .= ', ';
		}
	}
	$query .= ($database == "timealloc" ? ") RETURNING sprint" : ") RETURNING id");
	$return = pg_query($database_conn, $query);
	$return = pg_fetch_array($return);
	echo ($database == "timealloc" ? $return['sprint'] : $return['id']);
?>