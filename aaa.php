<!DOCTYPE html>
<html>

<head>
	  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<p>Click the button to open a new browser window.</p>
<button id="click" onclick="clicking()"> Click! </button>
<script>

for ( var i = 1; i <= 9; i++){
$("body").append("<div></div>");
$("div:last-child").load("http://upcat.stickbread.net/page-00" + i + ".html table:nth-child(4)");
//console.log("http://upcat.stickbread.net/page-00" + i + ".html table");
}

for ( var i = 10; i <= 99; i++){
$("body").append("<div></div>");
$("div:last-child").load("http://upcat.stickbread.net/page-0" + i + ".html table:nth-child(4)");
//console.log("http://upcat.stickbread.net/page-00" + i + ".html table");
}


for ( var i = 100; i <= 259; i++){
$("body").append("<div></div>");
$("div:last-child").load("http://upcat.stickbread.net/page-" + i + ".html table:nth-child(4)");
//console.log("http://upcat.stickbread.net/page-00" + i + ".html table");
}

var x=0;
function clicking(){

var results = "";
$("body").find("table").find("tr").each(function(){
	  console.log("here");
  if($(this).find("td:nth-child(3)").find("span").text() == "BA HISTORY" &&
	   $(this).find("td:nth-child(2)").find("span").text() == "VISAYAS"){
		results += $(this).find("td:nth-child(1)").find("span").text() + "\n";
   x++;
	}
});
  console.log(x);
  console.log(results);
}
console.log("rhevie");
</script>

</body>
</html>
