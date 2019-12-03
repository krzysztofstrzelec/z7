<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Strzelec</title>
</head>

<body>
<?php
require_once "connect.php";
//$usr = $_COOKIE['userid'];
//if(IsSet($usr)){
 //   $query ="SELECT * FROM logi WHERE idu=$idk order by data desc limit 1";
 //   $result = mysqli_query($polaczenie, $query); 
//     $rekord1 = mysqli_fetch_array($result); 
//}
?>
<?php
$usr = $_COOKIE['userlogin'];
if(IsSet($usr)){
echo "Witamy, <strong>",$_COOKIE['userlogin'],"</strong>";
?>
<a style="margin-left:15px;" href="wyloguj.php">[Wyloguj się]</a>
<strong style="color:red;">
<?php
if(!empty($wiersz1)){
    echo "ostatnie niepoprawne logowanie: ",$wiersz1['datagodzina']," <hr>";
}
?>
</strong>
<br> <br>
<strong>Lista plików oraz katalogów</strong> <br>
<?php
$dir= "/z7/uzytkownicy/$usr";
$files = scandir($dir);
$arrlength = count($files);
for($x = 2; $x < $arrlength; $x++) {
    if (is_file("/z7/uzytkownicy/$usr/$files[$x]")){
        echo "<a href='/z7/uzytkownicy/$usr/$files[$x]' download='$files[$x]'>$files[$x]</a><br>";
    } else { 
        echo $files[$x],"<br>";
        $dir2= "/z7/uzytkownicy/$usr/$files[$x]";
        $files2 = scandir($dir2);
        $arrlength2 = count($files2);
        for($y = 2; $y < $arrlength2; $y++) {
            if (is_file("/z7/uzytkownicy/$usr/$files[$x]/$files2[$y]")){
                echo "&#8594<a href='/z7/uzytkownicy/$usr/$files[$x]/$files2[$y]' download='$files2[$y]'>$files2[$y]</a>";
            } else { 
                echo "&#8594",$files2[$y];
            }
            echo "<br>";
        }
   }
}
echo "<br>";
?>
<br> <br>
<strong>Dodawanie pliku</strong> <br>
<form action="odbierz.php" method="POST" ENCTYPE="multipart/form-data">
<?php
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if(is_dir("/z7/uzytkownicy/$usr/$file") && $file != '.' && $file != '..'){
                echo "<input type=\"radio\" name=\"folder\" value =$file>$file<br>";
            }
        }
        closedir($dh);
    }
}
?>
<input type="file" name="plik"/>
<input type="submit" value="Wyślij plik"/>
</form>
<br>
<strong>Stwórz katalog</strong> <br>
<form method="POST" action="dodaj_folder.php">
Nazwa:
<input type="text" name="nazwa">
<input type="submit" value="Stwórz folder"/>
</form>
<?php
} else {
    echo '<script>alert("Zaloguj się!")</script>';
    echo "<script>location.href='index.php';</script>";
}
?>
</body>
</html>