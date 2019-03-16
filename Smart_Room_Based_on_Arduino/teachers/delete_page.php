<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Teacher Management System</title>
  <link rel="stylesheet" href="css/style.css">
</head>
    <body>
    <h2>Teacher Management System </h2>
    <h3 style="color:red;"> Delete a teacher </h3>
    <form id="main-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    ID  <input name="id" id="id-field"style="width:200px;"> <input name="del-btn" type="submit" value="Delete"style="width:200px;"><br><br>
     
        <?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    $id = $_POST["id"];
                    $con = new PDO('mysql:host=localhost;dbname=teacher;charset=utf8mb4','nader','');
                    $stmt = $con->prepare("DELETE FROM teacher WHERE id = ?");
                    $stmt->execute([$id]);
                    $stmt = null;
                    echo "Deleting Complete ..<br>";
                    } ?>

<?php 
		$con = new PDO('mysql:host=localhost;dbname=teacher;charset=utf8mb4','nader','');
		$stmt = $con->query('SELECT * FROM teacher');
 
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo "<tr>";
			echo "<td>".$row['name']." </td>";
			echo "<td>".$row['id']."</td>";
			echo "<tr><br>";
		}
		?>
    </form>
        <br>
        <a href="main_page.html">Back</a>
    </body>
</html>