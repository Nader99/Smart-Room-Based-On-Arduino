<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Teacher Management System</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
  table, th, td {
  border: 1px solid black;
}
  </style>
</head>
    <body>
	<h2>Teacher Management System </h2>
    <h3 style="color:red;"> View all teachers </h3>
        <table >
		<tr>
		<th class="left">Name</th>
		<th class="left">ID</th>
		<th class="left">DOB</th>
		<th class="left">Email</th>
		<th class="left">Major</th>
		<th class="left">Salary</th>
		<th class="left">Address</th>
		<th class="left">PhoneNumber</th>
		<tr>
		
        <?php 
		$con = new PDO('mysql:host=localhost;dbname=teacher;charset=utf8mb4','nader','');
		$stmt = $con->query('SELECT * FROM teacher');
 
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo "<tr>";
			echo "<td>".$row['name']."</td>";
			echo "<td>".$row['id']."</td>";
			echo "<td>".$row['dob']."</td>";
			echo "<td>".$row['email']."</td>";
			echo "<td>".$row['major']."</td>";
			echo "<td>".$row['salary']."</td>";
			echo "<td>".$row['address']."</td>";
			echo "<td>".$row['phone_number']."</td>";
			echo "<tr>";
		}
		?>
		
		</table>
		<br>
		<a href="main_page.html">Back</a>
        </body>
</html>