<?php
$dbhost="serwer1915904.home.pl"; 
$dbuser="31568758_lab7"; 
$dbpassword="zaq1@WSX"; 
$dbname="31568758_lab7";
    
$polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

if (!$polaczenie) {
    echo "Błąd połączenia z MySQL." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
?>