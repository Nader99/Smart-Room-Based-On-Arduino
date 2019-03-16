<html>
<head>
</head> 
<body>
<?php

$con = new PDO('mysql:host=localhost;dbname=teacher;charset=utf8mb4','nader','');

if (!$con){
die("can not connect :".mysql_error());	
}	

?>
</body>
</html>