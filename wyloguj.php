<?php
unset($_COOKIE['userlogin']);
unset($_COOKIE['userid']);
setcookie("userlogin", "", time() - 3600);
setcookie("userid", "", time() - 3600);
header('Location: index.php');

?>