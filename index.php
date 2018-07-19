<?php
// Start the session
session_start();
if(!empty($_SESSION['user'])){
  header("location:home_page.php");
  exit;
}
?>
<html class="login-page">
	<head> 
		<link rel="stylesheet" href="css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

	<body>
  	<div class="container center">
			<form action="index.php" method="post" id="login-form" onsubmit="return checkPassword()">
				<button type="button" class="user-btn selected" value="admin">ADMIN</button>
				<button type="button" class="user-btn" value="super">SUPER</button>
				<input type="hidden" name="username" id="username" value="admin">
				<input type="password" id="password" name="password" class="password" placeholder="Enter Password">
				<button type="submit" name="login" class="login-btn"> <span>Login </span> </button>
			</form>
		</div>
	</body>
		<script src="js/script.js"></script>

</html>

<?php
	
	if (isset($_POST['login'])){
	    $username = $_POST['username'];
	    $inputPassword = $_POST['password'];
     	$folder = "password/";
		$file = fopen($folder.$username.".php", "r") or exit("Unable to open file!");
		fseek($file, 12);
		$password = fgets($file, 61);
		fclose($file);
      
	    if(password_verify($inputPassword, $password)){
	        $_SESSION['user'] = $username;
	        alert("you created a session");
	        header("location:home_page.php");
	    }
	    else{
	        alert("Invalid Password");
	        // header("location:index.php");
	    }
	}

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>
