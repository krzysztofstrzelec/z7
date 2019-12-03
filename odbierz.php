<?php
$usr=$_COOKIE['userlogin'];
$sciezka=$_POST['folder'];
if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
    if(IsSet($sciezka)) {
        move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."z7/uzytkownicy/$usr/$sciezka/".$_FILES['plik']['name']);
    } else {
        move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."z7/uzytkownicy/$usr/".$_FILES['plik']['name']);
    }
}
header("Location: panel.php");
?>