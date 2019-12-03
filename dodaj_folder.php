<?php
header("Location: panel.php");
$nazwa=$_POST['nazwa'];
$usr=$_COOKIE['userlogin'];
mkdir ("uzytkownicy/$usr/$nazwa", 0777);
?>