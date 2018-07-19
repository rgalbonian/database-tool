<html>
enter new password for the system : 
<form method="post" onsubmit="check()">
	<br>
	admin: <input type="text" name="admin" id="admin">
	<br>
	super: <input type="text" name="super" id="super">
	<br><br>
	<input type="submit" name="save" value="Save">
</form>
<script type="text/javascript">
	 function check(){
    if (document.getElementById("admin").value == "" || document.getElementById("super").value == ""){
        alert("Please enter password.");
        return false;
    }else{
        return true;
    }
}
</script>

<?php
	if (isset($_POST['save'])){
    $admin = $_POST['admin'];
    $admin_hash = password_hash($admin, PASSWORD_DEFAULT);
   
    $afile = fopen("password/admin.php", "w") or die("Error!");
	fwrite($afile, "<?php \$r = '");
  	fwrite($afile, $admin_hash);
  	fwrite($afile, "';
  		header('location:../index.php');
  		exit;
		?>");
	fclose($afile);}

	if (isset($_POST['save'])){
    $super = $_POST['super'];
    $super_hash = password_hash($super, PASSWORD_DEFAULT);
   
    $sfile = fopen("password/super.php", "w") or die("Error!");
	fwrite($sfile, "<?php \$r = '");
  	fwrite($sfile, $super_hash);
  	fwrite($sfile, "';
  		header('location:../index.php');
  		exit;
		?>");
	fclose($sfile);
}
?>
</html>