<?php
require_once "include.php";

unset($_SESSION['email']);
unset($_SESSION['first']);

session_destroy();
header('Location: index.php');
?>
