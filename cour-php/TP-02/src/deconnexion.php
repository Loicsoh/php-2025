<?php
session_start();

$_SESSION[] = "";
session_destroy(); //detruir la session
header('Location: conexion.php');
