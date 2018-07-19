<?php 
	include "database-connect.php";
	include "database-connect-super.php";

	$tableName = $_POST['tableName'];
	$database = $_POST['database'];

	$editDeleteAddRowOnly = array('admin_announcements');

	if ($database == "timealloc") {
		$query = "SELECT * FROM \"$tableName\"";
		$rows = pg_query($super_conn, $query); 
		$start_index = 0;
	} else {
		$query = "SELECT * FROM \"$tableName\" ORDER BY id";
		$rows = pg_query($conn, $query); 
		$start_index = 1;
	}
	
	$editable = (($database == "timealloc" || in_array($tableName, $editDeleteAddRowOnly)) ? "" : "contenteditable");
	$column_count = pg_num_fields($rows);
	$index = $start_index;
	$displayOnly = true;

	if ($database == "timealloc") {
		for ($i=0; $i < $column_count; $i++) { 
			if (pg_field_name($rows, $i) == "sprint") {
				$displayOnly = false;
				break;
			}
		}
	} else {
		$displayOnly = false;
	}
?>
<div class="tbl-header" displayOnly=<?php echo($displayOnly)?> >
	<table class="table table-condensed" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<?php while($index < $column_count) { 
					$field_name = pg_field_name($rows, $index++);
				?>
					<th <?php echo($editable)?> class="tableHeader" title=<?php echo('"'.$field_name.'"')?>> <?php echo($field_name)?></th>
				<?php } 
				if (!$displayOnly) {
				?>
					<th>
					<?php if ($database != "timealloc" && !in_array($tableName, $editDeleteAddRowOnly)) { ?>
						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle pull-right table-ellipsis" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						  	</button>
						  	
						  	<ul class="dropdown-menu table-ellipsis-menu" aria-labelledby="dropdownMenu1" id="other-options">
						    	<li class="rename-table"><a>Rename Table</a></li>
						    	<li><a data-toggle="modal" data-target="#confirm-del-table">Delete Table</a></li>
						    	<li><a id="add-col-btn" data-toggle="modal" data-target="#addColumnModal"> Add Column </a></li>
						    	<li id="del-col-modal"><a> Delete Column </a></li>
						  	</ul>
						</div>
					<?php } ?>
					</th>
				<?php } ?>
			</tr>
		</thead>
   </table>
</div>
<div class="tbl-content">
   	<table id=<?php echo('"'.$tableName.'"') ?> "" class="table table-condensed" cellpadding="0" cellspacing="0" border="0">
    <tbody>
			<?php 
				$rowNum = 1;
				while($row = pg_fetch_array($rows)){ 
					$index = $start_index;
					$rowDBID = "";
					if (!$displayOnly) {
						$rowDBID = ($database == "timealloc" ? $row['sprint'] : $row['id']);
					}
					
			?>
					<tr id=<?php echo('"'.$tableName."-row".$rowNum++.'"') ?> class="data-row" data-rowDbID=<?php echo('"'.$rowDBID.'"') ?>>
						<?php while($index < $column_count) { 
							$data = $row[$index];
						?>
							<td class="data" data-type=<?php echo(pg_field_type($rows, $index++)) ?> title=<?php echo('"'.$data.'"') ?> ><?php echo($data)?></td>
						<?php } 

						if (!$displayOnly) { ?>
							<td>
								<button type="button" class="btn btn-primary edit-btn" title="Edit Row"><i class="fa fa-pencil-square-o"></i></button>
								<button type="button" class="btn btn-danger delete-btn" title="Delete Row"><i class="fa fa-trash"></i></button>
							</td>
						<?php } ?>
					</tr>

			<?php } ?>
		</tbody>
	</table>
</div>
<div class="tbl-footer">
	<?php if (!$displayOnly) { ?>
		<tr><td><button type="button" class="btn add-row-btn" title="Add Row">Add Row</button></td></tr>
	<?php } ?>
</div>
	<div style="display: none">
		<table>
			<tr id="row-copy" class="data-row">
				<?php 
					$index = $start_index;
					while($index != $column_count) {?>
						<td class="data" data-type=<?php echo(pg_field_type($rows, $index++)) ?>></td>
					<?php } ?>
					<td></td>
			</tr>
		</table>
	</div>	
