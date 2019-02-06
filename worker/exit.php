<?php
setcookie("session", "", time()+3600, "/","", 0);
setcookie("userName", "", time()+3600, "/","", 0);
header("Location: http://127.0.0.1");

?>
