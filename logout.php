<?php

session_start();

unset($_SESSION["admin"]);
unset($_SESSION["password"]);

session_destroy();
header('location:http://localhost/OnlineSchool/admin/');
exit();

?>