<?php
error_reporting( 0 );
$adresip = $_SERVER["REMOTE_ADDR"];
function ip_details($ip) {
    $json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
    $details = json_decode ($json);
    return $details;
}
$details = ip_details($adresip);
$ip = $details -> ip;

$data = date("Y-m-d H:i:s", time());
$login = strtolower($_POST['login']);
$haslo = $_POST['haslo'];
 
 require_once('connect.php');
 

 $zapytanie_uzytkownik = "SELECT * FROM uzytkownicy WHERE login='$login'";
 $rezultat = mysqli_query($polaczenie, $zapytanie_uzytkownik);
 $wiersz_uzytkownik = mysqli_fetch_array($rezultat);
 $idu = $wiersz_uzytkownik[0];
 $user = $wiersz_uzytkownik[1];
 $haslo_baza = $wiersz_uzytkownik[2];

 $zapytanie_logi = "SELECT * FROM bledne_logi WHERE idu='$idu'";
 $rezultat = mysqli_query($polaczenie, $zapytanie_logi); 
 $wiersz_logi = mysqli_fetch_array($rezultat);
 $proba = $wiersz_logi[3] ;
 
if(!$wiersz_uzytkownik) {
    echo '<script>alert("Nie ma takiego użytkownika!")</script>';
    echo "<script>location.href='wyloguj.php';</script>";

} else { 
    if($haslo==$haslo_baza) {  
        $spr=substr($proba, 0, 2);
        if($spr=="b-") {
            $czasBlokady = substr($proba, 2);
            if(time() < $czasBlokady) {
                echo "<b><font color=\"red\">Konto jest zablokowane<br>Wpisano błędne hasło 3 razy!<br>Zostanie odblokowane: ",date("Y-m-d H:i:s ", $czasBlokady),"</font></b>"; 
                sleep(5);
                echo "<script>location.href='wyloguj.php';</script>";
            } else {
                if ((!isset($_COOKIE['id'])) || ($_COOKIE['id']!=$idu)) {
                    setcookie("id", $idu, mktime(23,59,59,date("m"),date("d"),date("Y")));
                    setcookie("login", $user, mktime(23,59,59,date("m"),date("d"),date("Y")));
                }
                mysqli_query($polaczenie, "INSERT INTO logi (datagodzina, ip, idu) VALUES ('$data','$ip','$idu')");
                mysqli_query($polaczenie, "UPDATE bledne_logi SET proba='0' WHERE idu='$idu'");
                header('Location: panel.php');
            }
        } else {
              if ((!isset($_COOKIE['id'])) || ($_COOKIE['id']!=$idu)) {
                    setcookie("id", $idu, mktime(23,59,59,date("m"),date("d"),date("Y")));
                    setcookie("login", $user, mktime(23,59,59,date("m"),date("d"),date("Y")));
                }
              mysqli_query($polaczenie, "INSERT INTO logi (datagodzina, ip, idu) VALUES ('$data','$ip','$idu')");
            mysqli_query($polaczenie, "UPDATE bledne_logi SET proba='0' WHERE idu='$idu'");
              header("Location: panel.php");
        }
    } else {  
        if ($proba=='2') {
            $proba="b-".strtotime("+2 minutes", time());      
            mysqli_query($polaczenie, "UPDATE bledne_logi SET proba='$proba',datagodzina='$data' WHERE idu='$idu'");
        }
        if(substr($proba, 0, 2) == "b-"){
            $czasBlokady = substr($proba, 2);
            if(time() < $czasBlokady){
                echo "<font color=\"red\">Konto zostało zablokowane<br>Wpisano błędne hasło 3 razy!<br>Zostanie odblokowane: ",date("Y-m-d H:i:s ", $czasBlokady),"</font>"; 
            } else {
                mysqli_query($polaczenie, "UPDATE bledne_logi SET proba='1',datagodzina='$data' WHERE idu='$idu'");
                echo '<script>alert("Błędne hasło!")</script>';
                //echo "<b>Niepoprawne hasło!<br><br></b>";
				//echo "Za chwile wrócisz do strony logowania";
				//sleep(5);
                echo "<script>location.href='wyloguj.php';</script>";
                //header ('Refresh:0; url=wyloguj.php');

            }
        } else {  
            if (IsSet($proba)) {
                $proba=$proba+1;
                mysqli_query($polaczenie, "UPDATE bledne_logi SET proba='$proba',datagodzina='$data' WHERE idu='$idu'");
                echo '<script>alert("Błędne hasło! Twoje konto niedługo zostanie czasowo zablokowane!")</script>';
                //echo "<b>Niepoprawne hasło!<br><br></b>";
				//echo "Za chwile wrócisz do strony logowania";
				//sleep(10);
                echo "<script>location.href='wyloguj.php';</script>";
            } else {
                $proba=$proba+1;
                mysqli_query($polaczenie, "INSERT INTO bledne_logi (datagodzina, ip, proba, idu) VALUES ('$data','$ip', '$proba' ,'$idu')");
                echo '<script>alert("Błędne hasło!")</script>';
                //echo "<b>Niepoprawne hasło!<br><br></b>";
                //sleep(5);
                echo "<script>location.href='wyloguj.php';</script>";	   
                //header ('Refresh:0; url=wyloguj.php');
                //echo "$user";
            }
        }
         mysqli_close($polaczenie);
         echo "<a href=\"wyloguj.php\">Powrót</a>";
    }
}
?>
