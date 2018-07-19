<?php

include "database-connect.php";
include "database-connect-super.php";
// Start the session
session_start();
if(empty($_SESSION)){
  header("location:index.php");
  exit;
}

$custom_database = "newdb";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>TEST</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 		<link rel="stylesheet" href="css/style.css">
 		<link rel="stylesheet" href="css/raised-button.css">
	</head>

	<body class="bg">
 
		<!-- header -->
		<div id="header">
			<img src="images/NOKIA_LOGO_WHITE.png" height="50">
			<a id="logoutBtn" href="logout.php"> Sign out <!--<i class="fa fa-sign-out" >--></i></a>
		</div>

		<!-- dropdown table  -->
		<div id="drpdwnContainer"  method="POST">
			<div class="btn-group">

				<div id="table-edit" style="display: none;">
					<button type="button" class="btn cancel-btn pull-right" id="cancel-rename"><i class="fa fa-times"></i></button>
					<button type="button" class="btn save-btn pull-right" id="save-new-name"><i class="fa fa-floppy-o"></i></button>
					<input type='text' id='table-new-name'>
				</div>

				<div id="table-show">
					<!-- dropdown button -->

					<button type="button" class="btn btn-default dropdown-toggle tableDrpDwn table-font" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span id="tableName">Select Table</span> 
					</button>
					<button type="button" class="btn btn-success material-button-raised" title="Create Table" id="addTable" data-toggle="modal" data-target="#addTableModal"><i class="fa fa-plus"></i></button>

					<!-- dropdown menu -->
					<ul class="dropdown-menu table-font" id="select-table">
						<li>
							<div><input type="text" id="search-table" placeholder="Search Table" class="pull-left"></div>
						</li>
						<!-- table name -->
						<div id="table-dropdown" >
						<?php 
							if ($_SESSION['user'] == "super") {
								// Superadmin privileges 
								$tableNames = pg_query($super_conn, "SELECT table_name
								FROM information_schema.tables
								WHERE table_schema='public'
								AND table_type='BASE TABLE' ORDER BY table_name");

								while($tableName = pg_fetch_assoc($tableNames)){ 
									$tableName = $tableName['table_name'];
								?>
									<li database="timealloc" data-tableID=<?php echo('"'.$tableName.'"') ?> class="table-list"> <?php echo($tableName) ?> </li>
								<?php } ?>

								<h4>Custom tables</h4>
							<?php }

							// list all custom tables;
							$tableNames = pg_query($conn, "	SELECT table_name
							FROM information_schema.tables
							WHERE table_schema='public'
							AND table_type='BASE TABLE' ORDER BY table_name");

							while($tableName = pg_fetch_assoc($tableNames)){ 
								$tableName = $tableName['table_name'];
							?>
								<li database=<?php echo('"'.$custom_database.'"') ?> data-tableID=<?php echo('"'.$tableName.'"') ?> class="table-list"><?php echo($tableName) ?></li>
						<?php } ?>
						</div>
					</ul>

					<!-- add table button -->

				</div>

				<div class='error-message'></div>

			</div>
		</div>

			<!-- Container for table -->
			<div id="display-table"></div>

		<!-- modal for adding table -->
			<div class="modal fade" id="addTableModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			    	
			    	<!-- modal header -->
				      <div class="modal-header">
				        <h5 class="modal-title pull-left" id="exampleModalLongTitle">Add Table</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>

				   <!-- modal body -->

					<form id="saveTableForm">
				     <div class="modal-body">
				      	
				      	<!-- input for table name -->
					        <div class="input-group mb-3">
								<div class="input-group-prepend pull-left">
									<span class="input-group-text" >Table Name</span>
								</div>
								<input type="text" id="inputTableName" class="form-control" aria-label="Default" required>
							</div>

								<!-- input for column -->
									<div class="colInputContainer">
										<div class="input-group colInput" >
										  
											 <!-- column name -->
											  <div class="input-group-prepend">
											    <span class="input-group-text columnLabel">Column</span>
											  </div>
										  	<input type="text" class="form-control columnName" id="columnName" placeholder="Column Name" required>
										  
										  <!-- column data type -->
											  <select class="custom-select dataType" id="dataType" data-default="" required>
											    <option selected disabled value="">Data Type</option>
											    <option value="DOUBLE PRECISION" data-default="DEFAULT 0.0">Number</option>
											    <option value="TEXT" data-default="DEFAULT ''">String</option>
											    <option value="DATE"  data-default="">Date</option>
											  </select>
										</div>
									</div>

								<!-- add column button -->
									<button type="button" class="btn addColumnBtn">Add Another Column</button>
				      </div>

				      <!-- modal footer -->
				      <div class="modal-footer">
				        <button type="button" class="btn cancel-btn2" data-dismiss="modal">Cancel</button>
				        <button type="submit" class="btn save-btn2" id="saveTable"> Save</button>
				      </div>
			      	</form>
			    
			    </div>
			  </div>
			</div>


			<!-- modal for adding column -->
			<div class="modal fade" id="addColumnModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			    	
			    	<!-- modal header -->
				      <div class="modal-header">
				      	<h5 class="modal-title pull-left">Add Column</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>

				   <!-- modal body -->

					<form id="saveColumnForm">
				     	<div class="modal-body">
				      	
								<!-- input for column -->
									<div class="colInputContainer">
										<div class="input-group colInput" >
										  
											 <!-- column name -->
											  <div class="input-group-prepend">
											    <span class="input-group-text columnLabel">Column</span>
											  </div>
										  	<input type="text" class="form-control columnName" id="columnName" placeholder="Column Name" required>
										  
										  <!-- column data type -->
											  <select class="custom-select dataType" id="dataType" data-default="" required>
											    <option selected disabled value="">Data Type</option>
											    <option value="DOUBLE PRECISION" data-default="DEFAULT 0.0">Number</option>
											    <option value="TEXT" data-default="DEFAULT ''">String</option>
											    <option value="DATE"  data-default="">Date</option>
											  </select>
										</div>
									</div>

								<!-- add column button -->
									<button type="button" class="btn addColumnBtn">Add Another Column</button>
				      	</div>

				      	<!-- modal footer -->
				      	<div class="modal-footer">
				        	<button type="button" class="btn cancel-btn2" data-dismiss="modal">Cancel</button>
				        	<button type="submit" class="btn save-btn2" id="saveColumn"> Save</button>
				      	</div>
			      	</form>
			    
			    </div>
			  </div>
			</div>


		<!-- for delete row confirmation -->
		<div class="modal fade" id="delete-row-modal" role="dialog">
			<div class="modal-dialog">
			
				<!-- Modal content-->
				<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Are you sure you want to delete this row?</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<div class="modal-footer">
					<button type="button" id="confirm-delete-btn" class="btn btn-danger" data-dismiss="modal">Confirm</button>
					<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
				</div>
				</div>
				
			</div>
		</div>
   
   
   		<div class="modal fade" id="edit-col-modal" role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
			
				<!-- Modal content-->
				<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Are you sure you want to edit this column?</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<div class="modal-footer">
					<button id="confirm-edit-col" type="button" class="btn btn-danger" data-dismiss="modal">Confirm</button>
					<button id="cancel-edit" type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
				</div>
				</div>
				
			</div>
		</div>

		<!-- for delete table confirmation -->
		<div class="modal fade" id="confirm-del-table" role="dialog">
			<div class="modal-dialog">
			
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Are you sure you want to delete this table?</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					
					<div class="modal-footer">
						<button id="del-table-btn" type="button" class="btn btn-danger" data-dismiss="modal">Confirm</button>
						<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
					</div>
				</div>
				
			</div>
		</div>

		<!-- modal for deleting column -->
		<div class="modal fade" id="delColumnModal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">

					<!-- modal header -->
					<div class="modal-header">
						<h5 class="modal-title pull-left">Delete Column</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<!-- modal body -->
					<div class="modal-body" id="delColContainer">

						<div class="input-group" id="del-col-container"></div>

						<div class="input-group" id="undo-col-container"></div>

					</div>

					<!-- modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn cancel-btn2" id="cancel-del-col" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn save-btn2" id="finish-del-col"> Save</button>
					</div>

				</div>
			</div>
		</div>

		<!-- for delete column confirmation -->
		<div class="modal fade" id="confirmDelColumnModal" role="dialog">
			<div class="modal-dialog">
			
				<!-- Modal content-->
				<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Are you sure you want to delete the selected column(s)?</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<div class="modal-footer">
					<button type="button" id="confirm-del-col-btn" class="btn btn-danger" data-dismiss="modal">Confirm</button>
					<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
				</div>
				</div>
				
			</div>
		</div>

		<div id="hidden-copies">
			<button id="edit-btn-copy" type="button" class="edit-btn" title="Edit Row"><i class="fa fa-pencil-square-o"></i></button>
			<button id="del-btn-copy" type="button" class="delete-btn" title="Delete Row"><i class="fa fa-trash"></i></button>
			<button id="save-btn-copy" type="button" class="btn btn-warning save-btn" title="Save Row"><i class="fa fa-floppy-o"></i></button>
			<button id="cancel-btn-copy" type="button" class="btn btn-info cancel-btn" title="Cancel"><i class="fa fa-times"></i></button>
		</div>


		<!-- modal for creating/editing announcements -->
		<div class="modal fade" id="announcement-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		    	
		    	<!-- modal header -->
			      <div class="modal-header">
			      	<h5 class="modal-title pull-left"></h5>
			        <button type="button" class="close cancel-announcement" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>

			   <!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<label for="announcement-title">Title:</label>
						<input type="text" class="form-control" id="announcement-title">
						<label for="announcement-content">Content:</label>
  						<textarea class="form-control" rows="10" id="announcement-content"></textarea>
  						<input type="hidden" id="announcement-date">
  						<input type="hidden" id="announcement-id">
  						<input type="hidden" id="announcement-rowid">
  						<input type="hidden" id="announcement-status">
					</div>
				</div>

				 <div class="modal-footer">
			        <button type="button" class="btn cancel-btn2 cancel-announcement" data-dismiss="modal">Cancel</button>
			        <button type="submit" class="btn save-btn2 save-announcement" data-dismiss="modal"> Save</button>
			      </div>
		      	</form>
		    </div>
		  </div>
		</div>


		<script src="js/script.js"></script>

	</body>
</html>