<?php
require_once 'connect.php';
if (isset($_COOKIE['userlogin'])) {
    header ('Location: panel.php');
} 

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Strzelec</title>
</head>
<body>

<a href="http://krzysztofstrzelec.pl" style="color:black;">&lArr; Powrót do strony tytułowej</a> <br> <br>


<h4><a href="rejestracja.php" style="color:black; text-decoration:none;">&bull; Rejestracja</a></h4> <br>

<form action="test.php" method="post">
    Login: <br> <input type="text" name="login"> <br>
    Hasło: <br> <input type="password" name="haslo"> <br><br>
    <input type="submit" value="Zaloguj się">
</form> <br> <br>

<p><strong>Sitemap</strong><p>
<a href="sitemap.xml" style="color:blue; text-decoration:none;">&bull; Sitemap</a> <br>
<p><strong>Repozytorium Git</strong><p>
<a href="https://github.com/krzysztofstrzelec/z7" style="color:blue; text-decoration:none;">&bull; Git</a> <br>



</body>
</html>