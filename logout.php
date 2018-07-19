<?php
if (session_start() AND session_destroy()){
  echo "You have been logged out." ?> <html>
<meta http-equiv="refresh" content="0;url=index.php" />
</html>
<?php
}