<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Teacher Management System</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div id="wrapper">


  <h2>Teacher Management System </h2>
  <h3 style="color:red;"> Add a teacher </h3>
  <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          Name <input type="text" name="name" id="name-field"><br><br>
          ID <input name="id" id="id-field"><br><br>
          Date of birth <input name="birth" id="birth-field">
          <small>YYYY-MM-DD</small><br><br>
          Email <input type="email" name="email" id="email-field"><br><br>
          Major <input type="text" name="major" id="major-field"><br><br>
          Salary <input type="number" name="salary" id="salary-field"><br><br>
          Address <input type="text" name="address"><br><br>
          Phone number <input type="tel" name="phone" id="phone-field"><br><br>
          <input name="add-btn" id="add-btn" type="submit" value="Add" style="margin-left: 420px;width:70px;">
    <br><br>
   <?php 

if ($_SERVER["REQUEST_METHOD"] == "POST"){


$name = $id = $dob = $email = $major = $salary = $address = $phone_number= "";
$name = $_POST["name"];
$id = $_POST["id"];
$dob = $_POST["birth"];
$email = $_POST["email"];
$major = $_POST["major"];
$salary = $_POST["salary"];
$address = $_POST["address"];
$phone_number = $_POST["phone"];

$con = new PDO('mysql:host=localhost;dbname=teacher;charset=utf8mb4','nader','');
$stmt = $con->prepare("INSERT INTO teacher (name,id,dob,email,major,salary,address,phone_number) VALUES(?,?,?,?,?,?,?,?)");
$stmt->execute([$name,$id,$dob,$email,$major,$salary,$address,$phone_number]);
$stmt = null;

echo "Adding Complete ..";

}
   ?>

  </form>

<a href="main_page.html">Back</a>
 
</body>
</html>