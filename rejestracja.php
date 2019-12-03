<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Strzelec</title>
</head>
<body>

<a href="index.php">Powrót</a> <br> <br>
<h3>Zarejestruj się</h3>
<form method="POST">
Login: <br> <input type="text" name="login">  <br>
Hasło: <br> <input type="password" name="haslo"> <br>
Powtórz hasło: <br> <input type="password" name="haslo2"> <br>
<input type="submit" value="Zarejestruj się">
</form>

<?php
require_once 'connect.php';
$login = $_POST['login'];
$haslo = $_POST['haslo'];
$haslo2 = $_POST['haslo2'];

if($login && $haslo && $haslo2) {
    $sprawdzenie = true;
    if ($haslo != $haslo2) {
        $sprawdzenie = false;
        echo '<span style="color:red;">Hasła nie są identyczne!</span>';
    }
     
     $login_check = mysqli_query ($polaczenie, "SELECT * FROM uzytkownicy WHERE login='$login'");
     if ($login_check->num_rows>0) {
        $sprawdzenie = false;
        echo '<script>alert("Istnieje użytkownik o takiej nazwie. Wybierz inną nazwę!")</script>';     }
    
    if ($sprawdzenie==true) {
        $zapytanie = "INSERT INTO uzytkownicy (login, haslo) VALUES ('".$login."', '".$haslo."')";
        $polaczenie->query($zapytanie);
        mkdir ("uzytkownicy/$login", 0777);
        echo '<script>alert("Pomyślnie zarejestrowano użytkownika")</script>';
    }
}
    
?>
</body>
</html>