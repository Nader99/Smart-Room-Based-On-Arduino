<?php

session_start();

$nameErr = $emailErr = $passErr = $userErr = "";
$name = $email = $pass = $user = "";

try{

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    throw new Exception("$name name is required");
    $nameErr = "Name is required";
  } 
  
  if (empty($_POST["email"])) {
    throw new Exception("$email email is required");
    $emailErr = "Email is required";
  } 
    
  if (empty($_POST["username"])) {
    throw new Exception("$user username is required");
    $userErr= "Username is required";
  } 


  if (empty($_POST["password"])) {
    throw new Exception("$pass password is required");
    $passErr = "Password is required";
  } 
}
}catch(exeption $e){
  echo "The Exception is: ".$e->getMessage()."<br/>";
}

if (!empty($_POST["name"]) && !empty($_POST["password"]) && !empty($_POST["username"]) && !empty($_POST["password"])){
  header('Location: login_page.php');
$_SESSION["name"]=$_POST["name"];
$_SESSION["username"]=$_POST["username"];
$_SESSION["password"]=$_POST["password"];
$_SESSION["email"]=$_POST["email"];
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}




?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Teacher Management System</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
.error {
  color: #FF0000;
}
</style> 
</head>
<body>
 <div id="main_page">
     <div id="con">
     <div id="header">
     <h1>Teacher Management System</h1>
     <h1 style="display:inline;color:red;"> Sign Up</h1>
     </div>
     <div id="content">
     <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
        <h3 style="display:inline;margin-left: 60px;">Name</h2>
        <input style="margin-left: 30px;" type="text" name="name"><span class="error">*<?phpecho $nameErr;?></span><br>
        <h3 style="display:inline;margin-left: 60px;">Username</h2>
        <input style="margin-left: 30px;" type="text" name="username"><span class="error">*<?php echo $userErr;?></span><br>
        <h3 style="display:inline;margin-left: 60px;">Password</h2>
        <input style="margin-left: 30px;" type="password" name="password"><span class="error">*<?php echo $passErr;?></span><br>
        <h3 style="display:inline;margin-left: 60px;">Email</h2>
        <input style="margin-left: 30px;" type="email" name="email"><span class="error">*<?php echo $emailErr;?></span><br><br>
        <button type="submit" style="width:120px;height:40px;margin-left:60px;" >Sign up</button>

    </form>

         </div>
         </div>
  </div>   

</body>



</html>
