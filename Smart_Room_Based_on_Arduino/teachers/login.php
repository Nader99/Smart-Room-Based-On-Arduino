<?php
session_start();

echo $_SESSION["name"];
echo $_SESSION["username"];
echo $_SESSION["password"];
echo $_SESSION["email"];

if ( $_POST["username"] == $_SESSION["username"] && $_POST["password"] == $_SESSION["password"] ){
    header('Location: main_page.html');
}else{
    header('Location: login_page.php');
}
?>